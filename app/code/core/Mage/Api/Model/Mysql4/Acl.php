<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Api
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */


/**
 * Resource model for admin ACL
 *
 * @category   Mage
 * @package    Mage_Api
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mage_Api_Model_Mysql4_Acl extends Mage_Core_Model_Mysql4_Abstract
{

    /**
     * Initialize resource connections
     *
     */
    protected function _construct()
    {
        $this->_init('api/role', 'role_id');
    }

    /**
     * Load ACL for the user
     *
     * @param integer $userId
     * @return Mage_Api_Model_Acl
     */
    function loadAcl()
    {
        $acl = Mage::getModel('api/acl');

        Mage::getSingleton('api/config')->loadAclResources($acl);

        $roleTable = Mage::getSingleton('core/resource')->getTableName('api/role');
        $rolesArr = $this->_getReadAdapter()->fetchAll(
                        $this->_getReadAdapter()->select()
                            ->from($this->getTable('role'))
                            ->order(array('tree_level', 'role_type'))
                    );
        $this->loadRoles($acl, $rolesArr);

        $rulesArr =  $this->_getReadAdapter()->fetchAll(
                        $this->_getReadAdapter()->select()
                            ->from(array('r'=>$this->getTable('rule')))
                            ->joinLeft(
                                array('a'=>$this->getTable('assert')),
                                'a.assert_id=r.assert_id',
                                array('assert_type', 'assert_data')
                            ));
        $this->loadRules($acl, $rulesArr);
        return $acl;
    }

    /**
     * Load roles
     *
     * @param Mage_Api_Model_Acl $acl
     * @param array $rolesArr
     * @return Mage_Api_Model_Mysql4_Acl
     */
    function loadRoles(Mage_Api_Model_Acl $acl, array $rolesArr)
    {
        foreach ($rolesArr as $role) {
            $parent = $role['parent_id']>0 ? Mage_Api_Model_Acl::ROLE_TYPE_GROUP.$role['parent_id'] : null;
            switch ($role['role_type']) {
                case Mage_Api_Model_Acl::ROLE_TYPE_GROUP:
                    $roleId = $role['role_type'].$role['role_id'];
                    $acl->addRole(Mage::getModel('api/acl_role_group', $roleId), $parent);
                    break;

                case Mage_Api_Model_Acl::ROLE_TYPE_USER:
                    $roleId = $role['role_type'].$role['user_id'];
                    if (!$acl->hasRole($roleId)) {
                        $acl->addRole(Mage::getModel('api/acl_role_user', $roleId), $parent);
                    } else {
                        $acl->addRoleParent($roleId, $parent);
                    }
                    break;
            }
        }

        return $this;
    }

    /**
     * Load rules
     *
     * @param Mage_Api_Model_Acl $acl
     * @param array $rulesArr
     * @return Mage_Api_Model_Mysql4_Acl
     */
    function loadRules(Mage_Api_Model_Acl $acl, array $rulesArr)
    {
        foreach ($rulesArr as $rule) {
            $role = $rule['role_type'].$rule['role_id'];
            $resource = $rule['resource_id'];
            $privileges = !empty($rule['privileges']) ? explode(',', $rule['privileges']) : null;

            $assert = null;
            if (0!=$rule['assert_id']) {
                $assertClass = Mage::getSingleton('api/config')->getAclAssert($rule['assert_type'])->getClassName();
                $assert = new $assertClass(unserialize($rule['assert_data']));
            }
            try {
                if ( $rule['permission'] == 'allow' ) {
                    $acl->allow($role, $resource, $privileges, $assert);
                } else if ( $rule['permission'] == 'deny' ) {
                    $acl->deny($role, $resource, $privileges, $assert);
                }
            } catch (Exception $e) {
                //$m = $e->getMessage();
                //if ( eregi("^Resource '(.*)' not found", $m) ) {
                    // Deleting non existent resource rule from rules table
                    //$cond = $this->_write->quoteInto('resource_id = ?', $resource);
                    //$this->_write->delete(Mage::getSingleton('core/resource')->getTableName('admin/rule'), $cond);
                //} else {
                    //TODO: We need to log such exceptions to somewhere like a system/errors.log
                //}
            }
            /*
            switch ($rule['permission']) {
                case Mage_Api_Model_Acl::RULE_PERM_ALLOW:
                    $acl->allow($role, $resource, $privileges, $assert);
                    break;

                case Mage_Api_Model_Acl::RULE_PERM_DENY:
                    $acl->deny($role, $resource, $privileges, $assert);
                    break;
            }
            */
        }
        return $this;
    }

}

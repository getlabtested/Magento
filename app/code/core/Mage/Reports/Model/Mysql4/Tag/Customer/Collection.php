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
 * @package     Mage_Reports
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Report Customers Tags collection
 *
 * @category   Mage
 * @package    Mage_Reports
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Mage_Reports_Model_Mysql4_Tag_Customer_Collection extends Mage_Tag_Model_Mysql4_Customer_Collection
{

    public function addTagedCount()
    {
        $this->getSelect()
            ->columns(array('taged' => 'count(tr.tag_relation_id)'));
            //->order('taged desc');
        return $this;
    }

    public function getSelectCountSql()
    {
        $countSelect = clone $this->getSelect();
        $countSelect->reset(Zend_Db_Select::ORDER);
        $countSelect->reset(Zend_Db_Select::GROUP);
        $countSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $countSelect->reset(Zend_Db_Select::LIMIT_OFFSET);

        $sql = $countSelect->__toString();

        $sql = preg_replace('/^select\s+.+?\s+from\s+/is', 'select count(DISTINCT tr.customer_id) from ', $sql);

        return $sql;
    }

    public function setOrder($attribute, $dir='desc')
    {
        switch( $attribute ) {
            case 'taged':
                $this->getSelect()->order($attribute . ' ' . $dir);
                break;

            default:
                parent::setOrder($attribute, $dir);
        }
        return $this;
    }
}
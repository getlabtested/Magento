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
 * @package     Mage_XmlConnect
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */
class Mage_XmlConnect_Block_Adminhtml_Queue_Edit_Form extends Mage_XmlConnect_Block_Adminhtml_Template_Edit_Form
{
    /**
     * Prepare form before rendering HTML
     * Setting Form Fieldsets and fields
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('current_message');
        $this->_fieldsEnabled = $model->getStatus() == Mage_XmlConnect_Model_Queue::STATUS_IN_QUEUE ? true : false;

        parent::_prepareForm();

        if (null !== Mage::registry('current_template')) {
            $templateModel = Mage::registry('current_template');
        } else {
            $templateModel = Mage::getModel('xmlconnect/template')->load($model->getTemplateId());
        }

        $fieldset = $this->getForm()->addFieldset("message_settings", array('legend' => $this->__('Message Settings')), '^');

        if ($model->getId()) {
            $fieldset->addField('message_id', 'hidden', array(
                'name'  => 'message_id'
            ));
        }

        // set exec_time for showing accordingly to locale datetime settings
        $model->setExecTime(Mage::getSingleton('core/date')->date(null, $model->getExecTime()));

        /*@var $sovereignField Varien_Data_Form_Element_Abstract */
        $sovereignField = $fieldset->addField('type', 'select', array(
            'name'      => 'type',
            'values'    => Mage::helper('xmlconnect')->getMessageTypeOptions(),
            'label'     => $this->__('Message Type'),
            'title'     => $this->__('Message Type'),
            'disabled'  => !$this->_fieldsEnabled,
            'required'  => true,
        ));

        $fieldset->addField('exec_time', 'date', array(
            'name'      => 'exec_time',
            'format'    => Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            'label'     => $this->__('Start Date'),
            'time'      => true,
            'title'     => $this->__('Start Date'),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'note'      => $this->__('If leave this field empty, the message will be sent immediately'),
            'disabled'  => !$this->_fieldsEnabled,
            'required'  => false,
        ));

        $this->_addElementTypes($fieldset);

        // field dependencies
        // i don't know how to not hardcoded this dependence (I mean 'airmail' message type is now used for set these dependences)
        if (isset($this->_dependentFields['message_title']) || isset($this->_dependentFields['content'])) {
            $dependenceBlock = $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence');

            $dependenceBlock->addFieldMap($this->_dependentFields['message_title']->getHtmlId(), $this->_dependentFields['message_title']->getName())
                ->addFieldMap($this->_dependentFields['content']->getHtmlId(), $this->_dependentFields['content']->getName())
                ->addFieldMap($sovereignField->getHtmlId(), $sovereignField->getName());

            if (isset($this->_dependentFields['message_title']) && $this->_dependentFields['message_title']) {
                $dependenceBlock->addFieldDependence(
                    $this->_dependentFields['message_title']->getName(),
                    $sovereignField->getName(),
                    Mage_XmlConnect_Model_Queue::MESSAGE_TYPE_AIRMAIL);

                if (!$this->_fieldsEnabled) {
                    $this->_dependentFields['message_title']->setReadonly(true, true);
                }
            }

            if (isset($this->_dependentFields['content']) && $this->_dependentFields['content']) {
                $dependenceBlock->addFieldDependence(
                    $this->_dependentFields['content']->getName(),
                    $sovereignField->getName(),
                    Mage_XmlConnect_Model_Queue::MESSAGE_TYPE_AIRMAIL);

                if (!$this->_fieldsEnabled) {
                    $this->_dependentFields['content']->setReadonly(true, true);
                }
            }
            $this->setChild('form_after', $dependenceBlock);
        }

        if (!$model->getName()) {
            $model->setName($templateModel->getName());
        }
        if (!$model->getPushTitle()) {
            $model->setPushTitle($templateModel->getPushTitle());
        }
        if (!$model->getMessageTitle()) {
            $model->setMessageTitle($templateModel->getMessageTitle());
        }
        if (!$model->getContent()) {
            $model->setContent($templateModel->getContent());
        }
        if (!$model->getTemplateId()) {
            $model->setTemplateId($templateModel->getId());
        }
        $model->setMessageId($model->getId());

        $this->getForm()->setAction($this->getUrl('*/*/saveMessage'));
        $this->getForm()->setValues($model->getData());

        $this->setForm($this->getForm());
     }
}

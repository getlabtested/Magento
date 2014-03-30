<?php

class Jag_Prescriptions_Block_Adminhtml_Prescriptions_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'prescriptions';
        $this->_controller = 'adminhtml_prescriptions';
        
        $this->_updateButton('save', 'label', Mage::helper('prescriptions')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('prescriptions')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('prescriptions_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'prescriptions_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'prescriptions_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('prescriptions_data') && Mage::registry('prescriptions_data')->getId() ) {
            return Mage::helper('prescriptions')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('prescriptions_data')->getTitle()));
        } else {
            return Mage::helper('prescriptions')->__('Add Item');
        }
    }
}
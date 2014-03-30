<?php

class Jag_Reporting_Block_Adminhtml_Reporting_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'reporting';
        $this->_controller = 'adminhtml_reporting';
        
        $this->_updateButton('save', 'label', Mage::helper('reporting')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('reporting')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('reporting_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'reporting_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'reporting_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('reporting_data') && Mage::registry('reporting_data')->getId() ) {
            return Mage::helper('reporting')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('reporting_data')->getTitle()));
        } else {
            return Mage::helper('reporting')->__('Add Item');
        }
    }
}
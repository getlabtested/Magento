<?php

class Jag_Consultation_Block_Adminhtml_Consultation_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'consultation';
        $this->_controller = 'adminhtml_consultation';
        
        $this->_updateButton('save', 'label', Mage::helper('consultation')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('consultation')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('consultation_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'consultation_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'consultation_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('consultation_data') && Mage::registry('consultation_data')->getId() ) {
            return Mage::helper('consultation')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('consultation_data')->getTitle()));
        } else {
            return Mage::helper('consultation')->__('Add Item');
        }
    }
}
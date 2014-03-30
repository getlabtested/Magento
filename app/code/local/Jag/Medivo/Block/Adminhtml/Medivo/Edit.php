<?php

class Jag_Medivo_Block_Adminhtml_Medivo_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'medivo';
        $this->_controller = 'adminhtml_medivo';
        
        $this->_updateButton('save', 'label', Mage::helper('medivo')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('medivo')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('medivo_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'medivo_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'medivo_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('medivo_data') && Mage::registry('medivo_data')->getId() ) {
            return Mage::helper('medivo')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('medivo_data')->getTitle()));
        } else {
            return Mage::helper('medivo')->__('Add Item');
        }
    }
}
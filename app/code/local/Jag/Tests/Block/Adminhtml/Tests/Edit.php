<?php

class Jag_Tests_Block_Adminhtml_Tests_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'tests';
        $this->_controller = 'adminhtml_tests';
        
        $this->_updateButton('save', 'label', Mage::helper('tests')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('tests')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('tests_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'tests_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'tests_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('tests_data') && Mage::registry('tests_data')->getId() ) {
            return Mage::helper('tests')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('tests_data')->getTitle()));
        } else {
            return Mage::helper('tests')->__('Add Item');
        }
    }
}
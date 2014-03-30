<?php

class Jag_Notes_Block_Adminhtml_Notes_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'notes';
        $this->_controller = 'adminhtml_notes';
        
        $this->_updateButton('save', 'label', Mage::helper('notes')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('notes')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('notes_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'notes_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'notes_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('notes_data') && Mage::registry('notes_data')->getId() ) {
            return Mage::helper('notes')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('notes_data')->getTitle()));
        } else {
            return Mage::helper('notes')->__('Add Item');
        }
    }
}
<?php

class Jag_Callcenter_Block_Adminhtml_Callcenter_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'callcenter';
        $this->_controller = 'adminhtml_callcenter';
        
        $this->_updateButton('save', 'label', Mage::helper('callcenter')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('callcenter')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('callcenter_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'callcenter_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'callcenter_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('callcenter_data') && Mage::registry('callcenter_data')->getId() ) {
            return Mage::helper('callcenter')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('callcenter_data')->getTitle()));
        } else {
            return Mage::helper('callcenter')->__('Add Item');
        }
    }
}
<?php

class Jag_Userdashboard_Block_Adminhtml_Userdashboard_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'userdashboard';
        $this->_controller = 'adminhtml_userdashboard';
        
        $this->_updateButton('save', 'label', Mage::helper('userdashboard')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('userdashboard')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('userdashboard_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'userdashboard_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'userdashboard_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('userdashboard_data') && Mage::registry('userdashboard_data')->getId() ) {
            return Mage::helper('userdashboard')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('userdashboard_data')->getTitle()));
        } else {
            return Mage::helper('userdashboard')->__('Add Item');
        }
    }
}
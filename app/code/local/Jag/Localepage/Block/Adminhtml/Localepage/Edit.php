<?php

class Jag_Localepage_Block_Adminhtml_Localepage_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'localepage';
        $this->_controller = 'adminhtml_localepage';
        
        $this->_updateButton('save', 'label', Mage::helper('localepage')->__('Save Page'));
        $this->_updateButton('delete', 'label', Mage::helper('localepage')->__('Delete Page'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('localepage_content') == null) {
                
                    tinyMCE.execCommand('mceAddControl', false, 'localepage_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'localepage_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('localepage_data') && Mage::registry('localepage_data')->getId() ) {
            return Mage::helper('localepage')->__("Edit Page '%s'", $this->htmlEscape(Mage::registry('localepage_data')->getTitle()));
        } else {
            return Mage::helper('localepage')->__('Add Page');
        }
    }
}
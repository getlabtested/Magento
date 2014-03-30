<?php

class Jag_Landingpage_Block_Adminhtml_Landingpage_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'landingpage';
        $this->_controller = 'adminhtml_landingpage';
        
        $this->_updateButton('save', 'label', Mage::helper('landingpage')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('landingpage')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('landingpage_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'landingpage_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'landingpage_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('landingpage_data') && Mage::registry('landingpage_data')->getId() ) {
            return Mage::helper('landingpage')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('landingpage_data')->getTitle()));
        } else {
            return Mage::helper('landingpage')->__('Add Item');
        }
    }
}
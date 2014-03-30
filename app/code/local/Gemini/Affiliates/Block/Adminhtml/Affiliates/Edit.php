<?php



class Gemini_Affiliates_Block_Adminhtml_Affiliates_Edit extends Mage_Adminhtml_Block_Widget_Form_Container

{

    public function __construct()

    {

        parent::__construct();

                 

        $this->_objectId = 'id';

        $this->_blockGroup = 'affiliates';

        $this->_controller = 'adminhtml_affiliates';

        

        $this->_updateButton('save', 'label', Mage::helper('affiliates')->__('Save Affiliate'));

        $this->_updateButton('delete', 'label', Mage::helper('affiliates')->__('Delete Affiliate'));

		

        $this->_addButton('saveandcontinue', array(

            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),

            'onclick'   => 'saveAndContinueEdit()',

            'class'     => 'save',

        ), -100);



        $this->_formScripts[] = "

            function toggleEditor() {

                if (tinyMCE.getInstanceById('results_content') == null) {

                    tinyMCE.execCommand('mceAddControl', false, 'results_content');

                } else {

                    tinyMCE.execCommand('mceRemoveControl', false, 'results_content');

                }

            }



            function saveAndContinueEdit(){

                editForm.submit($('edit_form').action+'back/edit/');

            }

        ";

    }



    public function getHeaderText()

    {

        if( Mage::registry('affiliates_data') && Mage::registry('affiliates_data')->getId() ) {

            return Mage::helper('affiliates')->__("Edit Affiliate '%s'", $this->htmlEscape(Mage::registry('affiliates_data')->getTitle()));

        } else {

            return Mage::helper('affiliates')->__('Add Affiliate');

        }

    }

}
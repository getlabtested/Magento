<?php



class Gemini_Affiliates_Block_Adminhtml_Affiliates_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs

{



  public function __construct()

  {

      parent::__construct();

      $this->setId('affiliates_tabs');

      $this->setDestElementId('edit_form');

      $this->setTitle(Mage::helper('affiliates')->__('Affiliate Information'));

  }



  protected function _beforeToHtml()

  {

      $this->addTab('form_section', array(

          'label'     => Mage::helper('affiliates')->__('Affiliate Information'),

          'title'     => Mage::helper('affiliates')->__('Affiliate Information'),

          'content'   => $this->getLayout()->createBlock('affiliates/adminhtml_affiliates_edit_tab_form')->toHtml(),

      ));

     

      return parent::_beforeToHtml();

  }

}
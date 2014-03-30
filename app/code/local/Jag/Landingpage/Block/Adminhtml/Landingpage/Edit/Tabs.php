<?php

class Jag_Landingpage_Block_Adminhtml_Landingpage_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('landingpage_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('landingpage')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('landingpage')->__('Item Information'),
          'title'     => Mage::helper('landingpage')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('landingpage/adminhtml_landingpage_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
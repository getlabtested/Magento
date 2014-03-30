<?php

class Jag_Tests_Block_Adminhtml_Tests_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('tests_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('tests')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('tests')->__('Item Information'),
          'title'     => Mage::helper('tests')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('tests/adminhtml_tests_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
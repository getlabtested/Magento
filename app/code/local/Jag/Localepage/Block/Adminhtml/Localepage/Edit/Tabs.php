<?php

class Jag_Localepage_Block_Adminhtml_Localepage_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('localepage_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('localepage')->__('Page Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('localepage')->__('Page Information'),
          'title'     => Mage::helper('localepage')->__('Page Information'),
          'content'   => $this->getLayout()->createBlock('localepage/adminhtml_localepage_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
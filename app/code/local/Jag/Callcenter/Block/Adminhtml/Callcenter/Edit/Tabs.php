<?php

class Jag_Callcenter_Block_Adminhtml_Callcenter_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('callcenter_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('callcenter')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('callcenter')->__('Item Information'),
          'title'     => Mage::helper('callcenter')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('callcenter/adminhtml_callcenter_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
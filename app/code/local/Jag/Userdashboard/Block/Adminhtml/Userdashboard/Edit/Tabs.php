<?php

class Jag_Userdashboard_Block_Adminhtml_Userdashboard_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('userdashboard_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('userdashboard')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('userdashboard')->__('Item Information'),
          'title'     => Mage::helper('userdashboard')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('userdashboard/adminhtml_userdashboard_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
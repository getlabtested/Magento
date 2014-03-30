<?php

class Jag_Prescriptions_Block_Adminhtml_Prescriptions_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('prescriptions_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('prescriptions')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('prescriptions')->__('Item Information'),
          'title'     => Mage::helper('prescriptions')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('prescriptions/adminhtml_prescriptions_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
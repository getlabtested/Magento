<?php

class Jag_Consultation_Block_Adminhtml_Consultation_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('consultation_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('consultation')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('consultation')->__('Item Information'),
          'title'     => Mage::helper('consultation')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('consultation/adminhtml_consultation_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
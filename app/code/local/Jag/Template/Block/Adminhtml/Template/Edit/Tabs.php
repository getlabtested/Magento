<?php

class Jag_Template_Block_Adminhtml_Template_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('template_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('template')->__('Template Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('template')->__('Template Information'),
          'title'     => Mage::helper('template')->__('Template Information'),
          'content'   => $this->getLayout()->createBlock('template/adminhtml_template_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
<?php

class Jag_Medivo_Block_Adminhtml_Medivo_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('medivo_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('medivo')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('medivo')->__('Item Information'),
          'title'     => Mage::helper('medivo')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('medivo/adminhtml_medivo_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
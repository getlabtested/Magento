<?php

class Jag_Reporting_Block_Adminhtml_Reporting_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('reporting_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('reporting')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('rep_section', array(
          'label'     => Mage::helper('reporting')->__('Rep Information'),
          'title'     => Mage::helper('reporting')->__('Rep Information'),
          'content'   => $this->getLayout()->createBlock('reporting/adminhtml_reporting_edit_tab_rep')->toHtml(),
      ));
	  
	  $this->addTab('form_section', array(
          'label'     => Mage::helper('reporting')->__('Item Information'),
          'title'     => Mage::helper('reporting')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('reporting/adminhtml_reporting_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
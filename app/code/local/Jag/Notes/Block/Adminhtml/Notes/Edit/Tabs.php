<?php

class Jag_Notes_Block_Adminhtml_Notes_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('notes_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('notes')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('notes')->__('Item Information'),
          'title'     => Mage::helper('notes')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('notes/adminhtml_notes_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
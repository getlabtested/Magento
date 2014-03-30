<?php
class Jag_Tests_Block_Adminhtml_Tests extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_tests';
    $this->_blockGroup = 'tests';
    $this->_headerText = Mage::helper('tests')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('tests')->__('Add Item');
    parent::__construct();
  }
}
<?php
class Jag_Reporting_Block_Adminhtml_Customer extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_customer';
    $this->_blockGroup = 'reporting';
    //$this->_headerText = Mage::helper('reporting')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('reporting')->__('Add Item');
    parent::__construct();
    $this->removeButton('add');
  }
}
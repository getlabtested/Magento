<?php
class Jag_Callcenter_Block_Adminhtml_Callcenter extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_callcenter';
    $this->_blockGroup = 'callcenter';
    $this->_headerText = Mage::helper('callcenter')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('callcenter')->__('Add Item');
    parent::__construct();
  }
}
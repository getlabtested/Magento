<?php
class Jag_Prescriptions_Block_Adminhtml_Prescriptions extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_prescriptions';
    $this->_blockGroup = 'prescriptions';
    $this->_headerText = Mage::helper('prescriptions')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('prescriptions')->__('Add Item');
    parent::__construct();
  }
}
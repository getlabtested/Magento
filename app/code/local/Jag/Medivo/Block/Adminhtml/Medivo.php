<?php
class Jag_Medivo_Block_Adminhtml_Medivo extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_medivo';
    $this->_blockGroup = 'medivo';
    $this->_headerText = Mage::helper('medivo')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('medivo')->__('Add Item');
    parent::__construct();
  }
}
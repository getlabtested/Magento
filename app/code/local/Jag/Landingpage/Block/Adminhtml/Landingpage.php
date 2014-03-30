<?php
class Jag_Landingpage_Block_Adminhtml_Landingpage extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_landingpage';
    $this->_blockGroup = 'landingpage';
    $this->_headerText = Mage::helper('landingpage')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('landingpage')->__('Add Item');
    parent::__construct();
  }
}
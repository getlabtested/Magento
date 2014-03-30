<?php
class Jag_Userdashboard_Block_Adminhtml_Userdashboard extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_userdashboard';
    $this->_blockGroup = 'userdashboard';
    $this->_headerText = Mage::helper('userdashboard')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('userdashboard')->__('Add Item');
    parent::__construct();
  }
}
<?php
class Jag_Notes_Block_Adminhtml_Notes extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_notes';
    $this->_blockGroup = 'notes';
    $this->_headerText = Mage::helper('notes')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('notes')->__('Add Item');
    parent::__construct();
  }
}
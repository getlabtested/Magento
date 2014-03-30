<?php
class Jag_Consultation_Block_Adminhtml_Consultation extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_consultation';
    $this->_blockGroup = 'consultation';
    $this->_headerText = Mage::helper('consultation')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('consultation')->__('Add Item');
    parent::__construct();
  }
}
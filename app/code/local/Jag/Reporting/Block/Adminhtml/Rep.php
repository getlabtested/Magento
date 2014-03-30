<?php
class Jag_Reporting_Block_Adminhtml_Rep extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_rep';
    $this->_blockGroup = 'reporting';
    $this->_headerText = Mage::helper('reporting')->__('Callcenter Rep Report');
    //$this->_addButtonLabel = Mage::helper('reporting')->__('Add Item');
    
    parent::__construct();
	$this->removeButton('add');
  }
}
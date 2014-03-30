<?php
class Jag_Template_Block_Adminhtml_Template extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_template';
    $this->_blockGroup = 'template';
    $this->_headerText = Mage::helper('template')->__('Template Manager');
    $this->_addButtonLabel = Mage::helper('template')->__('Add Template');
    parent::__construct();
  }
}
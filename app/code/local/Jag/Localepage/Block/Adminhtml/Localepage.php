<?php
class Jag_Localepage_Block_Adminhtml_Localepage extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_localepage';
    $this->_blockGroup = 'localepage';
    $this->_headerText = Mage::helper('localepage')->__('Page Manager');
    $this->_addButtonLabel = Mage::helper('localepage')->__('Add Page');
    parent::__construct();
  }
}
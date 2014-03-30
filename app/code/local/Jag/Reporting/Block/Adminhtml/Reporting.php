<?php
class Jag_Reporting_Block_Adminhtml_Reporting extends Mage_Core_Block_Template
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_reporting';
    $this->_blockGroup = 'reporting';
    parent::__construct();
  }
}
<?php
class Jag_Reporting_Block_Adminhtml_Realtime extends Mage_Core_Block_Template
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_realtime';
    $this->_blockGroup = 'realtime';
    parent::__construct();
  }
}
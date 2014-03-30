<?php

class Gemini_Affiliates_Block_Adminhtml_Affiliates extends Mage_Adminhtml_Block_Widget_Grid_Container

{

  public function __construct()

  {
    $this->_controller = 'adminhtml_affiliates';
    $this->_blockGroup = 'affiliates';
    $this->_headerText = Mage::helper('affiliates')->__('Affiliates Manager');
    $this->_addButtonLabel = Mage::helper('affiliates')->__('Add Affiliate');

    parent::__construct();

  }

}
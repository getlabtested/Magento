<?php
class Jag_Callcenter_Block_Adminhtml_Createorder extends Mage_Adminhtml_Block_Abstract
{
  public function __construct()
  {
    parent::__construct();
  }
  
  public function getProducts()
  {
    $collection= Mage::getModel('catalog/product')->getCollection()->setStoreFilter(Mage::app()->getStoreId())->getCollection();
	
	print_r($collection->getFirstItem()->getData()); exit();
	
  }
  
}
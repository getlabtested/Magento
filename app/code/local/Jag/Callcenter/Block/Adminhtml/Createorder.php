<?php
class Jag_Callcenter_Block_Adminhtml_Createorder extends Mage_Adminhtml_Block_Abstract
{
  public function __construct()
  {
    parent::__construct();
  }
  
  public function getLabProducts()
  {
    $collection= Mage::getModel('catalog/product')->getCollection()
    	->setStoreId(Mage::app()->getStore()->getStoreId())
		->addAttributeToSelect("*")
		->addAttributeToFilter('attribute_set_id',array('eq'=>4))
		->addAttributeToFilter('sku',array('like'=>'%lab%'));
	
	return $collection;
	
  }
  
  public function getHomeProducts()
  {
    $collection= Mage::getModel('catalog/product')->getCollection()
    	->setStoreId(Mage::app()->getStore()->getStoreId())
		->addAttributeToSelect("*")
		->addAttributeToFilter('attribute_set_id',array('eq'=>4))
		->addAttributeToFilter('sku',array('like'=>'%home%'));
	
	return $collection;
	
  }
  
}
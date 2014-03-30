<?php
class Jag_Pricing_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {


			
		$this->loadLayout();     
		$this->renderLayout();
    }
    
    public function updatePriceAction()
    {
   		$post = Mage::app()->getRequest()->getPost();
    	
    	$product_id = $post['product_id'];
    	
    	$price = Mage::getModel('catalog/product')->load($product_id)->getPrice();
    	
    	echo round($price); 
    	
		//Mage::getSingleton('core/session')->setOrderArr($zipCode);
			
		//$this->loadLayout();     
		//$this->renderLayout();
    }
    
    
}
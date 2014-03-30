<?php
class Jag_Userdashboard_Block_Userdashboard extends Mage_Core_Block_Template
{
	
	public $custId;
	
	public $orderId;
	
	public function _prepareLayout() 
    {
		return parent::_prepareLayout();
    }
    
     public function getUserdashboard()     
     {  
		if (!$this->hasData('userdashboard')) {
            $this->setData('userdashboard', Mage::registry('userdashboard'));
        }
        return $this->getData('userdashboard');
        
    }
	 
	public function getCustomer() {
		
		$custId = Mage::getSingleton('customer/session')->getId();
		
		$this->_custId = $custId;
				
		return Mage::getModel('customer/customer')->load($custId);
		
	}
	
	public function getLastOrder() {
		
		$custId = Mage::getSingleton('customer/session')->getId();
				
		$collection = Mage::getModel('sales/order')->getCollection()
			->addFieldToFilter('customer_id',array('eq'=>$custId))
			->addFieldToFilter('product_line',array('neq'=>2))
			->addOrder('entity_id');
			
		if ($oid = Mage::app()->getRequest()->getParam('oid')) {
		
			$collection->addFieldToFilter('increment_id',array('eq'=>$oid));
			$collection->addFieldToFilter('customer_id',array('eq'=>Mage::app()->getRequest()->getParam('cid')));
		
		}
			
		$this->_orderId = $collection->getFirstItem()->getId();
			
		return $collection->getFirstItem();	
		
	}
	
	public function getAllOrders() {
		
		$custId = Mage::getSingleton('customer/session')->getId();
				
		$collection = Mage::getModel('sales/order')->getCollection()
			->addFieldToFilter('customer_id',array('eq'=>$custId))
			->addFieldToFilter('product_line',array('neq'=>2));
			
			
		//$this->_orderId = $collection->getFirstItem()->getId();
			
		return $collection;	
		
	}
	
	public function getTests() {
		
		$tests = Mage::getModel('tests/tests')->getCollection()
			->addFieldToFilter('customer_id',array('eq'=>$this->_custId))
			->addFieldToFilter('order_id',array('eq'=>$this->_orderId));
			
		return $tests->getItems();
		
		
	}

	public function getNotes() {
		
		$tests = Mage::getModel('notes/notes')->getCollection()
			->addFieldToFilter('customer_id',array('eq'=>$this->_custId))
			->addFieldToFilter('order_id',array('eq'=>$this->_orderId));
			
		return $tests->getItems();
		
		
	}
	 
	 
}
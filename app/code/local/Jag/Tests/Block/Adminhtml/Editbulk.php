<?php
class Jag_Tests_Block_Adminhtml_Editbulk extends Mage_Adminhtml_Block_Abstract
{
	
	public function getTests() {
			
	$customerId = $this->getRequest()->getParam('customer_id');
	$orderId = $this->getRequest()->getParam('order_id');
	
	$collection = Mage::getModel('tests/tests')->getCollection()
		->addFieldToFilter('order_id',array('eq'=>$orderId))
		->addFieldToFilter('customer_id',array('eq'=>$customerId));
		
	//echo "<pre>"; print_r($collection->getItems()); exit();
	
	return $collection->getItems();
	
	}

}
	
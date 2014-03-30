<?php

class Jag_Tests_Adminhtml_EditbulkController extends Mage_Adminhtml_Controller_action
{
	
	public function indexAction() {
		
		
		$this->loadLayout();
		$this->renderLayout();
		
		


	}	
	
	public function postAction() {
		
		$testArr = $this->getRequest()->getParam('arr');
		
		foreach ($testArr as $k=>$v) {
			
			Mage::getModel('tests/tests')->load($k)->setResult($v)->save();
			
		}
		
		$notes = Mage::getModel('notes/notes');
		$notes->setCustomerId($this->getRequest()->getParam('customer_id'));
		$notes->setOrderId($this->getRequest()->getParam('order_id'));
		$notes->setContent($this->getRequest()->getParam('notes'));
		$notes->save();
				
		echo "test results updated";
		exit();		
	}	
		
}

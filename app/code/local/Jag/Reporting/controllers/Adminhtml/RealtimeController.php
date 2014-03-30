<?php

class Jag_Reporting_Adminhtml_RealtimeController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('reporting/items');
		
		return $this;
	}   
 
	public function indexAction() {
		
		$this->_initAction();
		$this->renderLayout();
	
	}

	
}
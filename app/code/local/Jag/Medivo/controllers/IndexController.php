<?php
class Jag_Medivo_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    
    
    	exit('here');
    	
			
		$this->loadLayout();     
		$this->renderLayout();
    }
    
    public function labsbyzipAction()
    {
    
    	$this->getResponse()->setBody(Mage::helper('core')->jsonEncode('ajax success'));
    	
    	//$this->loadLayout();     
		//$this->renderLayout();    
    
    }
    
    public function selectAction()
    {
        $labid = Mage::app()->getRequest()->getParam('lab_id');
        $labtype = Mage::app()->getRequest()->getParam('lab_type');
        $success = Mage::helper('medivo')->selectLab($labid, $labtype);
        if ($success)
        {
            $this->_redirect('checkout/cart');
        } else
        {
            $this->_redirect('locate-testing-center');
        }
        return;
    }
	
	public function customerResultsAction() {
		
		$loc = Mage::getModel('medivo/medivo')->customerResults();
		
		$url = Mage::getUrl();
		
		$this->_redirectUrl($url.$loc);
				
	}
	
	public function pullmedivoAction() {
		
		$baseDir = Mage::getBaseDir();
		
		$params = $this->getRequest()->getParams();
				
    // [key] => 3449286524d9c2da4c230d6cb9d5b1aba88834e00a13c2b8a93986af434c9cce
    // [isAjax] => true
    // [cust_id] => 175071
    // [inc_id] => 200000001
    // [type] => 1
    // [form_key] => SyqMduebaBQm7xJP
    
    	if ($params['type'] == 1) {
    	
    	
    
	    	if (!file_exists($baseDir.'/req/'.$params['inc_id'].'.pdf')) {
	    		
				if (Mage::getModel('medivo/medivo')->pullReq($params['order_id'])) {
									
					echo '/req/'.$params['inc_id'].'.pdf';
					
				}
				
	    	} else {
	    		
				echo '/req/'.$params['inc_id'].'.pdf';
				
	    	}
    
		} else {
			
			if (!file_exists($baseDir.'/res/'.$params['inc_id'].'.pdf')) {
	    		
				if (Mage::getModel('medivo/medivo')->pullRes($params['order_id'])) {
					
					echo '/res/'.$params['inc_id'].'.pdf';
					
				}
				
	    	} else {
	    		
				echo '/res/'.$params['inc_id'].'.pdf';
				
	    	}
			
		}
		
	}
    
    
}
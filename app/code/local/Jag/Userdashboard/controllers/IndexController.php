<?php
class Jag_Userdashboard_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/userdashboard?id=15 
    	 *  or
    	 * http://site.com/userdashboard/id/15 	
    	 */
    	/* 
		$userdashboard_id = $this->getRequest()->getParam('id');

  		if($userdashboard_id != null && $userdashboard_id != '')	{
			$userdashboard = Mage::getModel('userdashboard/userdashboard')->load($userdashboard_id)->getData();
		} else {
			$userdashboard = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($userdashboard == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$userdashboardTable = $resource->getTableName('userdashboard');
			
			$select = $read->select()
			   ->from($userdashboardTable,array('userdashboard_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$userdashboard = $read->fetchRow($select);
		}
		Mage::register('userdashboard', $userdashboard);
		*/
			$customer = Mage::getSingleton('customer/session');
 			$customer->setBeforeAuthUrl($this->getRequest()->getRequestUri());  
			
			if(!$customer->isLoggedIn()) { 
				header("Status: 301");
				header('Location: '.Mage::getUrl('customer/account/login')) ; 
				exit; 
			} 
			
			
		
		$this->loadLayout();     
		$this->renderLayout();
    }


	public function consultAction() {
		
		$post =  $this->getRequest()->getPost();
		
		$consult = Mage::getModel('consultation/consultation');
		$consult->setContent($post['consultation_question']);
		$consult->setPhone($post['phone_1'].'-'.$post['phone_2'].'-'.$post['phone_3']);
		$consult->setCustomerId($post['customer_id']);
		$consult->save();
		
		return true;
		
	}
	
	public function updatesAction() {
		
		$post =  $this->getRequest()->getPost();
		
		$customer = Mage::getModel('customer/customer')->load($post['customer_id']);
		$customer->setPpmdUpdates($post['ppmd_updates']);
		$customer->save();
		
		return true;
		
	}

	public function passwdAction() {
		
		$post =  $this->getRequest()->getPost();
		
		$customer = Mage::getModel('customer/customer')->load($post['customer_id']);
		$customer->changePassword($post['passwd']);
		$customer->save();
				
		return true;
		
	}
	
	public function regAction() {
		
		$baseDir = Mage::getBaseDir();
		
		$params = $this->getRequest()->getPost();
		    
    	if ($params['type_id'] == 1) {
    
	    	if (!file_exists($baseDir.'/req/'.$params['inc_id'].'.pdf')) {
	    		
				if (Mage::getModel('medivo/medivo')->pullReq($params['order_id'])) {
					
					echo '/req/'.$params['inc_id'].'.pdf';
					
				}
				
	    	} else {
	    		
				echo '/req/'.$params['inc_id'].'.pdf';
				
	    	}
    
		} else {
			
			if (!file_exists($baseDir.'/res/'.$params['inc_id'].'.pdf')) {
	    		
				if (Mage::getModel('medivo/medivo')->pullReq($params['order_id'])) {
					
					echo '/res/'.$params['inc_id'].'.pdf';
					
				}
				
	    	} else {
	    		
				echo '/res/'.$params['inc_id'].'.pdf';
				
	    	}
			
		}
		
	}





}
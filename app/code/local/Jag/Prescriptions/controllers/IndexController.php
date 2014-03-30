<?php
class Jag_Prescriptions_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/prescriptions?id=15 
    	 *  or
    	 * http://site.com/prescriptions/id/15 	
    	 */
    	/* 
		$prescriptions_id = $this->getRequest()->getParam('id');

  		if($prescriptions_id != null && $prescriptions_id != '')	{
			$prescriptions = Mage::getModel('prescriptions/prescriptions')->load($prescriptions_id)->getData();
		} else {
			$prescriptions = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($prescriptions == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$prescriptionsTable = $resource->getTableName('prescriptions');
			
			$select = $read->select()
			   ->from($prescriptionsTable,array('prescriptions_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$prescriptions = $read->fetchRow($select);
		}
		Mage::register('prescriptions', $prescriptions);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}
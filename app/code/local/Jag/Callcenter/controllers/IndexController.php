<?php
class Jag_Callcenter_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/callcenter?id=15 
    	 *  or
    	 * http://site.com/callcenter/id/15 	
    	 */
    	/* 
		$callcenter_id = $this->getRequest()->getParam('id');

  		if($callcenter_id != null && $callcenter_id != '')	{
			$callcenter = Mage::getModel('callcenter/callcenter')->load($callcenter_id)->getData();
		} else {
			$callcenter = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($callcenter == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$callcenterTable = $resource->getTableName('callcenter');
			
			$select = $read->select()
			   ->from($callcenterTable,array('callcenter_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$callcenter = $read->fetchRow($select);
		}
		Mage::register('callcenter', $callcenter);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}
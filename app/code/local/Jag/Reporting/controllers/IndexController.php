<?php
class Jag_Reporting_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/reporting?id=15 
    	 *  or
    	 * http://site.com/reporting/id/15 	
    	 */
    	/* 
		$reporting_id = $this->getRequest()->getParam('id');

  		if($reporting_id != null && $reporting_id != '')	{
			$reporting = Mage::getModel('reporting/reporting')->load($reporting_id)->getData();
		} else {
			$reporting = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($reporting == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$reportingTable = $resource->getTableName('reporting');
			
			$select = $read->select()
			   ->from($reportingTable,array('reporting_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$reporting = $read->fetchRow($select);
		}
		Mage::register('reporting', $reporting);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}
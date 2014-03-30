<?php
class Jag_Tests_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/tests?id=15 
    	 *  or
    	 * http://site.com/tests/id/15 	
    	 */
    	/* 
		$tests_id = $this->getRequest()->getParam('id');

  		if($tests_id != null && $tests_id != '')	{
			$tests = Mage::getModel('tests/tests')->load($tests_id)->getData();
		} else {
			$tests = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($tests == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$testsTable = $resource->getTableName('tests');
			
			$select = $read->select()
			   ->from($testsTable,array('tests_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$tests = $read->fetchRow($select);
		}
		Mage::register('tests', $tests);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}
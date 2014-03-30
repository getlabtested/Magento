<?php
class Jag_Consultation_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/consultation?id=15 
    	 *  or
    	 * http://site.com/consultation/id/15 	
    	 */
    	/* 
		$consultation_id = $this->getRequest()->getParam('id');

  		if($consultation_id != null && $consultation_id != '')	{
			$consultation = Mage::getModel('consultation/consultation')->load($consultation_id)->getData();
		} else {
			$consultation = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($consultation == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$consultationTable = $resource->getTableName('consultation');
			
			$select = $read->select()
			   ->from($consultationTable,array('consultation_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$consultation = $read->fetchRow($select);
		}
		Mage::register('consultation', $consultation);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}
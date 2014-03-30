<?php
class Jag_Notes_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/notes?id=15 
    	 *  or
    	 * http://site.com/notes/id/15 	
    	 */
    	/* 
		$notes_id = $this->getRequest()->getParam('id');

  		if($notes_id != null && $notes_id != '')	{
			$notes = Mage::getModel('notes/notes')->load($notes_id)->getData();
		} else {
			$notes = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($notes == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$notesTable = $resource->getTableName('notes');
			
			$select = $read->select()
			   ->from($notesTable,array('notes_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$notes = $read->fetchRow($select);
		}
		Mage::register('notes', $notes);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}
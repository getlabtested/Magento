<?php
class Gemini_Banners_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/banners?id=15 
    	 *  or
    	 * http://site.com/banners/id/15 	
    	 */
    	/* 
		$banners_id = $this->getRequest()->getParam('id');

  		if($banners_id != null && $banners_id != '')	{
			$banners = Mage::getModel('banners/banners')->load($banners_id)->getData();
		} else {
			$banners = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($banners == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$bannersTable = $resource->getTableName('banners');
			
			$select = $read->select()
			   ->from($bannersTable,array('banners_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$banners = $read->fetchRow($select);
		}
		Mage::register('banners', $banners);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}
<?php
class Jag_Template_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/template?id=15 
    	 *  or
    	 * http://site.com/template/id/15 	
    	 */
    	/* 
		$template_id = $this->getRequest()->getParam('id');

  		if($template_id != null && $template_id != '')	{
			$template = Mage::getModel('template/template')->load($template_id)->getData();
		} else {
			$template = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($template == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$templateTable = $resource->getTableName('template');
			
			$select = $read->select()
			   ->from($templateTable,array('template_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$template = $read->fetchRow($select);
		}
		Mage::register('template', $template);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}
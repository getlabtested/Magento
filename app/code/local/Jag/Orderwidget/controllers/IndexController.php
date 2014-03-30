<?php
class Jag_Orderwidget_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/orderwidget?id=15 
    	 *  or
    	 * http://site.com/orderwidget/id/15 	
    	 */
    	/* 
		$orderwidget_id = $this->getRequest()->getParam('id');

  		if($orderwidget_id != null && $orderwidget_id != '')	{
			$orderwidget = Mage::getModel('orderwidget/orderwidget')->load($orderwidget_id)->getData();
		} else {
			$orderwidget = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($orderwidget == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$orderwidgetTable = $resource->getTableName('orderwidget');
			
			$select = $read->select()
			   ->from($orderwidgetTable,array('orderwidget_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$orderwidget = $read->fetchRow($select);
		}
		Mage::register('orderwidget', $orderwidget);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }

    public function alternateAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}
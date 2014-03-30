<?php
/**
 * Event observer model
 *
 *
 */
class Jag_Adminhtml_Model_Observer
{
    /**
     * Adds virtual grid column to order grid records generation
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function addColumnToResource(Varien_Event_Observer $observer)
    {
        /* @var $resource Mage_Sales_Model_Mysql4_Order */
        $resource = $observer->getEvent()->getResource();
        $resource->addVirtualGridColumn(
            'ppmd_activate',
            'sales/order',
            array('entity_id' => 'entity_id'),
            'ppmd_activate'
        );
		
		$resource->addVirtualGridColumn(
            'ppmd_provider',
            'sales/order',
            array('entity_id' => 'entity_id'),
            'ppmd_provider'
        );
		
		$resource->addVirtualGridColumn(
            'ppmd_cust_id',
            'sales/order',
            array('entity_id' => 'entity_id'),
            'ppmd_cust_id'
        );
		
		$resource->addVirtualGridColumn(
            'ppmd_cust_acct',
            'sales/order',
            array('entity_id' => 'entity_id'),
            'ppmd_cust_acct'
        );
		
		$resource->addVirtualGridColumn(
            'ppmd_cust_conf',
            'sales/order',
            array('entity_id' => 'entity_id'),
            'ppmd_cust_conf'
        );
		
		$resource->addVirtualGridColumn(
            'ppmd_status',
            'sales/order',
            array('entity_id' => 'entity_id'),
            'ppmd_status'
        );
    }
}
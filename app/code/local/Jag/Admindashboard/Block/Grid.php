<?php
/**
 *Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to theMagento License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml sales orders grid
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Jag_Admindashboard_Block_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid
{

    
    protected function _prepareColumns()
    {
    	
		// if (!Mage::app()->isSingleStoreMode()) {
            // $this->addColumn('store_id', array(
                // 'header'    => Mage::helper('sales')->__('Purchased From (Store)'),
                // 'index'     => 'store_id',
                // 'type'      => 'store',
                // 'store_view'=> true,
                // 'display_deleted' => true,
            // ));
        // }
        
        $this->addColumn('real_order_id', array(
            'header'=> Mage::helper('sales')->__('Order'),
            'width' => '70px',
            'type'  => 'text',
            'index' => 'increment_id',
            'filter_index' => 'main_table.increment_id', 
        ));
        
        
        
        
        $c = Mage::getModel('admin/user')->getCollection();
        
        $arr[99] = "ONLINE";

foreach ($c->getItems() as $u) {

	$arr[$u->getUserId()] = $u->getUsername();

}


		$this->addColumn('ppmd_rep', array(
            'header'=> Mage::helper('sales')->__('Rep'),
            'width' => '70px',
            'type'  => 'options',
            'index' => 'ppmd_rep',
            'options'   => $arr,
        ));

		
		 $this->addColumn('product_line', array(
            'header'=> Mage::helper('sales')->__('Type'),
            'width' => '70px',
            'type'  => 'options',
            'index' => 'product_line',
            'options'   => array(
              0 => 'Test',
              2 => 'Script',
          ),
        ));
        
        $this->addColumn('order_type', array(
            'header'=> Mage::helper('sales')->__('Loc'),
            'width' => '70px',
            'type'  => 'options',
            'index' => 'order_type',
            'options'   => array(
              1 => 'Lab',
              2 => 'Home',
          ),
        ));
        
        $this->addColumn('created_at', array(
            'header' => Mage::helper('sales')->__('Date'),
            'index' => 'created_at',
            'filter_index' => 'main_table.created_at', 
            'type' => 'datetime',
            'width' => '50px',
        ));
        
        
        /*
$this->addColumn('inv_create', array(
            'header' => Mage::helper('sales')->__('Invoice'),
            'index' => 'inv_create',
            'filter_index' => 'inv_create', 
            'type' => 'datetime',
            'width' => '50px',
        ));
*/
        
        $this->addColumn('ppmd_status', array(
            'header' => Mage::helper('sales')->__('Results'),
            'index' => 'ppmd_status',
            'filter_index' => 'main_table.ppmd_status', 
            'type'  => 'options',
            'width' => '70px',
            'options'   => array(
              0 => 'Pending',
              1 => 'Interpretation',
              2 => 'Complete',
              3 => 'Customer Recieved',
          ),
        ));
		
		$this->addColumn('ppmd_activate', array(
            'header' => Mage::helper('sales')->__('Active'),
            'index' => 'ppmd_activate',
            'filter_index' => 'main_table.ppmd_activate', 
            'type'  => 'options',
            'width' => '70px',
            'options'   => array(
              0 => 'No',
              1 => 'Yes',
          ),
        ));
		
		$this->addColumn('method', array(
            'header' => Mage::helper('sales')->__('Method'),
            'index' => 'method',
            'type'  => 'options',
            'width' => '70px',
            'options'   => array(
              'authorizenet' => 'Credit Card',
              'paynearme' => 'Cash',
              'paylater' => 'Pay Later',
              'paypaluk_express' => 'PayPal'
          ),
        ));
		
		$this->addColumn('status', array(
            'header' => Mage::helper('sales')->__('Status'),
            'index' => 'status',
            'filter_index' => 'main_table.status', 
            'type'  => 'options',
            'width' => '70px',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
        ));
		
		$this->addColumn('follow_up', array(
            'header' => Mage::helper('sales')->__('Follow Up'),
            'index' => 'follow_up',
            'type'  => 'options',
            'width' => '70px',
            'options'   => array(
              0 => '',
              7 => 'Upload Req',
              8 => 'Call Lab',
              1 => 'Mail Homekit',
              2 => 'Fax Req',
              3 => 'Send Invoice',
              4 => 'Doc Consultation',
              5 => 'Needs Call',
              6 => 'Other',
          ),
        ));
		
		/*
$this->addColumn('store_id', array(
            'header' => Mage::helper('sales')->__('Store'),
            'index' => 'store_id',
            'type'  => 'options',
            'width' => '70px',
            'options'   => array(
              0 => 'ADMIN',
              2 => 'GST',
              3 => 'STDT',
          ),
        ));
*/
		
		$this->addColumn('ppmd_provider', array(
            'header'=> Mage::helper('sales')->__('Provider'),
            'width' => '50px',
            'type'  => 'options',
            'index' => 'ppmd_provider',
            'filter_index' => 'main_table.ppmd_provider', 
            'options'   => array(
              0 => 'N/A',
              1 => 'Medivo',
              2 => 'ELab',
          ),
        ));
				
		$this->addColumn('ppmd_cust_acct', array(
            'header'=> Mage::helper('sales')->__('Acct #'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'ppmd_cust_acct',
            'filter_index' => 'main_table.ppmd_cust_acct', 
        ));
		
		$this->addColumn('ppmd_cust_conf', array(
            'header'=> Mage::helper('sales')->__('Conf #'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'ppmd_cust_conf',
            'filter_index' => 'main_table.ppmd_cust_conf', 
        ));
		
		$this->addColumn('ppmd_cust_id', array(
            'header'=> Mage::helper('sales')->__('Cust #'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'ppmd_cust_id',
            'filter_index' => 'main_table.ppmd_cust_id', 
        ));

        
        $this->addColumn('billing_name', array(
            'header' => Mage::helper('sales')->__('Name'),
            'index' => 'billing_name',
        ));
		

        // $this->addColumn('shipping_name', array(
            // 'header' => Mage::helper('sales')->__('Ship to Name'),
            // 'index' => 'shipping_name',
        // ));
// 
        // $this->addColumn('base_grand_total', array(
            // 'header' => Mage::helper('sales')->__('G.T. (Base)'),
            // 'index' => 'base_grand_total',
            // 'type'  => 'currency',
            // 'currency' => 'base_currency_code',
        // ));

                
		
		$this->addColumn('grand_total', array(
            'header' => Mage::helper('sales')->__('Total'),
            'index' => 'grand_total',
            'type'  => 'currency',
            'width' => '50px',
            'currency' => 'order_currency_code',
        ));

        // if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            // $this->addColumn('action',
                // array(
                    // 'header'    => Mage::helper('sales')->__('Action'),
                    // 'width'     => '50px',
                    // 'type'      => 'action',
                    // 'getter'     => 'getId',
                    // 'actions'   => array(
                        // array(
                            // 'caption' => Mage::helper('sales')->__('View'),
                            // 'url'     => array('base'=>'*/sales_order/view'),
                            // 'field'   => 'order_id'
                        // )
                    // ),
                    // 'filter'    => false,
                    // 'sortable'  => false,
                    // 'index'     => 'stores',
                    // 'is_system' => true,
            // ));
        // }
        $this->addRssList('rss/order/new', Mage::helper('sales')->__('New Order RSS'));

        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));

        //return parent::_prepareColumns();
    }

    
}
        
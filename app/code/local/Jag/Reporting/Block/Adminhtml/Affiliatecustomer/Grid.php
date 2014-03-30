<?php

class Jag_Reporting_Block_Adminhtml_Affiliatecustomer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('reportingGrid');
      /*
$this->setDefaultSort('reporting_id');
      $this->setDefaultDir('ASC');
*/
      $this->setSaveParametersInSession(false);
  }

  protected function _prepareCollection()
  {
     /*
 $collection = Mage::getResourceModel('customer/customer_collection')
            ->addNameToSelect()
            ->addAttributeToSelect('email');
       $collection->getSelect()->joinLeft('sales_flat_order', '`sales_flat_order`.customer_id=e.entity_id', array(
       		'affiliate_id'=>'affiliate_id',
       		'dtc'=>'increment_id',
       		'oid'=>'entity_id',
       		'order_type'=>'order_type',
       		'ostatus'=>'status',
       		'ppmd_status'=>'ppmd_status',
       		'ppmd_cust_id'=>'ppmd_cust_id',
       		'ppmd_cust_acct'=>'ppmd_cust_acct',
       		'ppmd_cust_conf'=>'ppmd_cust_conf',
       		'ppmd_activate'=>'ppmd_activate',
       		'ppmd_call_reason'=>'ppmd_call_reason',
       		'ppmd_rep'=>'ppmd_rep',
       		
       	), null,'left');
       $collection->getSelect()->joinLeft('sales_flat_order_payment', '`sales_flat_order_payment`.parent_id=sales_flat_order.entity_id', array('method'=>'method'), null,'left');
*/

	//echo "here"; exit();

	$collection = Mage::getModel('sales/order')->getCollection();
       $collection->getSelect()->joinLeft('sales_flat_order_payment', '`sales_flat_order_payment`.parent_id=main_table.entity_id', array('method'=>'method'), null,'left');
       $collection->getSelect()->joinLeft('customer_entity', '`customer_entity`.entity_id=main_table.customer_id', array('email'=>'email','website_id'=>'website_id'), null,'left');
       
       
       //echo $collection->getSelect()->__toString(); exit();
      
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
  
  $this->addColumn('created_at', array(
          'header'    => Mage::helper('reporting')->__('Date Ordered'),
          'align'     =>'left',
          'index'     => 'created_at',
          'filter_index'     => 'main_table.created_at',
          'type' 	=> 'datetime',
      ));
  
  	  $affiliates = Mage::getModel('affiliates/affiliates')->getCollection();
   		//$affiliates->addFieldToFilter('callcenter',array('eq'=>0));
		$affiliates->getSelect()->order(array('referral_id ASC'));
				
		$affArr = array();
   		
		foreach ($affiliates->getItems() as $affiliate) {
				
			$affArr[$affiliate->getReferralId()] = $affiliate->getReferralId();
		
		}
  
  	$this->addColumn('affiliate_id', array(
          'header'    => Mage::helper('reporting')->__('Affiliate'),
          'align'     =>'left',
          'index'     => 'affiliate_id',
          'type'	  => 'options',
          'options'   => $affArr,
      ));
  
       $this->addColumn('name', array(
          'header'    => Mage::helper('reporting')->__('Name'),
          'align'     =>'left',
          'index'     => '',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Stuff',
      ));
      
      $this->addColumn('increment_id', array(
          'header'    => Mage::helper('reporting')->__('DTC'),
          'align'     =>'left',
          'index'     => 'increment_id',
      ));

      $this->addColumn('entity_id', array(
          'header'    => Mage::helper('reporting')->__('Order ID'),
          'align'     =>'left',
          'index'     => 'entity_id',
      ));
      
      $this->addColumn('ppmd_cust_acct', array(
          'header'    => Mage::helper('reporting')->__('Med Acct'),
          'align'     =>'left',
          'index'     => 'ppmd_cust_acct',
      ));
      
       $this->addColumn('ppmd_cust_id', array(
          'header'    => Mage::helper('reporting')->__('Med Cust ID'),
          'align'     =>'left',
          'index'     => 'ppmd_cust_id',
      ));
      
       $this->addColumn('ppmd_cust_conf', array(
          'header'    => Mage::helper('reporting')->__('Med Conf#'),
          'align'     =>'left',
          'index'     => 'ppmd_cust_conf',
      ));
      
      
      $this->addColumn('order_type', array(
          'header'    => Mage::helper('reporting')->__('Type'),
          'align'     =>'left',
          'type'      => 'options',
          'options'   => array(
              1 => 'Lab',
              2 => 'Home',
              3 => 'Script',
          ),
          'index'     => 'order_type',
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
     
      
       $this->addColumn('ppmd_activate', array(
          'header'    => Mage::helper('reporting')->__('Active'),
          'align'     =>'left',
          'type'      => 'options',
          'options'   => array(
              0 => 'No',
              1 => 'Yes',
           ),
          'index'     => 'ppmd_activate',
      ));
            
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
        
                 $carr[4] = 'Serious Interest';
                 $carr[6] = 'Wrong Number';
              	 $carr[7] = 'Hang-up';
              	 $carr[1] = 'Customer Serv';
              	 $carr[3] = 'General Info';
              	 $carr[2] = 'Free Testing';
              	 $carr[5] = 'Not Offered';
            	 $carr[8] = 'Solicitation';
      
       $this->addColumn('ppmd_call_reason', array(
          'header'    => Mage::helper('reporting')->__('Call Reason'),
          'align'     =>'left',
          'index'     => 'ppmd_call_reason',
          'type'	  => 'options',
          'options'   => $carr,
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
      
       

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('reporting')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

      /*
$this->addColumn('status', array(
          'header'    => Mage::helper('reporting')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
*/
	  
        
		
		$this->addExportType('*/*/exportCsv', Mage::helper('reporting')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('reporting')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('reporting_id');
        $this->getMassactionBlock()->setFormFieldName('reporting');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('reporting')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('reporting')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('reporting/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('reporting')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('reporting')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
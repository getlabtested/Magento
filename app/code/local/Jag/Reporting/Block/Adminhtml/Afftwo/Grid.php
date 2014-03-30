<?php

class Jag_Reporting_Block_Adminhtml_Afftwo_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('reportingGrid');
     /*
 $this->setDefaultSort('reporting_id');
      $this->setDefaultDir('ASC');
*/
      $this->setSaveParametersInSession(true);
      //$this->setCountTotals(true);
  }

  protected function _prepareCollection()
  {
    
    
  $affiliates = Mage::getModel('affiliates/affiliates')->getCollection();
   		//$affiliates->addFieldToFilter('callcenter',array('eq'=>0));
		$affiliates->getSelect()->order(array('referral_id ASC'));
				
		$affArr = array();
   		
		foreach ($affiliates->getItems() as $affiliate) {
				
			$affArr[$affiliate->getReferralId()] = $affiliate->getReferralId();
		
		}
		
		//print_r($affArr);
  
  	  $collection = Mage::getModel('sales/quote')->getCollection();
  	  $collection->addFieldToSelect('entity_id');
  	  $collection->addFieldToSelect('affiliate_id');
  	  $collection->addFieldToSelect('ppmd_affiliate');
  	  $collection->addFieldToSelect('created_at');
  	  $collection->addFieldToSelect('store_id');
  	  $collection->addFieldToFilter('ppmd_rep',array('eq'=>99));
  	  
  	  $collection->addFieldToFilter('ppmd_affiliate',array('in'=>$affArr));
  	  
  	  $collection->addExpressionFieldToSelect('total_calls',"COUNT(entity_id)",'entity_id');
  	  	 
	  
	  $params = Mage::helper('adminhtml')->prepareFilterString(Mage::app()->getRequest()->getParam('filter'));
		
		if ($params['created_at'] && is_array($params['created_at'])) {
		
			$from = $params['created_at']['from'];
			
			$from = date('Y-m-d',strtotime($from));
			
			$to = $params['created_at']['to'];
			
			$to = date('Y-m-d',strtotime($to));
		
			$collection->addFieldToFilter('updated_at',array('gt'=>$from));	
			$collection->addFieldToFilter('updated_at',array('lt'=>$to));	
			
		}
		
		 $collection->getSelect()->group('affiliate_id');
	  
	  //echo $collection->getSelect()->__toString();

      $this->setCollection($collection);
      return parent::_prepareCollection();
	  
  }

  protected function _prepareColumns()
  {
  		
  	  $this->addColumn('created_at', array(
          'header'    => Mage::helper('reporting')->__('Date'),
          'align'     =>'left',
          
          'index'     => 'created_at',
          'type'	  => 'date',
          'filter_index' => 'main_table.created_at',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Sales_Renderer_Range',
      ));
  
  		 $affiliates = Mage::getModel('affiliates/affiliates')->getCollection();
   		//$affiliates->addFieldToFilter('callcenter',array('eq'=>0));
		$affiliates->getSelect()->order(array('referral_id ASC'));
				
		$affArr = array();
   		
		foreach ($affiliates->getItems() as $affiliate) {
				
			$affArr[$affiliate->getReferralId()] = $affiliate->getReferralId();
		
		}

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
				  
      $this->addColumn('affiliate_id', array(
          'header'    => Mage::helper('reporting')->__('Affiliate'),
          'align'     =>'left',
          'index'     => 'affiliate_id',
          'type'      => 'options',
          'options'   => $affArr,
          //'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer',
      ));
      
       $this->addColumn('total_calls', array(
          'header'    => Mage::helper('reporting')->__('Total Quotes'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => 'total_calls',
          //'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Calls',
      ));
      
       $this->addColumn('authorizenet', array(
          'header'    => Mage::helper('reporting')->__('PN'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => 'authorizenet',
          'type'      => 'text',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Afftwo_Renderer_Methods',
      ));
      
      
      $this->addColumn('paynearme', array(
          'header'    => Mage::helper('reporting')->__('PC'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => 'paynearme',
          'type'      => 'text',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Afftwo_Renderer_Methods',
      ));
      
      $this->addColumn('sales', array(
          'header'    => Mage::helper('reporting')->__('Total Sales'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => 'sales',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Afftwo_Renderer_Totalsales',
      ));
            
      $this->addColumn('conversion', array(
          'header'    => Mage::helper('reporting')->__('Conversion'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => '',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Sales_Renderer_Conversion',
      ));
      	      
	      
	   $this->addColumn('total_revenue', array(
          'header'    => Mage::helper('reporting')->__('Sales'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => '',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Afftwo_Renderer_Totalrevenue',
      ));
    
      $this->addColumn('total_paid', array(
          'header'    => Mage::helper('reporting')->__('Paid'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => '',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Afftwo_Renderer_Totalpaid',
      ));
      
       $this->addColumn('total_refunded', array(
          'header'    => Mage::helper('reporting')->__('Ref'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => '',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Afftwo_Renderer_Totalrefunded',
      ));
      
      $this->addColumn('total_cash', array(
          'header'    => Mage::helper('reporting')->__('Cash'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => '',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Afftwo_Renderer_Totalcash',
      ));
      
      
      /* $this->addColumn('serious_interest', array(
          'header'    => Mage::helper('reporting')->__('Serious Interest'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => 'serious_interest',
          'type'      => 'text',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Sales_Renderer_Reason',
      ));
      
       $this->addColumn('customer_service', array(
          'header'    => Mage::helper('reporting')->__('Customer Service'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => 'customer_service',
          'type'      => 'text',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Sales_Renderer_Reason',
      ));
      
      $this->addColumn('general_inquiry', array(
          'header'    => Mage::helper('reporting')->__('General Inquiry'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => 'general_inquiry',
          'type'      => 'text',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Sales_Renderer_Reason',
      ));
      
      $this->addColumn('free_testing', array(
          'header'    => Mage::helper('reporting')->__('Free Testing'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => 'free_testing',
          'type'      => 'text',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Sales_Renderer_Reason',
      ));
      
      $this->addColumn('wrong_number', array(
          'header'    => Mage::helper('reporting')->__('Wrong Number'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => 'wrong_number',
          'type'      => 'text',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Sales_Renderer_Reason',
      ));
      
      $this->addColumn('test_not_offered', array(
          'header'    => Mage::helper('reporting')->__('Test Not Offered'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => 'test_not_offered',
          'type'      => 'text',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Sales_Renderer_Reason',
      ));
      
      $this->addColumn('hang_up', array(
          'header'    => Mage::helper('reporting')->__('Hang Up'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => 'hang_up',
          'type'      => 'text',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Sales_Renderer_Reason',
      ));
      
      $this->addColumn('solicitation', array(
          'header'    => Mage::helper('reporting')->__('Solicitation'),
          'align'     =>'left',
          'filter'   => false,
          
          'index'     => 'solicitation',
          'type'      => 'text',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Sales_Renderer_Reason',
      ));
      
      */
      
                        
      /*
$this->addColumn('total_avg', array(
          'header'    => Mage::helper('reporting')->__('Total Revenue'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => '',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Totalavg',
      ));
*/
      
       /*
      $this->addColumn('total_revenue', array(
          'header'    => Mage::helper('reporting')->__('Total Revenue'),
          'align'     =>'left',
          
          'index'     => 'total_revenue',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Money',
      ));
      
       $this->addColumn('avg_revenue', array(
          'header'    => Mage::helper('reporting')->__('Avg Revenue'),
          'align'     =>'left',
          
          'index'     => 'avg_revenue',
           'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Money',
      ));
*/

      
      /*
$this->addColumn('conversion_rate', array(
          'header'    => Mage::helper('reporting')->__('Conversion Rate'),
          'align'     =>'right',
          
          'index'     => '',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Conversion',
      ));
      
      $this->addColumn('avg_revenue', array(
          'header'    => Mage::helper('reporting')->__('Avg Sale'),
          'align'     =>'right',
          
          'index'     => 'avg_revenue',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Money',
      ));
      
      $this->addColumn('total_revenue', array(
          'header'    => Mage::helper('reporting')->__('Total Revenue'),
          'align'     =>'right',
          
          'index'     => 'total_revenue',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Money',
      ));
*/
	  
	  /*
$this->addColumn('created_at', array(
            'header' => Mage::helper('sales')->__('Purchased On'),
            'index' => 'created_at',
            'filter_index'=> 'main_table.created_at',
            'type' => 'datetime',
            'width' => '100px',
        ));
*/

      // $this->addColumn('title', array(
          // 'header'    => Mage::helper('reporting')->__('Title'),
          // 'align'     =>'left',
          // 'index'     => 'title',
      // ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('reporting')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

      // $this->addColumn('status', array(
          // 'header'    => Mage::helper('reporting')->__('Status'),
          // 'align'     => 'left',
          // 'width'     => '80px',
          // 'index'     => 'status',
          // 'type'      => 'options',
          // 'options'   => array(
              // 1 => 'Enabled',
              // 2 => 'Disabled',
          // ),
      // ));
	  
        // $this->addColumn('action',
            // array(
                // 'header'    =>  Mage::helper('reporting')->__('Action'),
                // 'width'     => '100',
                // 'type'      => 'action',
                // 'getter'    => 'getId',
                // 'actions'   => array(
                    // array(
                        // 'caption'   => Mage::helper('reporting')->__('Edit'),
                        // 'url'       => array('base'=> '*/*/edit'),
                        // 'field'     => 'id'
                    // )
                // ),
                // 'filter'    => false,
                // 'sortable'  => false,
                // 'index'     => 'stores',
                // 'is_system' => true,
        // ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('reporting')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('reporting')->__('XML'));
	  
	   //unset($this->_columns['action']); //remove the column where name = 'action'
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
       
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
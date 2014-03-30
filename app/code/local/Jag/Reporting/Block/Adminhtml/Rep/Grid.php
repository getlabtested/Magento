<?php

class Jag_Reporting_Block_Adminhtml_Rep_Grid extends Mage_Adminhtml_Block_Widget_Grid
//class Jag_Reporting_Block_Adminhtml_Rep_Grid extends Mage_Adminhtml_Block_Report_Grid_Abstract
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('reportingGrid');
      $this->setDefaultSort('reporting_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(false);
      //$this->setCountTotals(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('sales/quote')->getCollection();
      $collection->addExpressionFieldToSelect('total_calls',"count(`main_table`.entity_id)",'`main_table`.entity_id');
      $collection->addFieldToFilter('ppmd_rep',array('neq'=>99));
	  $collection->getSelect()->group('main_table.ppmd_rep');
	  
	  //echo $collection->getSelect()->__toString(); exit();
      $this->setCollection($collection);
      return parent::_prepareCollection();
	  
  }

  protected function _prepareColumns()
  {
      $c = Mage::getModel('admin/user')->getCollection();
        
        $arr[99] = "ONLINE";

foreach ($c->getItems() as $u) {

	$arr[$u->getUserId()] = $u->getUsername();

}

//Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('filter')

	$this->addColumn('created_at', array(
            'header' => Mage::helper('sales')->__('Range'),
            'index' => 'created_at',
            'filter_index'=> 'main_table.updated_at',
            'type' => 'date',
            
            'renderer'  => 'Jag_Reporting_Block_Adminhtml_Afftwo_Renderer_Range',
        ));
        

		$this->addColumn('ppmd_rep', array(
            'header'=> Mage::helper('sales')->__('Rep'),
            'width' => '70px',
            'type'  => 'options',
            'index' => 'ppmd_rep',
            'options'   => $arr,
        ));
	  
	  $this->addColumn('total_calls', array(
          'header'    => Mage::helper('reporting')->__('Total Calls'),
          'align'     =>'right',
          
          'index'     => 'total_calls',
          'filter'     => false,
          //'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Calls',
      ));
      
       $this->addColumn('authorizenet', array(
          'header'    => Mage::helper('reporting')->__('PN'),
          'align'     =>'right',
          
          'filter'   => false,
          'index'     => 'authorizenet',
          'type'      => 'text',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Methods',
      ));
      
      $this->addColumn('paylater', array(
          'header'    => Mage::helper('reporting')->__('PL'),
          'align'     =>'right',
          
          'filter'   => false,
          'index'     => 'paylater',
          'type'      => 'text',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Methods',
      ));
      
      $this->addColumn('paynearme', array(
          'header'    => Mage::helper('reporting')->__('PC'),
          'align'     =>'right',
          
          'filter'   => false,
          'index'     => 'paynearme',
          'type'      => 'text',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Methods',
      ));
      
      $this->addColumn('total_sales', array(
          'header'    => Mage::helper('reporting')->__('Total Sales'),
          'align'     =>'right',
          
          'index'     => '',
          'filter'     => false,
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Totalsales',
      ));
      
      $this->addColumn('conversion_rate', array(
          'header'    => Mage::helper('reporting')->__('Conversion Rate'),
          'align'     =>'right',
          
          'index'     => '',
          'filter'     => false,
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Afftwo_Renderer_Conversion',
      ));
      
      $this->addColumn('total_revenue', array(
          'header'    => Mage::helper('reporting')->__('Sales'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => '',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Totalrevenue',
      ));
    
      $this->addColumn('total_paid', array(
          'header'    => Mage::helper('reporting')->__('Paid'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => '',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Totalpaid',
      ));
      
       $this->addColumn('total_refunded', array(
          'header'    => Mage::helper('reporting')->__('Ref'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => '',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Totalrefunded',
      ));
      
      $this->addColumn('total_cash', array(
          'header'    => Mage::helper('reporting')->__('Cash'),
          'align'     =>'left',
          
          'filter'   => false,
          'index'     => '',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Totalcash',
      ));
      
      $this->addColumn('avg_revenue', array(
          'header'    => Mage::helper('reporting')->__('Avg Sale'),
          'align'     =>'right',
          
          'index'     => 'avg_revenue',
          'filter'     => false,
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Totalavg',
      ));
      
     
	  
	  

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
<?php

class Jag_Reporting_Block_Adminhtml_Customer_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
            ->addAttributeToSelect('email')
            ->addAttributeToSelect('ppmd_updates')
            ->addAttributeToSelect('created_at')
            ->addAttributeToSelect('gender')
            ->addAttributeToSelect('dob')
            ->joinAttribute('billing_street', 'customer_address/street', 'default_billing', null, 'left')
            ->joinAttribute('billing_postcode', 'customer_address/postcode', 'default_billing', null, 'left')
            ->joinAttribute('billing_telephone', 'customer_address/telephone', 'default_billing', null, 'left')
            ->joinAttribute('billing_region', 'customer_address/region', 'default_billing', null, 'left')
            ->joinAttribute('billing_country_id', 'customer_address/country_id', 'default_billing', null, 'left');
       $collection->getSelect()->joinLeft('sales_flat_order', '`sales_flat_order`.customer_id=e.entity_id', array('affiliate_id'=>'affiliate_id','pstring'=>'pstring','order_type'=>'order_type'), null,'left');
       $collection->getSelect()->joinLeft('sales_flat_order_payment', '`sales_flat_order_payment`.parent_id=sales_flat_order.entity_id', array('method'=>'method'), null,'left');
*/
       
       
       
$collection = Mage::getModel('sales/order')->getCollection();
       
$collection->getSelect()->joinLeft('sales_flat_order_payment', '`sales_flat_order_payment`.parent_id=main_table.entity_id', array('method'=>'method'), null,'left');
       $collection->getSelect()->joinLeft('customer_entity', '`customer_entity`.entity_id=main_table.customer_id', array('email'=>'email','website_id'=>'website_id'), null,'left');
       $collection->getSelect()->joinLeft('customer_entity_int', '`customer_entity_int`.entity_id=main_table.customer_id and customer_entity_int.attribute_id=32', array('gender'=>'value'), null,'left');
       $collection->getSelect()->joinLeft('customer_entity_int', '`customer_entity_int_2`.entity_id=main_table.customer_id and customer_entity_int_2.attribute_id=176', array('notification'=>'value'), null,'left');

		$collection->addFilterToMap('method', 'sales_flat_order_payment.method');
		$collection->addFilterToMap('email', 'customer_entity.email');
		$collection->addFilterToMap('website_id', 'customer_entity.website_id');
		$collection->addFilterToMap('gender', 'customer_entity_int.value');
		$collection->addFilterToMap('notification', 'customer_entity_int_2.value');
       
       //echo $collection->count();
       
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
          'type' 	=> 'date',
          'filter_index' => 'main_table.created_at'
      ));
  
 $this->addColumn('name', array(
          'header'    => Mage::helper('reporting')->__('Name'),
          'align'     =>'left',
          'index'     => '',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Stuff',
      ));
      
$this->addColumn('email', array(
          'header'    => Mage::helper('reporting')->__('Email'),
          'align'     =>'left',
          'index'     => 'email',
      ));
      
   $this->addColumn('order_state', array(
          'header'    => Mage::helper('reporting')->__('State'),
          'align'     =>'left',
          'index'     => 'order_state',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Customer_Renderer_State',
      ));
      
   $this->addColumn('lab_zip', array(
          'header'    => Mage::helper('reporting')->__('Zip'),
          'align'     =>'left',
          'index'     => 'lab_zip',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Customer_Renderer_Zip',
      ));
            
      $this->addColumn('order_type', array(
            'header'=> Mage::helper('sales')->__('Type'),
            'width' => '70px',
            'type'  => 'options',
            'index' => 'order_type',
            'options'   => array(
              1 => 'L',
              2 => 'H',
          ),
        ));
        
        $this->addColumn('dob', array(
          'header'    => Mage::helper('reporting')->__('Dob'),
          'align'     =>'left',
          'type'	=> 'date',
          'index'     => '',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Dob',
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
        
         $this->addColumn('gender', array(
            'header' => Mage::helper('sales')->__('Gender'),
            'index' => 'gender',
            'filter_index'  => 'customer_entity_int.value',
            'type'  => 'options',
            'width' => '70px',
            'options'   => array(
              1 => 'M',
              2 => 'F',
          ),
        ));
        
        $this->addColumn('notification', array(
            'header' => Mage::helper('sales')->__('Notification'),
            'index' => 'notification',
            'filter_index'  => 'customer_entity_int_2.value',
            'type'  => 'options',
            'width' => '70px',
            'options'   => array(
              '' => 'X',
              0 => 'X',
              13 => 'N',
              14 => 'Y',
          ),
        ));
        
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
      ));

       
$this->addColumn('pstring', array(
          'header'    => Mage::helper('reporting')->__('Products'),
          'align'     =>'left',
          'index'     => 'pstring',
      ));
        
		
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
<?php

class Jag_Tests_Block_Adminhtml_Tests_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('testsGrid');
      $this->setDefaultSort('tests_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
  
  	$customer = Mage::getModel('customer/customer');
        /* @var $customer Mage_Customer_Model_Customer */
        $firstname  = $customer->getAttribute('firstname');
        $lastname   = $customer->getAttribute('lastname');
         $gender   = $customer->getAttribute('gender');
  
      $collection = Mage::getModel('tests/tests')->getCollection()
      ->addFieldToFilter('result',array('eq'=>1));
      $collection->getSelect()->joinLeft('customer_entity', '`customer_entity`.entity_id=main_table.customer_id', array('email'=>'email'), null,'left');
      
      $collection->getSelect()
            ->joinLeft(
                array('customer_lastname_table'=>$lastname->getBackend()->getTable()),
                'customer_lastname_table.entity_id=main_table.customer_id
                 AND customer_lastname_table.attribute_id = '.(int) $lastname->getAttributeId() . '
                 ',
                array('customer_lastname'=>'value')
             )
             ->joinLeft(
                array('customer_firstname_table'=>$firstname->getBackend()->getTable()),
                'customer_firstname_table.entity_id=main_table.customer_id
                 AND customer_firstname_table.attribute_id = '.(int) $firstname->getAttributeId() . '
                 ',
                array('customer_firstname'=>'value')
             )
             ->joinLeft(
                array('customer_gender_table'=>$gender->getBackend()->getTable()),
                'customer_gender_table.entity_id=main_table.customer_id
                 AND customer_gender_table.attribute_id = '.(int) $gender->getAttributeId() . '
                 ',
                array('gender'=>'value')
             );
             
        $collection->getSelect()->joinLeft('sales_flat_order', '`sales_flat_order`.entity_id=main_table.order_id', array('created_at'=>'created_at','order_type'=>'order_type','has_script'=>'has_script','order_type'=>'order_type','lab_type'=>'lab_type','ppmd_lab'=>'ppmd_lab'), null,'left');
        
        
        $collection->getSelect()->joinLeft('prescriptions', '`prescriptions`.order_id=main_table.order_id', array('drugs'=>'drugs','update_time'=>'update_time'), null,'left');
        
             
        $collection->addFilterToMap('customer_lastname','customer_last_name_table.lastname'); 
        $collection->addFilterToMap('customer_firstname','customer_first_name_table.firstname'); 
      
      
		
		//echo $collection->getSelect()->__toString(); exit();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
  
  	$this->addColumn('updated_at', array(
          'header'    => Mage::helper('tests')->__('Result Date'),
          'align'     =>'left',
          
          'type'     => 'date',
          'filter_index'     => 'main_table.updated_at',
          'index'     => 'updated_at',
      ));
  
  	$this->addColumn('created_at', array(
          'header'    => Mage::helper('tests')->__('Order Date'),
          'align'     =>'left',
          
          'type'     => 'date',
          'filter_index'     => 'sales_flat_order.created_at',
          'index'     => 'created_at',
      ));
        
      $this->addColumn('customer_firstname', array(
          'header'    => Mage::helper('tests')->__('Firstname'),
          'align'     =>'left',
          
          'index'     => 'customer_firstname',
      ));
      
      $this->addColumn('customer_lastname', array(
          'header'    => Mage::helper('tests')->__('Lastname'),
          'align'     =>'left',
          
          'index'     => 'customer_lastname',
      ));
      
      $this->addColumn('order_type', array(
          'header'    => Mage::helper('tests')->__('Type'),
          'align'     =>'left',
          
          'index'     => 'order_type',
          'type' 	 => 'options',
          'options'   => array(
              1 => 'L',
              2 => 'H',
          ),
      )); 
      
      $this->addColumn('ppmd_lab', array(
          'header'    => Mage::helper('tests')->__('Address'),
          'align'     =>'left',
          'index'     => 'ppmd_lab',
          'renderer'  => 'Jag_Tests_Block_Adminhtml_Tests_Renderer_Street',
      )); 
      
       $this->addColumn('ppmd_city', array(
          'header'    => Mage::helper('tests')->__('City'),
          'align'     =>'left',
          'index'     => 'ppmd_lab',
          'renderer'  => 'Jag_Tests_Block_Adminhtml_Tests_Renderer_City',
      )); 
      
      $this->addColumn('ppmd_state', array(
          'header'    => Mage::helper('tests')->__('State'),
          'align'     =>'left',
          'index'     => 'ppmd_lab',
          'renderer'  => 'Jag_Tests_Block_Adminhtml_Tests_Renderer_State',
      )); 
      
       $this->addColumn('ppmd_zip', array(
          'header'    => Mage::helper('tests')->__('Zip'),
          'align'     =>'left',
          'index'     => 'ppmd_lab',
          'renderer'  => 'Jag_Tests_Block_Adminhtml_Tests_Renderer_Zip',
      )); 
      
      $this->addColumn('email', array(
          'header'    => Mage::helper('tests')->__('Email'),
          'align'     =>'left',
          'index'     => 'email',
      ));
      
      $this->addColumn('phone', array(
          'header'    => Mage::helper('tests')->__('Phone'),
          'align'     =>'left',
          'index'     => '',
           'renderer'  => 'Jag_Tests_Block_Adminhtml_Tests_Renderer_Phone',
      ));
      
      
	$this->addColumn('gender', array(
          'header'    => Mage::helper('tests')->__('Gender'),
          'align'     =>'left',
          'index'     => 'gender',
          'type' 	 => 'options',
          'options'   => array(
              1 => 'M',
              2 => 'F',
          ),
      ));
	  
	  $this->addColumn('positives', array(
          'header'    => Mage::helper('tests')->__('Positives'),
          'align'     =>'left',
          'index'     => '',
          'renderer'  => 'Jag_Tests_Block_Adminhtml_Tests_Renderer_Tests',
      ));

      
      $this->addColumn('drugs', array(
          'header'    => Mage::helper('tests')->__('Prescription'),
          'align'     =>'left',
          'index'     => 'drugs',
      ));
      
      $this->addColumn('update_time', array(
          'header'    => Mage::helper('tests')->__('Prescript Date'),
          'align'     =>'left',
          'index'     => 'update_time',
          'type' 	  => 'date',
      ));
      
		
		$this->addExportType('*/*/exportCsv', Mage::helper('tests')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('tests')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('tests_id');
        $this->getMassactionBlock()->setFormFieldName('tests');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('tests')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('tests')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('tests/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('tests')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('tests')->__('Status'),
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
<?php

class Jag_Prescriptions_Block_Adminhtml_Prescriptions_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('prescriptionsGrid');
      $this->setDefaultSort('prescriptions_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('prescriptions/prescriptions')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('prescriptions_id', array(
          'header'    => Mage::helper('prescriptions')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'prescriptions_id',
      ));
	  
	  $this->addColumn('order_id', array(
          'header'    => Mage::helper('prescriptions')->__('Order ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'order_id',
           'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Orderlink',
      ));
	  
	  $this->addColumn('customer_id', array(
          'header'    => Mage::helper('prescriptions')->__('Customer ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'customer_id',
      ));


      $this->addColumn('customer_name', array(
          'header'    => Mage::helper('prescriptions')->__('Name'),
          'align'     =>'left',
          'index'     => 'customer_name',
      ));
      
      $this->addColumn('prescription_name', array(
          'header'    => Mage::helper('prescriptions')->__('Script Name'),
          'align'     =>'left',
          'index'     => 'prescription_name',
      ));
      
      
	  
	  $this->addColumn('customer_phone', array(
          'header'    => Mage::helper('prescriptions')->__('Customer Phone'),
          'align'     =>'left',
          'index'     => 'customer_phone',
      ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('prescriptions')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

      $this->addColumn('status', array(
          'header'    => Mage::helper('prescriptions')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              0 => 'Pending',
              1 => 'Complete',
          ),
      ));
	  
        // $this->addColumn('action',
            // array(
                // 'header'    =>  Mage::helper('prescriptions')->__('Action'),
                // 'width'     => '100',
                // 'type'      => 'action',
                // 'getter'    => 'getId',
                // 'actions'   => array(
                    // array(
                        // 'caption'   => Mage::helper('prescriptions')->__('Edit'),
                        // 'url'       => array('base'=> '*/*/edit'),
                        // 'field'     => 'id'
                    // )
                // ),
                // 'filter'    => false,
                // 'sortable'  => false,
                // 'index'     => 'stores',
                // 'is_system' => true,
        // ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('prescriptions')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('prescriptions')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('prescriptions_id');
        $this->getMassactionBlock()->setFormFieldName('prescriptions');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('prescriptions')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('prescriptions')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('prescriptions/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('prescriptions')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('prescriptions')->__('Status'),
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
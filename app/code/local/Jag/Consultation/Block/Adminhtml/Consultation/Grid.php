<?php

class Jag_Consultation_Block_Adminhtml_Consultation_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('consultationGrid');
      $this->setDefaultSort('consultation_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('consultation/consultation')->getCollection();
      $this->setCollection($collection);
      
      //echo $collection->getSelect()->__toString(); exit();
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('consultation_id', array(
          'header'    => Mage::helper('consultation')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'consultation_id',
      ));
	  
	  $this->addColumn('customer_id', array(
          'header'    => Mage::helper('consultation')->__('Customer IDd'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'customer_id',
      ));
      
       $this->addColumn('name', array(
          'header'    => Mage::helper('reporting')->__('Name'),
          'align'     =>'left',
          'index'     => 'customer_id',
          'renderer'  => 'Jag_Reporting_Block_Adminhtml_Rep_Renderer_Stufflink',
      ));
	  

      $this->addColumn('phone', array(
          'header'    => Mage::helper('consultation')->__('Phone'),
          'align'     =>'left',
          'index'     => 'phone',
      ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('consultation')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

      $this->addColumn('status', array(
          'header'    => Mage::helper('consultation')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              0 => 'Pending',
              1 => 'Complete',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('consultation')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('consultation')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('consultation')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('consultation')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('consultation_id');
        $this->getMassactionBlock()->setFormFieldName('consultation');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('consultation')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('consultation')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('consultation/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('consultation')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('consultation')->__('Status'),
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
<?php

class Jag_Localepage_Block_Adminhtml_Localepage_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('localepageGrid');
      $this->setDefaultSort('localepage_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('localepage/localepage')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('localepage_id', array(
          'header'    => Mage::helper('localepage')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'localepage_id',
      ));

      $this->addColumn('name', array(
          'header'    => Mage::helper('localepage')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      ));
      
      $this->addColumn('url_key', array(
          'header'    => Mage::helper('localepage')->__('Url Key'),
          'align'     =>'left',
          'index'     => 'url_key',
      ));
      
      $this->addColumn('template_id', array(
          'header'    => Mage::helper('localepage')->__('Template ID'),
          'align'     =>'left',
          'index'     => 'template_id',
      ));



      $this->addColumn('status', array(
          'header'    => Mage::helper('localepage')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('localepage')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('localepage')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('localepage')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('localepage')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('localepage_id');
        $this->getMassactionBlock()->setFormFieldName('localepage');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('localepage')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('localepage')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('localepage/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('localepage')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('localepage')->__('Status'),
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
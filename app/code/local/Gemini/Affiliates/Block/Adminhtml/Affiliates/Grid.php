<?php



class Gemini_Affiliates_Block_Adminhtml_Affiliates_Grid extends Mage_Adminhtml_Block_Widget_Grid

{

  public function __construct() {
	  
      parent::__construct();
      
	  $this->setId('id');
      $this->setDefaultSort('affiliate_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }


  protected function _prepareCollection() {
      $collection = Mage::getModel('affiliates/affiliates')->getCollection();
      $this->setCollection($collection);

      return parent::_prepareCollection();
  }



  protected function _prepareColumns() {
	 
	 $this->addColumn('id', array(
          'header'    => Mage::helper('affiliates')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
     ));  	
		
     $this->addColumn('affiliate_id', array(
          'header'    => Mage::helper('affiliates')->__('AFFILIATE ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'affiliate_id',
     ));      

	 $this->addColumn('first_name', array(
          'header'    => Mage::helper('affiliates')->__('FIRST NAME'),
          'align'     =>'left',
          'width'     => '150px',
          'index'     => 'first_name'
      ));

      $this->addColumn('last_name', array(
          'header'    => Mage::helper('affiliates')->__('LAST NAME'),
          'align'     =>'left',
          'width'     => '150px',
          'index'     => 'last_name',
      ));

      $this->addColumn('phone', array(
          'header'    => Mage::helper('affiliates')->__('PHONE NUMBER'),
          'align'     =>'left',
          'index'     => 'phone',

      ));

	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('affiliates')->__('Action'),
                'width'     => '50',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('affiliates')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),

                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,

        ));
		

		//$this->addExportType('*/*/exportCsv', Mage::helper('affiliates')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('affiliates')->__('XML'));

      return parent::_prepareColumns();

  	}

    protected function _prepareMassaction()  {

        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('affiliates');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('affiliates')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('affiliates')->__('Are you sure?')
        ));


        return $this;

    }
  	public function getRowUrl($row) {
      	return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  	}



}
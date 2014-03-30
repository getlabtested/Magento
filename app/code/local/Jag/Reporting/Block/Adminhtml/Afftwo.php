<?php
class Jag_Reporting_Block_Adminhtml_Afftwo extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_afftwo';
    $this->_blockGroup = 'reporting';
     $this->_headerText = Mage::helper('reporting')->__('Online Affiliate Report');

    parent::__construct();
    $this->setTemplate('report/grid/container.phtml');
	$this->removeButton('add');
	$this->addButton('filter_form_submit', array(
            'label'     => Mage::helper('reports')->__('Show Report'),
            'onclick'   => 'filterFormSubmit()'
        ));
  	}
    
      
  public function getFilterUrl()
    {
        $this->getRequest()->setParam('filter', null);
        return $this->getUrl('*/*/index', array('_current' => true));
    }
  
}
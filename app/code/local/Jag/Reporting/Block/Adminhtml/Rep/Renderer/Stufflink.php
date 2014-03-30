<?php

class Jag_Reporting_Block_Adminhtml_Rep_Renderer_Stufflink extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
		$c = Mage::getModel('customer/customer')->load($row->getCustomerId());
			
		return '<a style="width:100px;height:100px;" href="'.$this->getUrl('adminhtml/customer/edit',array('id'=>$row->getCustomerId())).'">'.$c->getFirstname().'</a>';

	}


}
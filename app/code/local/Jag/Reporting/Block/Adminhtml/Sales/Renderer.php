<?php

class Jag_Reporting_Block_Adminhtml_Rep_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {

		$value =  $row->getData($this->getColumn()->getIndex());
		
		$name = Mage::getModel('admin/user')->load($value)->getUsername();

		return '<span style="color:red;">'.$name.'</span>';

	}


}
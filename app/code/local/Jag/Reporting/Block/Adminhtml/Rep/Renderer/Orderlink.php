<?php

class Jag_Reporting_Block_Adminhtml_Rep_Renderer_Orderlink extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
				
		return '<a style="width:100px;height:100px;" href="'.$this->getUrl('adminhtml/sales_order/edit',array('id'=>$row->getOrderId())).'">'.$row->getOrderId().'</a>';

	}


}
<?php
class Jag_Productwidget_Block_Productwidget extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
    public function getProductwidget()     
    { 
        if (!$this->hasData('productwidget')) {
            $this->setData('productwidget', Mage::registry('productwidget'));
        }
        return $this->getData('productwidget');
        
    }
	
	public function resetCart() {
		
		if ($quoteId = Mage::getSingleton('core/session')->getQuoteId()) {
			
			$quote = Mage::getModel('sales/quote')->load($quoteId);
			
			if ($quote->getItemsQty() > 0) {
				
				foreach ($quote->getAllItems() as $item) {
					
					$quote->removeItem($item->getId());
					
				}
			
				$quote->collectTotals()->save();	
			
			}
			
		}
		
	}
    
    public function getProducts() {
        	
    	$nnr = Mage::getSingleton('core/session')->getIsNnr();
    	    	    	
    	//if ($nnr) {
    	
    	//	$collection = Mage::getModel('catalog/product')->getCollection()->setStoreId(Mage::app()->getStore()->getId())->addAttributeToSelect('*')->addAttributeToFilter('attribute_set_id',array('eq'=>9));
    		    	
    	//} else {
    	
    		$collection = Mage::getModel('catalog/product')->getCollection()->setStoreId(Mage::app()->getStore()->getId())->addAttributeToSelect('*')->addAttributeToFilter('attribute_set_id',array('eq'=>4));
    	
    	//}

		foreach ($collection->getItems() as $temp) {
															
			$arr = array();
			$arr['id'] = $temp->getId();
			$arr['price'] = $temp->getPrice();
			$arr['name'] = $temp->getName();
			$arr['sku'] = $temp->getSku();
			$arr['name'] = $temp->getName();
			
			
			if ($temp->getTestType() == 9) {
			
				$arr['test_type'] = 'lab';
						
			} else {
			
				$arr['test_type'] = 'home';
						
			}
			
			$catalog[$temp->getSku()] = $arr;
				
		} 
    
    	return $catalog;
    
    }
    
}
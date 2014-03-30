<?php
class Jag_Landingpage_Block_Landingpage extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
        Mage::dispatchEvent('landing_page_session_init');
		return parent::_prepareLayout();
    }
    
     public function getLandingpage()     
     { 
        if (!$this->hasData('landingpage')) {
            $this->setData('landingpage', Mage::registry('landingpage'));
        }
        return $this->getData('landingpage');
        
    }
    
    public function getLab() {
					
		$pscs = Mage::getSingleton('core/session')->getLabsByZip();
						
		//exit();
			
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

		foreach (Mage::getModel('catalog/product')->getCollection() as $temp) {
		
			$id = $temp->getId();
						
			$product = Mage::getModel('catalog/product')->load($id);
			
			$arr = array();
			$arr['id'] = $id;
			$arr['price'] = $product->getPrice();
		
			$catalog[$product->getSku()] = $arr;
		
		} 
    
    	return $catalog;
    
    }
    
}
<?php
class Jag_Localepage_Block_Dynamicfree extends Mage_Core_Block_Template
{

	public $curState;
	
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getDynamicObj()     
     { 
        if (!$this->hasData('dynamic')) {
            $this->setData('dynamic', Mage::registry('dynamic'));
        }
        
        return $this->getDynamic();
        
    }
    
    public function getCityPage()     
     { 
        if (!$this->hasData('localepage')) {
            $this->setData('localepage', Mage::registry('localepage'));
        }
        return $this->getData('localepage');
        
    }
    
    public function getLocalePage()     
     { 
        if (!$this->hasData('localepage')) {
            $this->setData('localepage', Mage::registry('localepage'));
        }
        return $this->getData('localepage');
        
    }
    
    public function getCityList() {
    
    	$state = $this->getDynamicObj()->getState();
    	    	
    	$this->setCurState($state);
    	$this->setCurStateFull($this->getDynamicObj()->getStateFull());
    	    	
    	$cityList = Mage::getModel('localepage/dynamic')->getCollection()
    		->addFieldToFilter('type',array('eq'=>'free'));
    	$cityList->getSelect()->group('city');
    	$cityList->addFieldToFilter('state',array('eq'=>$state))->getItems();
    		    		
    	return $cityList;
    
    } 
    
    public function getStateList() {
    
    	    	
    	$stateList = Mage::getModel('localepage/dynamic')->getCollection();
		$stateList->addFieldToFilter('type',array('eq'=>'free'));
    	$stateList->getSelect()->group('state');
		
    		    		
    	return $stateList->getItems();
    
    } 
    
    public function getLocaleList() {
    
    	$state = $this->getDynamicObj()->getState();
    	$city = $this->getDynamicObj()->getCity();
    	    	
    	$this->setCurState($state);
    	$this->setCurStateFull($this->getDynamicObj()->getStateFull());
    	
    	$this->setCurCity($city);
    	    	    	
    	$localeList = Mage::getModel('localepage/dynamic')->getCollection()
    		->addFieldToFilter('state',array('eq'=>$state))
    		->addFieldToFilter('city',array('eq'=>$city))
			->addFieldToFilter('type',array('eq'=>'free'))
    		->getItems();
    		
    		
    		    		
    	return $localeList;
    
    }
	
	public function getLocaleDetail() {
        	
    	$id = $this->getDynamicObj()->getDynId();
    	    	    	    	
    	$localeDetail = Mage::getModel('localepage/dynamic')->load($id);
    		    		
    	return $localeDetail;
    
    }
	
    
}
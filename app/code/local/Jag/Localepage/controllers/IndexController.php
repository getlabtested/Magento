<?php
class Jag_Localepage_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		if ($localepage = $this->getRequest()->getParam('localepage')) {
		
		Mage::register('localepage', $localepage);
		
		$template = Mage::getModel('template/template')->load($localepage->getTemplateId())->getPath();
		$this->loadLayout();
		
		$block = $this->getLayout()->getBlock('localepage')->setTemplate($template);
 
 		$head = $this->getLayout()->getBlock('head')
			->setDescription($localepage->getMetaDescription())
			->setKeywords($localepage->getMetaKeywords())
 			->setTitle($localepage->getName());
  
		$this->getLayout()->getBlock('localepage')->append($block);
						     
		$this->renderLayout();
	
		} 
    }
    
    public function dynamicAction()
    {
    
    	$this->loadLayout();
    	    	    	
		if ($dynamic = $this->getRequest()->getParam('state')) {
				
		$obj = new Varien_Object;
		
		$obj->setState($this->getRequest()->getParam('state'));
		$obj->setStateFull($this->getRequest()->getParam('stateFull'));
		$obj->setCity($this->getRequest()->getParam('city'));
		$obj->setZip($this->getRequest()->getParam('zip'));
		$obj->setDynId($this->getRequest()->getParam('dyn_id'));
						
		Mage::register('dynamic', $obj);
				
		$template = $this->getRequest()->getParam('template');
								
		$head = $this->getLayout()->getBlock('head');
		
		$stateFull = ucwords($this->getRequest()->getParam('stateFull'));
		$st = ucwords($this->getRequest()->getParam('state'));
		$head->setTitle(ucwords($this->getRequest()->getParam('stateFull'))." STD Testing");
		$head->setDescription("Get tested for STD's in $stateFull: Simply choose your location online, order your customized STD Testing package, and you'll get instant access to testing. Test today, get results online in 3-5 business days.");
		$head->setKeywords("STD testing in $stateFull, STD Testing in $st, $stateFull STD Testing, $st STD Testing, Get Tested for STD's in $stateFull, HIV Testing in $stateFull, AIDS testing in $stateFull, Chlamydia Testing in $stateFull, Herpes Testing in $stateFull, Syphilis Testing in $stateFull, Gonorrhea Testing in $stateFull, Hepatitis Testing in $stateFull");
 			
 		if ($this->getRequest()->getParam('city')) {
 		
 			$stateFull = ucwords($this->getRequest()->getParam('stateFull'));
			$st = ucwords($this->getRequest()->getParam('state'));
 			$city = ucwords($this->getRequest()->getParam('city'));
 			$head = $this->getLayout()->getBlock('head');
 			$head->setTitle("STD Testing in ".ucwords($this->getRequest()->getParam('city')).", ".ucwords($this->getRequest()->getParam('stateFull')));
 			$head->setDescription("Get tested for STD's in $city: Simply choose your location online, order your customized STD Testing package, and you'll get instant access to testing in $city, $stateFull. Test today, get results online in 3-5 business days.");
 			$head->setKeywords("STD testing in $city, $city STD Testing, Get Tested for STD's in $city, HIV Testing in $city, AIDS testing in $city, Chlamydia Testing in $city, Herpes Testing in $city, Syphilis Testing in $city, Gonorrhea Testing in $city, Hepatitis Testing in $city");
 		
 		}
 		
 		if ($this->getRequest()->getParam('dyn_id')) {
 		
 			$localeDetail = Mage::getModel('localepage/dynamic')->load($this->getRequest()->getParam('dyn_id'));
 			
 			$stateFull = ucwords($this->getRequest()->getParam('stateFull'));
			$st = ucwords($this->getRequest()->getParam('state'));
			$zip = $localeDetail->getZip();
 			$city = ucwords($this->getRequest()->getParam('city'));
			$name = $localeDetail->getName();

 			$head = $this->getLayout()->getBlock('head');
 			$head->setTitle(ucwords($localeDetail->getName()).", ".ucwords($this->getRequest()->getParam('stateFull'))." ".$localeDetail->getZip());
 			$head->setDescription("Residents in $zip, you can now get tested for STD's today at $name! Simply choose your location online, order your customized STD Testing package, and you'll get instant access to testing. Test today, get results online in 3-5 business days.");
 			$head->setKeywords("STD testing in $zip, $zip STD Testing, Get Tested for STD's in $zip, HIV Testing in $zip, AIDS testing in $zip, Chlamydia Testing in $zip, Herpes Testing in $zip, Syphilis Testing in $zip, Gonorrhea Testing in $zip, Hepatitis Testing in $zip");
 		
 		}
 				
		$block = $this->getLayout()->getBlock('dynamic')->setTemplate('template/'.$template);
 
		$this->getLayout()->getBlock('dynamic')->append($block);
						     
		$this->renderLayout();
		
		}
    }
	
	public function dynamicfreeAction()
    {
    	    	
		if ($dynamic = $this->getRequest()->getParam('state')) {
				
		$obj = new Varien_Object;
		
		$obj->setState($this->getRequest()->getParam('state'));
		$obj->setStateFull($this->getRequest()->getParam('stateFull'));
		$obj->setCity($this->getRequest()->getParam('city'));
		$obj->setZip($this->getRequest()->getParam('zip'));
		$obj->setDynId($this->getRequest()->getParam('dyn_id'));
								
		Mage::register('dynamic', $obj);
				
		$template = $this->getRequest()->getParam('template');
						
		$this->loadLayout();
		
		$head = $this->getLayout()->getBlock('head')
 			->setTitle("Potential Free STD Testing Centers in ".ucwords($this->getRequest()->getParam('stateFull')));
 			
 		if ($this->getRequest()->getParam('city')) {
 		
 			$head = $this->getLayout()->getBlock('head')
 			->setTitle("Potential Free STD Testing Centers in ".ucwords($this->getRequest()->getParam('city')).", ".strtoupper($this->getRequest()->getParam('state')));
 		
 		}
 		
 		if ($this->getRequest()->getParam('dyn_id')) {
 		
 			$localeDetail = Mage::getModel('localepage/dynamic')->load($this->getRequest()->getParam('dyn_id'));
 			 		
 			$head = $this->getLayout()->getBlock('head')
 			->setTitle(ucwords($localeDetail->getName())." | STD Testing in ".ucwords($this->getRequest()->getParam('city')).", ".ucwords($this->getRequest()->getParam('stateFull')));
 		
 		}
						
		$block = $this->getLayout()->getBlock('dynamicfree')->setTemplate('template/'.$template);
 
		$this->getLayout()->getBlock('dynamicfree')->append($block);
												     
		$this->renderLayout();
		
		}
    }
    
     public function stateLevelAction()
    {
    
    	$this->loadLayout();   
    	
    	
    	$head = $this->getLayout()->getBlock('head')
 			->setTitle("STD Testing Centers in the United States");
    	  
		$this->renderLayout();
    
    }
	
	public function stateLevelFreeAction()
    {
    
    	$this->loadLayout();   
    	
    	$head = $this->getLayout()->getBlock('head')
 			->setTitle("Free STD Clinics in the United States");  
		$this->renderLayout();
    
    }
    
}

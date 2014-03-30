<?php

class Jag_Tests_Adminhtml_ReqController extends Mage_Adminhtml_Controller_action
{
	
	public function indexAction() {
		
		
		$this->loadLayout();
		$this->renderLayout();
		
		


	}	
	
	public function postAction() {
		
		$baseDir = Mage::getBaseDir();
								
		if (isset($_FILES['req']['name']) && $_FILES['req']['name'] != '') {
				
			try {	
				/* Starting upload */	
				$uploader = new Varien_File_Uploader('req');
				
				// Any extention would work
           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png','pdf'));
				$uploader->setAllowRenameFiles(false);

				$uploader->setFilesDispersion(false);
						
				// We set media as the upload dir
				$path = $baseDir . DS . "req/";
				$uploader->save($path, $_FILES['req']['name'] );
				
			} catch (Exception $e) {
				
				print_r($e->getMessage());
	      
	        }
        
		}

		
		echo "Req file uploaded";
		exit();		
	}	
		
}

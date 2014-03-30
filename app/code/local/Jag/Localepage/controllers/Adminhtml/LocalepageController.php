<?php

class Jag_Localepage_Adminhtml_LocalepageController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('localepage/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('localepage/localepage')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
			

			if ($model->getValues() != '') {
			
				$fvArr = unserialize($model->getValues());
									
				foreach ($fvArr as $k=>$v) {
			
				$model->setData($k,$v);		
			
				}		
			
			}
				
			Mage::register('localepage_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('localepage/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);

			$this->_addContent($this->getLayout()->createBlock('localepage/adminhtml_localepage_edit'))
				->_addLeft($this->getLayout()->createBlock('localepage/adminhtml_localepage_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('localepage')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
		
		//mkdir(Mage::getBaseDir('media').DS.'images'.DS);
				
			if (is_array($_FILES) && count($_FILES) > 0) {
			
			$imgs = Mage::getModel('localepage/localepage')->load($this->getRequest()->getParam('id'))->getImages();
			
			$imgs = unserialize($imgs);
											
			if (is_array($imgs) and count($imgs) > 0) {
			
				$tmp['images'] = $imgs;
			
			} else {
			
				$tmp['images'] = array();
			
			}
														
				foreach ($_FILES as $k=>$v) {
				
				if (!is_null($_FILES[$k]['name']) && $_FILES[$k]['name']!= ""){
												
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader($k);
														
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);
					$uploader->setFilesDispersion(false);
							
					$path = Mage::getBaseDir('media').DS.'images'.DS;
					$uploader->save($path, $_FILES[$k]['name']);
										
				} catch (Exception $e) {
				
					print_r($e->getMessage()); exit();
		      
		        }
	        
		        //this way the name is saved in DB
	  			$tmp['images'][$k] = $_FILES[$k]['name'];
	  				  				  			
	  			}
	  		
	  			}
	  			
	  			$data['images'] = serialize($tmp['images']);
	  				  			
			}
			
			
			if (isset($data['fv'])) {		
	  		
	  			$data['values'] = serialize($data['fv']);
	  		
	  		}
	  			  			  			  			  	
			$model = Mage::getModel('localepage/localepage');	
			
			
				
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));				
				
												
			try {
		
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('localepage')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('localepage')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('localepage/localepage');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $localepageIds = $this->getRequest()->getParam('localepage');
        if(!is_array($localepageIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($localepageIds as $localepageId) {
                    $localepage = Mage::getModel('localepage/localepage')->load($localepageId);
                    $localepage->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($localepageIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $localepageIds = $this->getRequest()->getParam('localepage');
        if(!is_array($localepageIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($localepageIds as $localepageId) {
                    $localepage = Mage::getSingleton('localepage/localepage')
                        ->load($localepageId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($localepageIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'localepage.csv';
        $content    = $this->getLayout()->createBlock('localepage/adminhtml_localepage_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'localepage.xml';
        $content    = $this->getLayout()->createBlock('localepage/adminhtml_localepage_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}

<?php

class Jag_Prescriptions_Adminhtml_PrescriptionsController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('prescriptions/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('prescriptions/prescriptions')->load($id);

		if ($model->getId() || $id == 0) {
			
			if ($cId = $model->getCustomerId()) {
			
				$customer = Mage::getModel('customer/customer')->load($cId);
				
				$dob = strtotime($customer->getDob());
				
				$dob = date('m/d/Y',$dob);
				
				$model->setDob($dob)->save();
			
			}
		
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('prescriptions_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('prescriptions/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('prescriptions/adminhtml_prescriptions_edit'))
				->_addLeft($this->getLayout()->createBlock('prescriptions/adminhtml_prescriptions_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('prescriptions')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
	  			
			$model = Mage::getModel('prescriptions/prescriptions');	
			$tmodel = Mage::getModel('prescriptions/prescriptions')->load($this->getRequest()->getParam('id'));	
			
			$origStatus = $tmodel->getStatus();
											
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($tmodel->getCreatedTime() == NULL) {
					$model->setCreatedTime(date('Y-m-d H:i:s',time()-21600))
						->setUpdateTime(null);
				} else {
									
					if ($origStatus != $data['status'] && $data['status'] == 1) {
				
						$model->setUpdateTime(date('Y-m-d H:i:s',time()-21600));
						$model->setCalledIn(date('m/d/Y h:i:s A',time()-21600));
					
					}
				}		
				
				$model->save();
				
				$model->load($this->getRequest()->getParam('id'));
								
				$orderId = $model->getOrderId();
				
				if ($origStatus != $data['status'] && $data['status'] == 1) {
					
			
				Mage::getModel('sales/order')->load($orderId)->addStatusHistoryComment('Prescription Called In '.date('m/d/Y h:i:s A',time()-21600))->save();
	
	 			Mage::getModel('medivo/medivo')->orderComment($orderId,'Prescription Called In '.date('m/d/Y h:i:s A',time()-21600),'CallLog');

					
					Mage::getModel('sendmail/sendmail')->sendEmail($orderId,'ppmd_prescription_available');
					
				}		
				
				
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('prescriptions')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('prescriptions')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('prescriptions/prescriptions');
				 
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
        $prescriptionsIds = $this->getRequest()->getParam('prescriptions');
        if(!is_array($prescriptionsIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($prescriptionsIds as $prescriptionsId) {
                    $prescriptions = Mage::getModel('prescriptions/prescriptions')->load($prescriptionsId);
                    $prescriptions->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($prescriptionsIds)
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
        $prescriptionsIds = $this->getRequest()->getParam('prescriptions');
        if(!is_array($prescriptionsIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($prescriptionsIds as $prescriptionsId) {
                    $prescriptions = Mage::getSingleton('prescriptions/prescriptions')
                        ->load($prescriptionsId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($prescriptionsIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'prescriptions.csv';
        $content    = $this->getLayout()->createBlock('prescriptions/adminhtml_prescriptions_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'prescriptions.xml';
        $content    = $this->getLayout()->createBlock('prescriptions/adminhtml_prescriptions_grid')
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
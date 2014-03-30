<?php

class Gemini_Affiliates_Adminhtml_AffiliatesController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction() {

		$this->loadLayout()
			->_setActiveMenu('affiliates/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Affiliates Manager'), Mage::helper('adminhtml')->__('Affiliates Manager'));
		
		return $this;
	}   


	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

    
    public function editAction() {

		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('affiliates/affiliates')->load($id);

		if ($model->getId() || $id == 0) {
			
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
			
			Mage::register('affiliates_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('affiliates/items');
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Result Manager'), Mage::helper('adminhtml')->__('Result Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Result News'), Mage::helper('adminhtml')->__('Result News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('affiliates/adminhtml_affiliates_edit'))
				->_addLeft($this->getLayout()->createBlock('affiliates/adminhtml_affiliates_edit_tabs'));

			$this->renderLayout();

		} else {

			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('affiliates')->__('Affiliate does not exist'));
			$this->_redirect('*/*/');
		}
	}


	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {

		if ($data = $this->getRequest()->getPost()) {

			// update PAP
					
			$classfile = 'lib/PAP/PapApi.class.php'; 

			if(!file_exists($classfile)) die('PAP API file not exists');
			include $classfile;

            $store_credentials = Mage::helper('ppmd_credentials/pap')->getCredentialsByStoreCode($this->getRequest()->getParam('store_code'));

            $username = $store_credentials['username'];
            $password = $store_credentials['password'];
            $server_url = $store_credentials['server']['url'];

            $session = new Gpf_Api_Session($server_url);

            if(!$session->login($username,$password)) {
              die("Cannot login. Message: ".$session->getMessage());
            }
			
			if(!$this->getRequest()->getParam('id')) { // this is ADD
				
				$affiliate = new Pap_Api_Affiliate($session);
				$affiliate->setUsername($this->getRequest()->getParam('username'));
				$affiliate->setFirstname($this->getRequest()->getParam('first_name'));
				$affiliate->setLastname($this->getRequest()->getParam('last_name'));
				$affiliate->setData('10', $this->getRequest()->getParam('phone'));
				
				try {
					if ($added = $affiliate->add()) {
						//echo "Affiliate saved successfuly";
						// get user_id of affiliate for this record
						$affiliate = new Pap_Api_Affiliate($session);
						$affiliate->setUsername($this->getRequest()->getParam('username'));
						$affiliate->setFirstname($this->getRequest()->getParam('first_name'));
						$affiliate->setLastname($this->getRequest()->getParam('last_name'));
						$affiliate->setData('10', $this->getRequest()->getParam('phone'));
						
						try {
							$affiliate->load();
							
							$data['affiliate_id'] = $affiliate->getUserid();
							
						} catch (Exception $e) {
							die("Cannot load record: ".$affiliate->getMessage());
						}
						
					} else {
						die("Cannot save affiliate: ".$affiliate->getMessage());
					}
				} catch (Exception $e) {
					die("Error while communicating with PAP: ".$e->getMessage());
				}
				
				
			} else { // this is UPDATE 
			
				$affiliate = new Pap_Api_Affiliate($session);
				$affiliate->setUserid($this->getRequest()->getParam('affiliate_id'));
				
				try {
					$affiliate->load();
					
					$affiliate->setUsername($this->getRequest()->getParam('username'));
					$affiliate->setFirstname($this->getRequest()->getParam('first_name'));
					$affiliate->setLastname($this->getRequest()->getParam('last_name'));
					$affiliate->setData('10', $this->getRequest()->getParam('phone'));
					
					try {
						$affiliate->save();
							
					} catch (Exception $e) {
						die("Error while communicating with PAP: ".$e->getMessage());
					}
					
				} catch (Exception $e) {
					die("Cannot load record: ".$affiliate->getMessage());
				}
				
			} // end if
			
			// save localy
			
			$model = Mage::getModel('affiliates/affiliates');		
			
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {

				$model->save();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('affiliates')->__('Affiliate was successfully saved'));
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

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('affiliates')->__('Unable to find affiliate to save'));
        $this->_redirect('*/*/');
	}

 

	public function deleteAction() {

		if( $this->getRequest()->getParam('id') > 0 ) {

			try {
				$model = Mage::getModel('affiliates/affiliates');
				$model->setId($this->getRequest()->getParam('id'))
					->delete();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Affiliate was successfully deleted'));
				$this->_redirect('*/*/');

			} catch (Exception $e) {

				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}

		$this->_redirect('*/*/');
	}


    public function massDeleteAction() {

        $itemsIds = $this->getRequest()->getParam('affiliates');
        if(!is_array($itemsIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select affiliate(s)'));

        } else {

            try {
                foreach ($itemsIds as $itemId) {
                    $item = Mage::getModel('affiliates/affiliates')->load($itemId);
                    $item->delete();
					
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(

                    Mage::helper('adminhtml')->__(
                        'Total of %d affiliate(s) were successfully deleted', count($itemsIds)
                    )
                );

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
	
}

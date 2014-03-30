<?php
class Jag_Medivo_LocalController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        if ($zipCode = $this->getRequest()->getPost('zip_code'))
        {
            Mage::getSingleton('core/session')->setZip($zipCode);
            Mage::getSingleton('core/session')->setLabZip($zipCode);

            $stateModel = Mage::getModel('pricing/pricing')->getCollection()->addFieldToFilter('zip_code',array('eq'=>$zipCode));
            $state = $stateModel->getFirstItem()->getState();
            Mage::getSingleton('core/session')->setOrderState($state);

            if (Mage::helper('medivo')->isNNRState($state)) {
                Mage::getSingleton('core/session')->setIsNnr(1);
            } else {
                Mage::getSingleton('core/session')->setIsNnr(0);
            }
        }

        $this->loadLayout();    
        $this->getLayout()->getBlock('head')->setTitle('Locate STD Testing Centers in Your Neighborhood');
        $this->getLayout()->getBlock('head')->setDescription('getSTDtested.com has nearly 4,000 nationwide STD Testing centers. Enter your zip code in the form below to find a lab. Order your testing, then head to the lab to get STD tested instantly.');
        $this->renderLayout();
    }
    
    public function getlabsAction()
    {
        $zipCode = $this->getRequest()->getPost('zip_code');
        Mage::getSingleton('core/session')->setZip($zipCode);
        Mage::getSingleton('core/session')->setLabZip($zipCode);

        $stateModel = Mage::getModel('pricing/pricing')->getCollection()->addFieldToFilter('zip_code',array('eq'=>$zipCode));
        $state = $stateModel->getFirstItem()->getState();
        Mage::getSingleton('core/session')->setOrderState($state);

        if (Mage::helper('medivo')->isNNRState($state)) {
            Mage::getSingleton('core/session')->setIsNnr(1);
        } else {
            Mage::getSingleton('core/session')->setIsNnr(0);
        }

        $this->loadLayout();
        $this->renderLayout();
    }
    
    public function getlabsmobileAction()
    {
        $zipCode = $this->getRequest()->getPost('zip_code');
        Mage::getSingleton('core/session')->setZip($zipCode);
        Mage::getSingleton('core/session')->setLabZip($zipCode);

        $stateModel = Mage::getModel('pricing/pricing')->getCollection()->addFieldToFilter('zip_code',array('eq'=>$zipCode));
        $state = $stateModel->getFirstItem()->getState();
        Mage::getSingleton('core/session')->setOrderState($state);

        if (Mage::helper('medivo')->isNNRState($state)) {
            Mage::getSingleton('core/session')->setIsNnr(1);
        } else {
            Mage::getSingleton('core/session')->setIsNnr(0);
        }

        $this->loadLayout();     
        $this->renderLayout();
    }

    public function getlabsorderAction()
    {
        $zipCode = $this->getRequest()->getPost('zip_code');
        Mage::getSingleton('core/session')->setZip($zipCode);
        Mage::getSingleton('core/session')->setLabZip($zipCode);

        $stateModel = Mage::getModel('pricing/pricing')->getCollection()->addFieldToFilter('zip_code',array('eq'=>$zipCode));
        $state = $stateModel->getFirstItem()->getState();
        Mage::getSingleton('core/session')->setOrderState($state);

        if (Mage::helper('medivo')->isNNRState($state)) {
            Mage::getSingleton('core/session')->setIsNnr(1);
            $medivo = Mage::getModel('medivo/medivo')->getDbLabsByZip($zipCode);
            echo "<h3>We have 6+ testing locations near you. However, pricing varies due to state regulations in ".Mage::helper('medivo')->getNnrStatesString().". Proceed to checkout to identify your preferred location and view local pricing.</h3>";
        } else {
            Mage::getSingleton('core/session')->setIsNnr(0);
            $medivo = Mage::getModel('medivo/medivo')->getLabsByZip($zipCode);
            echo "<h3>We have 6+ testing locations near you. Select your preferred location during checkout.";
        }
      }
    
    public function getlabscheckoutAction()
    {
        $quote = Mage::getSingleton('checkout/session')->getQuote();

        $zipCode = $this->getRequest()->getPost('zip_code');
        Mage::getSingleton('core/session')->setZip($zipCode);
        Mage::getSingleton('core/session')->setLabZip($zipCode);
        $stateModel = Mage::getModel('pricing/pricing')->getCollection()->addFieldToFilter('zip_code',array('eq'=>$zipCode));
        $state = $stateModel->getFirstItem()->getState();
        Mage::getSingleton('core/session')->setOrderState($state);
        $quote->setOrderState($state);

        if (Mage::helper('medivo')->isNNRState($state) && (Mage::getSingleton('core/session')->getIsNnr() == 0))
        {
            Mage::getSingleton('core/session')->setIsNnr(1);
            $quote->setIsNnr(1);
            $quote->setLabZip($zipCode);
            $quote->setZip($zipCode);
            $quote->setOrderState($state);
            $quote->setLabId(NULL);
            $quote->setLabType(NULL);
            $quote->setLabCode(NULL);
            $quote->save();

            Mage::helper('medivo')->convertCartProductsToNnr();

            echo "NNR"; 
            exit();
        }
        else if(Mage::helper('medivo')->isStateAllowed($state))
        {
            Mage::getSingleton('core/session')->setIsNnr(0);
            $quote->setIsNnr(0);
            $quote->setLabZip($zipCode);
            $quote->setZip($zipCode);
            $quote->setOrderState($state);
            $quote->setLabId(NULL);
            $quote->setLabType(NULL);
            $quote->setLabCode(NULL);
            $quote->save();

            Mage::helper('medivo')->convertCartProductsToNormal();
        }

        // Calling getLabsByZip to ensure that the labs for this zipCode get stored into the current session object
        $medivo = Mage::getModel('medivo/medivo')->getLabsByZip($zipCode);

        $this->loadLayout();
        $this->renderLayout();
    }
    
    public function selectLabAction()
    {
        $labId = $this->getRequest()->getPost('lab_id');
        $labType = $this->getRequest()->getPost('lab_type');

        $lab_zipcode = null;

        foreach (Mage::getSingleton('core/session')->getLabsByZip() as $lab)
        {
            $lab = (array) $lab;
            if (isset($lab['id'])) $tlab = $lab['id'];
            if (isset($lab['nnr_id'])) $tlab = $lab['nnr_id'];

            if ($tlab == $labId) {
                Mage::getSingleton('core/session')->setLabCode($lab['code']);
                Mage::getSingleton('core/session')->setLabZip(substr($lab['zip'],0,5));
                Mage::getSingleton('core/session')->setZip($lab['zip']);
                $lab_zipcode = $lab['zip'];
                Mage::getSingleton('core/session')->setPpmdLab(serialize($lab));

            }
        }

        if (!is_null($lab_zipcode))
        {
            $state = Mage::helper('medivo')->getStateFromZipCode($lab_zipcode);
            if (Mage::helper('medivo')->isNNRState($state))
            {
                Mage::helper('medivo')->convertCartProductsToNnr();
            }
            else if (Mage::helper('medivo')->isStateAllowed($state))
            {
                Mage::helper('medivo')->convertCartProductsToNormal();
            }
        }

        Mage::getSingleton('core/session')->setOrderType(1);
        Mage::getSingleton('core/session')->setLabId($labId);
        Mage::getSingleton('core/session')->setLabType($labType);

        $this->_redirect('std-testing-options');
    }

    public function selectlabcheckoutAction()
    {
        $labId = $this->getRequest()->getParam('lab_id');
        $labType = $this->getRequest()->getParam('lab_type');
        $quote = Mage::getSingleton('checkout/session')->getQuote();

        $lab_zipcode = null;

        foreach (Mage::getSingleton('core/session')->getLabsByZip() as $lab)
        {
            $lab = (array)$lab;
            if (isset($lab['id'])) $tlab = $lab['id'];
            if (isset($lab['nnr_id'])) $tlab = $lab['nnr_id'];
            if ($tlab == $labId)
            {
                $quote->setPpmdLab(serialize($lab));
                $quote->setLabCode($lab['code']);
                Mage::getSingleton('core/session')->setLabZip($lab['zip']);
                Mage::getSingleton('core/session')->setZip(substr($lab['zip'],0,5));
                $lab_zipcode = substr($lab['zip'],0,5);

                Mage::getSingleton('core/session')->setPpmdLab(serialize($lab));
                Mage::getSingleton('core/session')->setLabCode($lab['code']);
                
                $labType = $lab['lab-id'];
            }
        }

        $quote->setLabId($labId)
            ->setLabType($labType)
            ->setOrderType(1)
            ->setLabZip(Mage::getSingleton('core/session')->getLabZip())
            ->setOrderState(Mage::getSingleton('core/session')->getOrderState())
            ->save();

        if (!is_null($lab_zipcode))
        {
            $json_response = array();

            $state = Mage::helper('medivo')->getStateFromZipCode($lab_zipcode);
            if (Mage::helper('medivo')->isNNRState($state))
            {
                Mage::helper('medivo')->convertCartProductsToNnr();

                $order_summary_block = Mage::app()->getLayout()->createBlock("onestepcheckout/commentwrapper");
                $order_summary_block->setTemplate("onestepcheckout/onestepcheckout/order_summary.phtml");

                $order_summary_html = $order_summary_block->toHtml();
                $json_response['order_summary_html'] = $order_summary_html;
            }
            else if (Mage::helper('medivo')->isStateAllowed($state))
            {
                Mage::helper('medivo')->convertCartProductsToNormal();

                $order_summary_block = Mage::app()->getLayout()->createBlock("onestepcheckout/commentwrapper");
                $order_summary_block->setTemplate("onestepcheckout/onestepcheckout/order_summary.phtml");

                $order_summary_html = $order_summary_block->toHtml();
                $json_response['order_summary_html'] = $order_summary_html;
            }
        }

        Mage::getSingleton('core/session')->setQuoteId($quote->getId());
        Mage::getSingleton('core/session')->setLabId($labId);
        Mage::getSingleton('core/session')->setLabType($labType);

        echo json_encode($json_response);
    }
}

<?php
class PPMD_Followup_IndexController extends Mage_Core_Controller_Front_Action
{
    public function unsubscribeAction()
    {
        try
        {
            $encoded_customer_id = $this->getRequest()->getParam('id');
            $customer_id = base64_decode($encoded_customer_id);

            if (!$customer_id || !intval($customer_id))
            {
                Mage::getSingleton('core/session')->addError('The Customer Id provided is not valid');
                $this->loadLayout();
                $this->renderLayout();
                return;
            }

            $customer = Mage::getModel('customer/customer')->load($customer_id);

            if (!$customer->getEntityId())
            {
                Mage::getSingleton('core/session')->addError('The Customer Id provided is not valid');
                $this->loadLayout();
                $this->renderLayout();
                return;
            }

            $customer->setOptedInToEmails(0);
            $customer->save();

            Mage::getSingleton('core/session')->addSuccess('You have been unsubscribed from the system');
        }
        catch (Exception $e)
        {
            Mage::logException($e);
            Mage::getSingleton('core/session')->addError('An Error Occurred While Trying to Unsubscribe');
            $this->loadLayout();
            $this->renderLayout();
            return;
        }

        $this->loadLayout();
        $this->renderLayout();
    }
}

<?php

class PPMD_Followup_Model_Observer
{
    public function scheduleFollowupEmails($observer)
    {
        try
        {
            $this->checkForEmailOptIn($observer);
            $customer = $observer->getCustomer();
            $customer_id = $customer->getEntityId();
            $order = $observer->getOrder();

            $followup_helper = Mage::helper('ppmd_followup');

            foreach ($order->getAllItems() as $item)
            {
                $sku = $item->getSku();
                $followup_helper->scheduleProductFollowup($customer_id, $sku);
            }
        }
        catch (Exception $e)
        {
            Mage::logException($e);
        }
    }

    public function processRecurringFollowupEmails()
    {
        $todays_date = Mage::getModel('core/date')->date('Y-m-d');
        $todays_followups = Mage::getModel('ppmd_followup/followup')
                                ->getCollection()
                                ->addFieldToFilter('scheduled_date', $todays_date);

        $followup_helper = Mage::helper('ppmd_followup');

        foreach ($todays_followups->getItems() as $followup)
        {
            try
            {
                $followup_helper->sendRecurringFollowupEmail($followup->getSku(), $followup->getCustomerId());

                $followup_date = $followup_helper->getRecurringDate($followup->getSku());
                $followup->setScheduledDate($followup_date);

                $scheduled_at_date = Mage::getModel('core/date')->date();
                $followup->setScheduledAt($scheduled_at_date);

                $followup->save();
            }
            catch (Exception $e)
            {
                Mage::logException($e);
            }
        }
    }

    public function checkForEmailOptIn($observer)
    {
        $opted_in = Mage::getSingleton('customer/session')->getData('opted_in_to_emails');

        if (intval($opted_in))
        {
            $customer = $observer->getCustomer();
            $customer->setOptedInToEmails(1);
            $customer->save();
        }
    }
}

<?php

class PPMD_Followup_Helper_Data extends Mage_Core_Helper_Abstract
{
    const STORE_CODE = 'getlabtested';

    protected $_products = null;

    public function _construct()
    {
        $this->_products = array();
    }

    public function scheduleProductFollowup($customer_id, $sku)
    {
        try
        {
            // Send the initial email
            $this->sendInitialFollowupEmail($sku, $customer_id);

            $scheduled_date = $this->getRecurringDate($sku);

            if (!$scheduled_date)
            {
                return;
            }

            $followup = Mage::getModel('ppmd_followup/followup');
            $followup->setSku($sku);

            $followup->setScheduledDate($scheduled_date);
            $followup->setCustomerId($customer_id);

            $scheduled_at_date = Mage::getModel('core/date')->date();
            $followup->setScheduledAt($scheduled_at_date);

            $followup->save();
        }
        catch (Exception $e)
        {
            Mage::logException($e);
        }
    }

    protected function _getProductBySku($sku)
    {
        if (!isset($this->_products[$sku]))
        {
            $product = Mage::getModel('catalog/product')
                                        ->getCollection()
                                        ->addFieldToFilter('sku', $sku)
                                        ->getFirstItem();

            $this->_products[$sku] = $product->load($product->getEntityId());
        }

        return $this->_products[$sku];
    }

    public function sendInitialFollowupEmail($sku, $customer_id)
    {
        try
        {
            if (!$this->isCustomerOptedIn($customer_id))
            {
                return;
            }

            $product = $this->_getProductBySku($sku);

            $initial_email = $product->getFollowupInitialEmail();

            if ($initial_email)
            {
                $subject = $product->getFollowupInitialEmailSubject();
                $this->sendFollowupEmail($initial_email, $customer_id, $subject, $product);
                return true;
            }
        }
        catch (Exception $e)
        {
            Mage::logException($e);
        }

        return false;
    }

    public function sendRecurringFollowupEmail($sku, $customer_id)
    {
        try
        {
            if (!$this->isCustomerOptedIn($customer_id))
            {
                return;
            }

            $product = $this->_getProductBySku($sku);

            $recurring_email = $product->getFollowupRecurringEmail();
            if ($recurring_email)
            {
                $subject = $product->getFollowupRecurringEmailSubject();
                $this->sendFollowupEmail($recurring_email, $customer_id, $subject, $product);
                return true;
            }
        }
        catch (Exception $e)
        {
            Mage::logException($e);
        }

        return false;
    }

    public function isCustomerOptedIn($customer_id)
    {
        $customer = Mage::getModel('customer/customer')->load($customer_id);
        return $customer->getOptedInToEmails();
    }

    public function sendFollowupEmail($transactional_email_code, $customer_id, $subject, $product)
    {
        $followup_email_template = Mage::getModel('core/email_template');
        $followup_email_template->getMail()->setSubject($subject);

        $customer = Mage::getModel('customer/customer')->load($customer_id);
        $opt_out_link = $this->getOptOutLink($customer_id);
        $recurring_period = $product->getFollowupPeriodDays();
        $product_name = $product->getName();

        $glt_store = Mage::app()->getStore(self::STORE_CODE);
        $product_url = $glt_store->getBaseUrl() . $product->getUrlPath();

        $followup_email_template->sendTransactional($transactional_email_code,'general', $customer->getEmail(), $customer->getFirstname().' '.$customer->getLastname(), array('customer' => $customer, 'opt_out_link' => $opt_out_link, 'followup_period_days' => $recurring_period, 'product_name' => $product_name, 'product_url' => $product_url));
    }

    public function getOptOutLink($customer_id)
    {
        $encoded_id = base64_encode($customer_id);
        $glt_store = Mage::app()->getStore(self::STORE_CODE);
        $opt_out_link = $glt_store->getUrl('followup/index/unsubscribe', array('id' => $encoded_id));

        return $opt_out_link;
    }

    public function getRecurringDate($sku)
    {
        try
        {
            $product = $this->_getProductBySku($sku);

            $recurring_period = $product->getFollowupPeriodDays();

            if (!$recurring_period)
            {
                return false;
            }

            $period_days = intval($recurring_period);

            // Make sure curring period isn't 0
            if (!$period_days)
            {
                return false;
            }

            $recurring_date = strtotime("+" . $period_days . " days");
            $as_date = date('Y-m-d', $recurring_date);

            return $as_date;
        }
        catch (Exception $e)
        {
            Mage::logException($e);
        }

        return false;
    }
}

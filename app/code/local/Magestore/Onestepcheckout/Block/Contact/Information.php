<?php

class Magestore_Onestepcheckout_Block_Contact_Information extends Magestore_Onestepcheckout_Block_Onestepcheckout
{
    protected $_is_temporary_post = null;
    protected $_temporary_post = null;
    protected $_dob = null;

    public function getIsTemporaryPost()
    {
        if (!is_null($this->_is_temporary_post))
        {
            return $this->_is_temporary_post;
        }

        $tpost = $this->getTemporaryPost();
        $this->_is_temporary_post = (is_array($tpost) && (count($tpost) > 0));
        return $this->_is_temporary_post;
    }

    public function getTemporaryPost()
    {
        if (!is_null($this->_temporary_post))
        {
            return $this->_temporary_post;
        }
        $this->_temporary_post = Mage::getSingleton('checkout/session')->getTmpPost();
        return $this->_temporary_post;
    }

    public function isVirtualCheckout()
    {
        return ((Mage::getSingleton('checkout/session')->getQuote()->getOrderType() == 1)
                ||
                (Mage::getSingleton('core/session')->getOrderType() == 1));
    }

    public function getStateSelectOptions()
    {
        return Mage::helper('onestepcheckout')->getRegionIdData();
    }

    public function getCustomerBillingAddress()
    {
        $customer_session_data = $this->getCustomerSessionData();
        $billing_address_id = $customer_session_data['default_billing'];
        $customer_address = Mage::getModel('customer/address')->load($billing_address_id);

        return $customer_address;
    }

    public function getRegionId()
    {
        $customer_address = $this->getCustomerBillingAddress();
        return $customer_address->getRegionId();
    }

    public function getMonthData()
    {
        return Mage::helper('onestepcheckout')->getBirthdayMonthData();
    }

    public function getCustomerBirthday()
    {
        if ($this->isCustomerLoggedIn())
        {
            if (!is_null($this->_dob))
            {
                return $this->_dob;
            }
            $customer_session_data = $this->getCustomerSessionData();

            if (isset($customer_session_data['dob'])) {
                $dob_string_array = explode(" ",$customer_session_data['dob']);
                $this->_dob = explode("-", $dob_string_array[0]);
                return $this->_dob;
            }
        }
        $this->_dob = '';
        return $this->_dob;
    }

    public function isBirthdayMonth($birthday_month)
    {
        $customer_birthday = $this->getCustomerBirthday();
        if (
            is_array($customer_birthday)
            &&
            isset($customer_birthday[1])
            &&
            ($customer_birthday[1] == $birthday_month)
        )
        {
            return true;
        }

        if ($this->getIsTemporaryPost())
        {
            $customer_info_post = $this->getTemporaryPost();
            return ($customer_info_post['m_select'] == $birthday_month);
        }

        return false;
    }
}

<?php

class PPMD_Tests_Helper_Vendors extends Mage_Core_Helper_Abstract
{
    const PRODUCT_TEST_TYPE_VENDOR_CONVERSIONS_CONFIG = 'ppmd_tests/test_type_vendors';

    const EMAIL_TEMPLATE_CONFIG_REGEX = '##VENDOR##/emails/templates';
    const UNALLOWED_STATES_CONFIG_REGEX = '##VENDOR##/unallowed_states/list';
    const UNALLOWED_STATE_STRING = 'ppmd_tests/unallowed_state_message';
    const PRODUCT_VENDOR_ATTRIBUTE = 'test_type';

    const EMAIL_SUBJECT_CONFIG_NODE = 'subject';
    const EMAIL_TEMPLATE_CONFIG_NODE = 'template_name';
    const ORDER_SUCCESS_EMAIL_TYPE = 'order_success';

    protected $_vendor_name = 'testsdefault';

    public function getTestVendorProducts($item_list, $get_items = false)
    {
        $test_vendors = array();

        foreach ($item_list as $item)
        {
            $product_id = $item->getProductId();
            $product = Mage::getModel('catalog/product')->load($product_id);
            $test_type_value = $this->getFrontendAttributeValue($product, self::PRODUCT_VENDOR_ATTRIBUTE);
            $test_vendor = $this->convertTestTypeAttributeValueToVendor($test_type_value);

            if (!isset($test_vendors[$test_vendor]))
            {
                $test_vendors[$test_vendor] = array();
            }
            if ($get_items)
            {
                $test_vendors[$test_vendor][] = $item;
            }
            else
            {
                $test_vendors[$test_vendor][] = $product;
            }
        }

        return $test_vendors;
    }

    public function sendVendorOrderSuccessEmails($order, $customer, $new_randomly_generated_password)
    {
        try
        {
            $test_vendors = $this->getOrderTestVendorProducts($order);

            foreach ($test_vendors as $vendor => $products)
            {
                $test_vendor_helper = Mage::helper($vendor);
                $test_vendor_helper->sendVendorEmails(self::ORDER_SUCCESS_EMAIL_TYPE, $order, $customer, $new_randomly_generated_password);
            }
        }
        catch (Exception $e)
        {
            Mage::logException($e);
            return false;
        }

        return true;
    }

    public function sendVendorEmails($email_type, $order, $customer, $new_randomly_generated_password)
    {
        try
        {
            $purchase_emails_to_send = $this->getEmailTemplatesToSend($email_type);

            foreach ($purchase_emails_to_send as $email_to_send)
            {
                $html_list_of_products = $this->getListOfVendorProducts($order, $this->_vendor_name);

                $email_template = Mage::getModel('core/email_template');
                $email_subject = $email_to_send[self::EMAIL_SUBJECT_CONFIG_NODE];
                $email_template->getMail()->setSubject($email_subject);

                $email_template_to_send = $email_to_send[self::EMAIL_TEMPLATE_CONFIG_NODE];
                $email_template->sendTransactional($email_template_to_send, 'general', $customer->getEmail(), $customer->getFirstname().' '.$customer->getLastname(),array('order'=>$order,'customer'=>$customer, 'pass' => $new_randomly_generated_password, 'product_list' => $html_list_of_products));
            }
        }
        catch (Exception $e)
        {
            Mage::logException($e);
            return false;
        }
        return true;
    }

    public function getVirtualProductsByVendorCode($items, $vendor_code, $get_items = false)
    {
        $vendor_products = $this->getTestVendorProducts($items, $get_items);

        if (!isset($vendor_products[$vendor_code]))
        {
            return array();
        }

        return Mage::helper('ppmd_tests')->getVirtualProducts($vendor_products[$vendor_code], $get_items);
    }

    public function getListOfVendorProducts($order, $vendor_code)
    {
        $html_list_of_products = '';
        $vendor_products = $this->getSpecificVendorProducts($order->getAllItems(), $vendor_code);
        foreach ($vendor_products as $product)
        {
            $html_list_of_products .= "<li>" . $product->getName() . "</li>\n";
        }

        return $html_list_of_products;
    }

    public function convertTestTypeAttributeValueToVendor($test_type_value)
    {
        // Account for legacy having sent everything to medivo observer
        if ('No' == $test_type_value)
        {
            return 'medivo';
        }
        $test_type_config_path = self::PRODUCT_TEST_TYPE_VENDOR_CONVERSIONS_CONFIG . "/" . $test_type_value;
        $vendor_code = Mage::getStoreConfig($test_type_config_path);

        return $vendor_code;
    }

    public function getEmailTemplatesToSend($email_type)
    {
        $vendor_config_path = $this->getVendorSpecificConfigPath(self::EMAIL_TEMPLATE_CONFIG_REGEX);
        $email_templates_config_path = $vendor_config_path . "/" . $email_type;

        return Mage::getStoreConfig($email_templates_config_path);
    }

    public function getVendorSpecificConfigPath($config_type)
    {
        $vendor_config_path = str_replace('##VENDOR##', $this->_vendor_name, $config_type);
        return $vendor_config_path;
    }

    public function getVendorUnallowedStates()
    {
        return array_keys(Mage::getStoreConfig($this->getVendorSpecificConfigPath(self::UNALLOWED_STATES_CONFIG_REGEX)));
    }

    public function getOrderTestVendorProducts($order)
    {
        return $this->getTestVendorProducts($order->getAllItems());
    }

    public function getProductVendors($item_list)
    {
        $product_vendors = $this->getTestVendorProducts($item_list);
        return array_keys($product_vendors);
    }

    public function getSpecificVendorProducts($items, $lab_vendor, $get_items = false)
    {
        $vendor_products = $this->getTestVendorProducts($items, $get_items);
        if (isset($vendor_products[$lab_vendor]))
        {
            return $vendor_products[$lab_vendor];
        }
        return array();
    }
    
    public function getUnallowedStateMessage($unallowed_states)
    {
        if (is_array($unallowed_states))
        {
            $unallowed_states = implode(", ", $unallowed_states);
        }

        $unallowed_states_message = Mage::getStoreConfig(self::UNALLOWED_STATE_STRING);
        return sprintf($unallowed_states_message, $unallowed_states);
    }
    
    public function getUnallowedVendorStatesByQuote($quote)
    {
        $quote_vendors = $this->getTestVendorProducts($quote->getAllItems());
        $vendors = array_keys($quote_vendors);
        $unallowed_states_list = array();

        foreach ($vendors as $vendor)
        {
            $unallowed_states = Mage::helper($vendor)->getVendorUnallowedStates();
            $unallowed_states_list = array_merge($unallowed_states_list, $unallowed_states);
        }
        $unallowed_states_list = array_unique($unallowed_states_list);

        return $unallowed_states_list;
    }

    public function getFrontendAttributeValue($product, $attribute_code)
    {
        $value = $product->getResource()
                    ->getAttribute($attribute_code)
                    ->getFrontend()
                    ->getValue($product);

        return $value;
    }

    public function getVendorCode()
    {
        return $this->_vendor_name;
    }
}

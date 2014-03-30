<?php

class PPMD_Credentials_Helper_Pap extends PPMD_Credentials_Helper_Data
{
    const PAP_STORE_CREDENTIALS_CONFIG_PATH = 'ppmd_credentials/pap';
    const DEFAULT_PAP_STORE_CONFIGURATION_CONFIG = 'ppmd_credentials/pap/default/store_code';

    protected $_stores_credentials = null;

    public function getAllStoreCredentials()
    {
        if (is_null($this->_stores_credentials))
        {
            $this->_stores_credentials = Mage::getStoreConfig(self::PAP_STORE_CREDENTIALS_CONFIG_PATH);
        }
        return $this->_stores_credentials;
    }

    public function getStoresWithCredentials()
    {
        $store_credentials = $this->getAllStoreCredentials();

        if (is_array($store_credentials))
        {
            $store_codes = array_keys($store_credentials);
            $store_credentials_array = array_combine($store_codes, $store_codes);
            return $store_credentials_array;
        }
        return array();
    }

    public function getCredentialsByStoreCode($store_code, $get_default = true)
    {
        $stores_credentials = $this->getAllStoreCredentials();

        if (isset($stores_credentials[$store_code]))
        {
            return $stores_credentials[$store_code];
        }

        if ($get_default)
        {
            return $stores_credentials[$this->getDefaultStoreCode()];
        }

        return array();
    }

    public function getDefaultStoreCode()
    {
        return Mage::getStoreConfig(self::DEFAULT_PAP_STORE_CONFIGURATION_CONFIG);
    }
}

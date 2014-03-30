<?php
class Jag_Userdashboard_Block_Tabs_Customer extends Mage_Core_Block_Template
{
	
	 public function getCustomer(){       
	 	return Mage::getSingleton('customer/session')->getCustomer();
    }

    public function getChangePasswordUrl(){
        return Mage::getUrl('*/account/edit/changepass/1');
    }
 	
	public function getCountries() {
        return Mage::getResourceModel('directory/country_collection')->loadByStore();
    }
	
	public function getAddress(){
		$customerAddressId  = $this->getCustomer()->getDefaultBilling();
	 if ($customerAddressId)
		   $address = Mage::getModel('customer/address')->load($customerAddressId);
	 
	 return $address;
	}
	
	public function getCountryHtmlSelect()
    {
        $countryId = $this->getAddress()->getCountryId();
        if (is_null($countryId)) {
            $countryId = Mage::helper('core')->getDefaultCountry();
        }
        $select = $this->getLayout()->createBlock('core/html_select')
            ->setName('country_id')
            ->setId('country')
            ->setTitle(Mage::helper('checkout')->__('Country'))
            ->setClass('validate-select')
            ->setValue($countryId)
            ->setOptions($this->getCountryOptions());
        
        return $select->getHtml();
    }
	public function getCountryCollection()
    {
        if (!$this->_countryCollection) {
            $this->_countryCollection = Mage::getSingleton('directory/country')->getResourceCollection()
                ->loadByStore();
        }
        return $this->_countryCollection;
    }

	public function getCountryOptions()
    {
        $options    = false;
        $useCache   = Mage::app()->useCache('config');
        if ($useCache) {
            $cacheId    = 'DIRECTORY_COUNTRY_SELECT_STORE_' . Mage::app()->getStore()->getCode();
            $cacheTags  = array('config');
            if ($optionsCache = Mage::app()->loadCache($cacheId)) {
                $options = unserialize($optionsCache);
            }
        }

        if ($options == false) {
            $options = $this->getCountryCollection()->toOptionArray();
            if ($useCache) {
                Mage::app()->saveCache(serialize($options), $cacheId, $cacheTags);
            }
        }
        return $options;
    }
	
	public function getSaveUrl()
    {
        return Mage::getUrl('userdashboard/account/editPost/', array('_secure'=>true, 'id'=>$this->getAddress()->getId()));
    }

}
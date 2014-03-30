<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Adminhtml sales order create sidebar
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Mage_Adminhtml_Block_Sales_Order_Create_Form extends Mage_Adminhtml_Block_Sales_Order_Create_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('sales_order_create_form');
    }

    /**
     * Retrieve url for loading blocks
     * @return string
     */
    public function getLoadBlockUrl()
    {
        return $this->getUrl('*/*/loadBlock');
    }

    /**
     * Retrieve url for form submiting
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save');
    }

    public function getCustomerSelectorDisplay()
    {
        $customerId = $this->getCustomerId();
        if (is_null($customerId)) {
            return 'block';
        }
        return 'none';
    }

    public function getStoreSelectorDisplay()
    {
        $storeId    = $this->getStoreId();
        $customerId = $this->getCustomerId();
        if (!is_null($customerId) && !$storeId) {
            return 'block';
        }
        return 'none';
    }

    public function getDataSelectorDisplay()
    {
        $storeId    = $this->getStoreId();
        $customerId = $this->getCustomerId();
        if (!is_null($customerId) && $storeId) {
            return 'block';
        }
        return 'none';
    }

    public function getOrderDataJson()
    {
        $data = array();
        if (!is_null($this->getCustomerId())) {
            $data['customer_id'] = $this->getCustomerId();
            $data['addresses'] = array();

            /* @var $addressForm Mage_Customer_Model_Form */
            $addressForm = Mage::getModel('customer/form')
                ->setFormCode('adminhtml_customer_address')
                ->setStore($this->getStore());
            foreach ($this->getCustomer()->getAddresses() as $address) {
                $data['addresses'][$address->getId()] = $addressForm->setEntity($address)
                    ->outputData(Mage_Customer_Model_Attribute_Data::OUTPUT_FORMAT_JSON);
            }
        }
        if (!is_null($this->getStoreId())) {
            $data['store_id'] = $this->getStoreId();
            $currency = Mage::app()->getLocale()->currency($this->getStore()->getCurrentCurrencyCode());
            $symbol = $currency->getSymbol() ? $currency->getSymbol() : $currency->getShortName();
            $data['currency_symbol'] = $symbol;
            $data['shipping_method_reseted'] = !(bool)$this->getQuote()->getShippingAddress()->getShippingMethod();
            $data['payment_method'] = $this->getQuote()->getPayment()->getMethod();
        }
        return Mage::helper('core')->jsonEncode($data);
    }

    public function getProductsByPostedStoreId($store_id = 4)
    {
        if (!($store_id = Mage::app()->getRequest()->getPost('store_id')))
        {
            $store_id = 4;
        }

        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addStoreFilter($store_id)
            ->addAttributeToSelect("*")
            ->addAttributeToFilter('status',array('eq'=>1))
            ->addAttributeToFilter('attribute_set_id',array('eq'=>4))
            // We don't want to grab home test product here
            ->addAttributeToFilter('sku', array('nlike'=>'%home%'));

        if ($this->getIsNNR())
        {
            $collection = $collection->addAttributeToFilter('sku',array('like'=>'nnr%'));
        }
        else
        {
            $collection = $collection->addAttributeToFilter('sku',array('nlike'=>'nnr%'));
        }

        return $collection;
    }

	  public function getLabProducts()
	  {
          $store_id = Mage::app()->getStore()->getStoreId();
          $website_id = Mage::getModel('core/store')->load($store_id)->getWebsiteId();

	    $collection= Mage::getModel('catalog/product')->getCollection()
	    	->addStoreFilter($website_id)
			->addAttributeToSelect("*")
			->addAttributeToFilter('attribute_set_id',array('eq'=>4))
			->addAttributeToFilter('sku',array('nlike'=>'nnr%'));
					
		return $collection;
		
	  }
	  
	  public function getNnrLabProducts()
	  {
	    $collection= Mage::getModel('catalog/product')->getCollection()
	    	->setStoreId(Mage::app()->getStore()->getStoreId())
			->addAttributeToSelect("*")
			->addAttributeToFilter('attribute_set_id',array('eq'=>9))
			->addAttributeToFilter('sku',array('like'=>'nnr%'));
					
		return $collection;
		
	  }

	 public function getNnrHomeProducts()
	  {
	    $collection= Mage::getModel('catalog/product')->getCollection()
	    	->setStoreId(Mage::app()->getStore()->getStoreId())
			->addAttributeToSelect("*")
			->addAttributeToFilter('attribute_set_id',array('eq'=>9))
			->addAttributeToFilter('sku',array('like'=>'%home%'));
					
		return $collection;
		
	  }
	  
	  public function getHomeProducts()
	  {
	    $collection= Mage::getModel('catalog/product')->getCollection()
	    	->setStoreId(Mage::app()->getStore()->getStoreId())
			->addAttributeToSelect("*")
			->addAttributeToFilter('attribute_set_id',array('eq'=>4))
			->addAttributeToFilter('sku',array('like'=>'%home%'));
		
		return $collection;
		
	  }
	  
	  public function getPrescriptionProducts()
	  {
	    $collection= Mage::getModel('catalog/product')->getCollection()
	    	->setStoreId(Mage::app()->getStore()->getStoreId())
			->addAttributeToSelect("*")
			->addAttributeToFilter('attribute_set_id',array('eq'=>10));
		
		return $collection;
		
	  }
	  


}

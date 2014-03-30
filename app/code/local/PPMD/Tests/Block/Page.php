<?php

class PPMD_Tests_Block_Page extends Mage_Core_Block_Template
{
    protected $_root_test_category = null;
    protected $_root_test_subcategories = null;
    protected $_currentCategory = null;
    protected $_subcategoryUrlKey = null;
    protected $_subcategoryCssClass = null;

    public function getRootTestCategory()
    {
        if (is_null($this->_root_test_category))
        {
            $this->_root_test_category = Mage::helper('ppmd_tests')->getRootTestCategory();
        }

        return $this->_root_test_category;
    }

    public function getTestSubcategories()
    {
        if (is_null($this->_root_test_subcategories))
        {
            if (is_null($this->_root_test_category))
            {
                $this->_root_test_category = $this->getRootTestCategory();
            }

            $this->_root_test_subcategories = $this->_root_test_category->getChildrenCategories();
        }

        return $this->_root_test_subcategories;
    }

    public function getCurrentCategory()
    {
        if (is_null($this->_currentCategory))
        {
            $this->_currentCategory = Mage::helper('ppmd_tests')->getCurrentCategory();
        }

        return $this->_currentCategory;
    }

    public function getSubcategoryUrlKey()
    {
        if (is_null($this->_subcategoryUrlKey))
        {
            $current_category = $this->getCurrentCategory();
            if (!$current_category)
            {
                $this->_subcategoryUrlKey = '';
                return $this->_subcategoryUrlKey;
            }

            $this->_subcategoryUrlKey = $current_category->getUrlKey();
        }

        return $this->_subcategoryUrlKey;
    }

    public function getProductCollection()
    {
        $subcategory_url_key = $this->getSubcategoryUrlKey();

        $product_collection = null;

        if ($subcategory_url_key)
        {
            $current_category = $this->getCurrentCategory();
            $product_collection = $current_category->getProductCollection();

            $product_collection = $this->addTemplateAttributes($product_collection);
        }
        else
        {
            $product_collection = Mage::getModel('catalog/product')->getCollection()
                                    ->addStoreFilter()
                                    ->addAttributeToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED);

            $product_collection = $this->addTemplateAttributes($product_collection);
        }

        return $product_collection;
    }

    public function addTemplateAttributes($product_collection)
    {
        $sorted_product_collection = $product_collection
                                ->addAttributeToSelect(array('description', 'short_description', 'price', 'special_price'))
                                ->addAttributeToSort('name');

        return $sorted_product_collection;
    }

    public function getDefaultSubcategoryCssClass()
    {
        if (is_null($this->_subcategoryCssClass))
        {
            $this->_subcategoryCssClass = $this->getSubcategoryUrlKey();
            if (!$this->_subcategoryCssClass)
            {
                $this->_subcategoryCssClass = Mage::app()->getStore()->getCode();
            }
        }

        return $this->_subcategoryCssClass;
    }
}

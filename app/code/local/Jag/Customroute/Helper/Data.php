<?php

class Jag_Customroute_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * If the post is adding a product which has 'is_std_test' set to true, remove all other
     * products in the cart which have 'is_std_test' set to true
     *
     * @param $post
     * @param $quote
     */
    public function clearCartIfNeeded($post, $quote)
    {
        // Check if at-home tests have been added to the cart, or if there are home tests already in the cart
        if ($this->atHomeTestsInPost($post) || $this->cartContainsHomeItems())
        {
            // Empty the cart of all tests
            $this->clearCart($quote);
            return;
        }
        // Check that $post is not a prescription addition
        if (!isset($post['script']) || !$post['script'])
        {
            $this->clearCartAsNecessary($post, $quote);
        }
    }

    public function atHomeTestsInPost($post)
    {
        return in_array('homeTest', array_keys($post));
    }

    public function cartContainsHomeItems()
    {
        $quote = $this->getQuote();
        foreach ($quote->getAllItems() as $item)
        {
            $product_sku = $item->getSku();
            if (false !== strpos($product_sku, 'home'))
            {
                return true;
            }
        }
        return false;
    }

    public function clearCartAsNecessary($post, $quote)
    {
        $post_product_ids = $this->getPostProductIds($post);
        $std_test_in_post = $this->checkPostForStdTests($post_product_ids);

        foreach ($quote->getAllItems() as $item)
        {
            $product_id = $item->getProductId();
            $product = Mage::getModel('catalog/product')->load($product_id);

            if (in_array($product_id, $post_product_ids) || ($std_test_in_post && $product->getIsStdTest()))
            {
                $quote->removeItem($item->getId());
                // Also remove the item from the Mage::getSingleton('core/session')->getCartArr();
                $cart_array = Mage::getSingleton('core/session')->getCartArr();
                $cart_array_index = array_search($product_id, $cart_array);

                if ($cart_array_index !== FALSE)
                {
                    unset($cart_array[$cart_array_index]);
                }
                Mage::getSingleton('core/session')->setCartArr($cart_array);
            }
        }
    }

    public function clearCart($quote)
    {
        foreach ($quote->getAllItems() as $item)
        {
            $quote->removeItem($item->getId());
        }
        Mage::getSingleton('core/session')->setCartArr(null);
    }

    public function convertCartItemsToNNR()
    {
        $quote = $this->getQuote();
        $newIds = array();

        foreach ($quote->getAllItems() as $item)
        {
            $sku = $item->getSku();

            if (strpos($sku, "nnr-") !== 0)
            {
                $quote->removeItem($item->getId());
                $nnr_product_id = Mage::getModel('catalog/product')->getIdBySku("nnr-".$sku);
                $newIds[] = $nnr_product_id;
            }
        }

        $checkout = Mage::getSingleton('checkout/cart');
        $checkout->addProductsByIds($newIds);
    }

    public function getQuote()
    {
        $quote = Mage::getSingleton('checkout/session')->getQuote();

        if ($quote->getId()) {
            $quote = $quote;
        }
        else {
            $quote = Mage::getModel('checkout/cart')->getQuote();
        }

        return $quote;
    }

    public function getPostProductIds($post_array)
    {
        $post_product_ids = array();

        foreach ($post_array as $key => $value)
        {
            if (is_array($value))
            {
                $product_ids = $this->getPostProductIds($value);
                $post_product_ids = array_merge($post_product_ids, $product_ids);
            }
            else
            {
                $potential_product_id = Mage::getModel('catalog/product')->getIdBySku($key);
                if ($potential_product_id)
                {
                    $post_product_ids[] = $potential_product_id;
                }
            }
        }

        return $post_product_ids;
    }

    public function checkPostForStdTests($post_array)
    {
        foreach ($post_array as $product_id)
        {
            $product = Mage::getModel('catalog/product')->load($product_id);
            if ($product->getIsStdTest())
            {
                return true;
            }
        }

        return false;
    }

    public function checkForUpsellItems($post_array)
    {
        foreach ($post_array as $key => $value)
        {
            if (is_array($value))
            {
                $upsell_item_present = $this->checkForUpsellItems($value);
                if ($upsell_item_present)
                {
                    return true;
                }
            }
            else
            {
                $potential_product_id = Mage::getModel('catalog/product')->getIdBySku($key);
                if ($potential_product_id)
                {
                    $product = Mage::getModel('catalog/product')->load($potential_product_id);
                    if ($product->getIsUpsellProduct())
                    {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}
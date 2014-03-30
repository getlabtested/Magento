<?php

class Magestore_Upsell_Model_Observer
{
    public function checkForUpsellPage($observer)
    {
        $controller = $observer->getControllerAction();
        $full_action_name = $controller->getFullActionName();

        if (Mage::helper('upsell')->getUpsellIndexRoute() == $full_action_name)
        {
            Mage::getSingleton('core/session')->setData('JUST_VISITED_UPSELL_PAGE', 1);
        }
        elseif (Mage::helper('upsell')->getCheckoutPageIndexRoute() == $full_action_name)
        {
            if ($this->shouldUpsellBeShown())
            {
                if (!Mage::getSingleton('checkout/session')->getSkipUpsell())
                {
                    $upsell_index_url = Mage::helper('upsell')->getUpsellIndexUrl();

                    $observer->getControllerAction()->getResponse()->setRedirect(Mage::getUrl($upsell_index_url));
                    $observer->getControllerAction()->getResponse()->sendResponse();
                    exit;
                }
                else
                {
                    Mage::getSingleton('checkout/session')->setSkipUpsell(false);
                }
            }
            Mage::getSingleton('core/session')->setData('JUST_VISITED_UPSELL_PAGE', 0);
            Mage::getSingleton('core/session')->setPreventUpsellPage(0);
        }
        else if( ! in_array($full_action_name, Mage::helper('upsell')->getIntermediateCheckoutRoutes()) )
        {
            Mage::getSingleton('core/session')->setData('JUST_VISITED_UPSELL_PAGE', 0);
        }
    }

    public function shouldUpsellBeShown()
    {
        // Check to ensure that upsell is enabled for this store
        $store = Mage::app()->getStore();
        $store_code = $store->getCode();
        if (!Mage::helper('upsell')->isUpsellActiveForStore($store_code))
        {
            return false;
        }

        $upsell_condition = (! Mage::getSingleton('core/session')->getData('JUST_VISITED_UPSELL_PAGE')
            &&
            ! Mage::helper('customroute')->cartContainsHomeItems()
            &&
            ! Mage::getSingleton('core/session')->getScript()
            &&
            ! Mage::getSingleton('core/session')->getPreventUpsellPage()
            &&
            count(Mage::helper('upsell')->getUpsellProductsByCart())
            /*   &&
           ! Mage::getSingleton('core/session')->getSkipStraightToCheckoutOnCartAdd()
            */
        );
        return $upsell_condition;
    }
}

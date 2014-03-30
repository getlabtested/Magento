<?php

class Jag_Landingpage_Model_Observer
{
    /*
     * This method is intended to initalize all session data necessary to tailor the site experience for a user
     * Who comes to the site via a landing page
     */
    public function initializeLandingPageSession()
    {
        Mage::getSingleton('core/session')->setSkipStraightToCheckoutOnCartAdd(true);
    }
}

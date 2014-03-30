<?php

class PPMD_ImmuneTech_Model_Observer
{
    public function submitOrder($order)
    {
        // Currently we are not submitting any requests for ImmuneTech products
        // - Sean Dunagan 4/1/2013
        return true;
    }
}

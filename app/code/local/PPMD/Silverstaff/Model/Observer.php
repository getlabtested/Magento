<?php

class PPMD_Silverstaff_Model_Observer
{
    public function submitOrder($order)
    {
        // Currently we are not submitting any requests for Silverstaff products
        // - Sean Dunagan 3/30/2013
        return true;
    }
}

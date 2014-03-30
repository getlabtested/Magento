<?php

include 'app/Mage.php';
Mage::app('admin');

ini_set('memory_limit', '512M');

function addAddressData(&$address_ids_to_fetch, $city, $state)
{
    if (!isset($address_ids_to_fetch[$state]))
    {
        $address_ids_to_fetch[$state] = array();
    }

    if (!isset($address_ids_to_fetch[$state][$city]))
    {
        $address_ids_to_fetch[$state][$city] = 1;
    }
    else
    {
        $address_ids_to_fetch[$state][$city] = $address_ids_to_fetch[$state][$city] + 1;
    }
}

function writeDataToFile($filename, $address_ids_to_fetch)
{
    $output = fopen($filename, 'w+');

    foreach ($address_ids_to_fetch as $state => $city_array)
    {
        foreach ($city_array as $city_name => $city_count)
        {
            $output_array = array($state, $city_name, $city_count);
            fputcsv($output, $output_array);
        }
    }

    fclose($output);
}

$customers = Mage::getModel('customer/customer')
                ->getCollection()
                ->addAttributeToSelect('default_billing');

$address_ids_to_fetch = array();

foreach ($customers as $customer)
{
    $billing_address = $customer->getPrimaryBillingAddress();
	if(is_object($billing_address))
	{
    		$city = strtoupper($billing_address->getCity());
	    	$state = strtoupper($billing_address->getRegion());
	}

    addAddressData($address_ids_to_fetch, $city, $state);
}
writeDataToFile('city_orders.csv', $address_ids_to_fetch);




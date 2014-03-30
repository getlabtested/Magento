<?php
class Jag_Medivo_Model_Observer
{
    const UNALLOWED_LAB_STATES_CONFIG = 'medivo/lab_lookups/lab_specific/unallowed_states';
    const LAB_IDS_CONFIG = 'medivo/lab_lookups/lab_specific/lab_ids';

     public function orderSubmit(Varien_Event_Observer $observer)
    {
        Mage::Log('start medivo orderSubmit');

        $orderId = $observer->getEvent()->getOrderIds();
        if (is_array($orderId)) $orderId = $orderId[0];
        $order = Mage::getModel('sales/order')->load($orderId);

        $this->submitOrder($order);
        return $this;
    }

    public function submitOrder(Mage_Sales_Model_Order $order)
    {
        Mage::Log('start medivo submitOrder');
        if (Mage::helper('medivo')->isStateAllowed($order->getOrderState()) && ($order->getPpmdActivate() == 1) && ($order->getProductLine() != 2))
        {
            Mage::Log('creating order');
            $medivo = Mage::getModel('medivo/medivo');
            $medivo->createCustomer($order);
        }
        else
        {
            if ($order->getProductLine() != 2) {
                $eightArr[] = 'Chlamydia';
                $eightArr[] = 'Gonorrhea';
                $eightArr[] = 'Hepatitis B';
                $eightArr[] = 'Hepatitis C';
                $eightArr[] = 'Oral Herpes';
                $eightArr[] = 'Genital Herpes';
                $eightArr[] = 'HIV';
                $eightArr[] = 'Syphilis';

                $fourArr[] = 'Chlamydia';
                $fourArr[] = 'Genital Herpes';
                $fourArr[] = 'Gonorrhea';
                $fourArr[] = 'HIV';

                foreach ($order->getAllItems() as $item)
                {
                    if ($item->getProductId() == 14 || $item->getProductId() == 38)
                    {
                        foreach ($eightArr as $name)
                        {
                            $test = Mage::getModel('tests/tests');
                            $test->setOrderId($order->getId());
                            $test->setCustomerId($order->getCustomerId());
                            $test->setTestName($name);
                            $test->setResult(0);
                            $test->save();
                        }
                    }
                    else if ($item->getProductId() == 15 || $item->getProductId() == 37)
                    {
                        foreach ($fourArr as $name)
                        {
                            $test = Mage::getModel('tests/tests');
                            $test->setOrderId($order->getId());
                            $test->setCustomerId($order->getCustomerId());
                            $test->setTestName($name);
                            $test->setResult(0);
                            $test->save();
                        }
                    }
                    else
                    {
                        $test = Mage::getModel('tests/tests');
                        $test->setOrderId($order->getId());
                        $test->setCustomerId($order->getCustomerId());
                        $test->setTestName($item->getName());
                        $test->setResult(0);
                        $test->save();
                    }
                }
            }
        }
        return $this;
    }

    public function excludeAppropriateLabs($observer)
    {
        $transport_object = $observer->getTransportObject();
        $labs_array = $transport_object->getLabsArray();

        // Get all of the unallowed states for the various lab providers
        $unallowed_lab_states_array = Mage::getStoreConfig(self::UNALLOWED_LAB_STATES_CONFIG);
        $lab_ids_array = Mage::getStoreConfig(self::LAB_IDS_CONFIG);

        foreach ($unallowed_lab_states_array as $lab_name => $unallowed_states)
        {
            $lab_id = $lab_ids_array[$lab_name];
            $unallowed_states_array = array_keys($unallowed_states);
            $labs_array = Mage::helper('medivo/labs')->removeUnallowedLabStates($labs_array, $lab_id, $unallowed_states_array);
        }

        $transport_object->setLabsArray($labs_array);
        $observer->setTransportObject($transport_object);
    }

    public function convertProductsToNnrIfNeeded($observer)
    {
        // Check if the user is in an NNR state
        if (Mage::getSingleton('core/session')->getIsNnr())
        {
            Mage::helper('medivo')->convertCartProductsToNnr();
        }
    }
}

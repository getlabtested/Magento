<?php

class Jag_Medivo_Helper_Labs extends Mage_Core_Helper_Abstract
{
    const QUEST_LAB_TYPE_ID = 119;
    const LABCORP_LAB_TYPE_ID = 129;
    const UNALLOWED_NNR_SKUS_CONFIG = 'medivo/nnr_states/unallowed_skus';
    const QUEST_ONLY_STATES_CONFIG = 'medivo/lab_lookups/lab_specific/unallowed_states/labcorp';
    const LAB_LOOKUP_UNALLOWED_STATES_CONFIG = 'medivo/lab_lookups/unallowed_states';

    const CONTACT_PHONE_NUMBER_CONFIG_PATH = 'medivo/contact/phone_number';

    public function getSessionLabData()
    {
        $zipCode = Mage::getSingleton('core/session')->getZip();
        $session_selected_lab = Mage::getSingleton('core/session')->getLabId();

        if ($session_selected_lab && $zipCode)
        {
            if (Mage::getSingleton('core/session')->getIsNnr()) {

                // NNR lab locations do not allow certain tests to be ran
                // Check to see if any of these tests are in the cart
                $unallowed_items = $this->getNnrUnallowedItemsInCart();

                if (count($unallowed_items))
                {
                    $error_messsage = "The following tests are not allowed in ".Mage::helper('medivo')->getNnrStatesString(). ": ";
                    $error_messsage .= implode(", ", $unallowed_items);

                    Mage::getSingleton('core/session')->addError($error_messsage);

                    Mage::app()->getResponse()->setRedirect(Mage::getUrl('std-testing-options'));
                    Mage::app()->getResponse()->sendResponse();
                    exit;
                }

                $labs_array = Mage::getModel('medivo/medivo')->getDbLabsByZip($zipCode);
            } else {
                $labs_array = Mage::getModel('medivo/medivo')->getLabsByZip($zipCode);
            }

            // Ensure that the chosen lab is still compatible with the contents of the cart
            $selected_lab_is_compatible = false;
            foreach ($labs_array as $lab)
            {
                if ($session_selected_lab == $lab['id'])
                {
                    $selected_lab_is_compatible = true;
                    break;
                }
            }

            if (!$selected_lab_is_compatible)
            {
                $session_selected_lab = '';
            }

            return array('selected_lab_id' => $session_selected_lab, 'labs_by_zip' => $labs_array);
        }

        $labs_array = (array)Mage::getSingleton('core/session')->getLabsByZip();
        return array('selected_lab_id' => '', 'labs_by_zip' => $labs_array);
    }

    public function isNotAllowedLabLookupState($state)
    {
        $not_allowed_lab_lookup_states = $this->getNotAllowedLabLookupStates();
        return in_array($state, $not_allowed_lab_lookup_states);
    }

    public function getNotAllowedLabLookupStates()
    {
        $not_allowed_lab_lookup_states_array = Mage::getStoreConfig(self::LAB_LOOKUP_UNALLOWED_STATES_CONFIG);
        if (!is_array($not_allowed_lab_lookup_states_array)){
            return array();
        }
        $not_allowed_lab_lookup_states = array_keys($not_allowed_lab_lookup_states_array);
        return $not_allowed_lab_lookup_states;
    }

    public function getNnrUnallowedItemsInCart()
    {
        $unallowed_NNR_items = array_keys(Mage::getStoreConfig(self::UNALLOWED_NNR_SKUS_CONFIG));
        $unallowed_items = Mage::helper('medivo')->cartContainsItems($unallowed_NNR_items);
        return $unallowed_items;
    }

    public function getNnrUnallowedItemsInPostArray($post_array)
    {
        $unallowed_NNR_items = array_keys(Mage::getStoreConfig(self::UNALLOWED_NNR_SKUS_CONFIG));
        $unallowed_items = Mage::helper('medivo')->postContainsSkus($post_array, $unallowed_NNR_items);
        return $unallowed_items;
    }

    public function keepOnlyCertainLabType($labs_array, $lab_id_to_keep)
    {
        foreach ($labs_array as $index => $lab)
        {
            if ($lab_id_to_keep != $lab['lab-id'])
            {
                unset($labs_array[$index]);
            }
        }

        return $labs_array;
    }

    public function removeLabsInStates($labs_array, $states_to_remove)
    {
        foreach ($labs_array as $index => $lab)
        {
            if (in_array($lab['state'], $states_to_remove))
            {
                unset($labs_array[$index]);
            }
        }

        return $labs_array;
    }

    public function removeUnallowedLabStates($labs_array, $lab_id, $states_to_remove)
    {
        foreach ($labs_array as $index => $lab)
        {
            if (in_array($lab['state'], $states_to_remove) && ($lab_id == $lab['lab-id']))
            {
                unset($labs_array[$index]);
            }
        }

        return $labs_array;
    }

    public function removeCertainLabType($labs_array, $lab_id_to_remove)
    {
        foreach ($labs_array as $index => $lab)
        {
            if ($lab_id_to_remove == $lab['lab-id'])
            {
                unset($labs_array[$index]);
            }
        }

        return $labs_array;
    }

    public function getQuestLabId()
    {
        return self::QUEST_LAB_TYPE_ID;
    }

    public function getLabcorpLabId()
    {
        return self::LABCORP_LAB_TYPE_ID;
    }

    public function getLabRulesMessage()
    {
        $message = "<ul>";
        // Nnr no longer supported by site
        //$message .= "<li>The following tests are not allowed in ".Mage::helper('medivo')->getNnrStatesString().": ".implode(", ", array_keys(Mage::getStoreConfig(self::UNALLOWED_NNR_SKUS_CONFIG)))."</li>";
        $lab_corp_only_skus = Mage::helper('medivo')->getLabCorpOnlySkus();
        $message .= "<li>The following tests are not available in ".implode(", ", array_keys(Mage::getStoreConfig(self::QUEST_ONLY_STATES_CONFIG))).": ".implode(", ", $lab_corp_only_skus)."</li>";
        $message .= "<li>Testing is unavailable in the following states: ".Mage::helper('medivo')->getUnallowedStatesString()."</li>";
        $message .= "</ul>";

        return $message;
    }

    public function getContactPhoneNumber()
    {
        return Mage::getStoreConfig(self::CONTACT_PHONE_NUMBER_CONFIG_PATH);
    }

    public function getNotAllowedLabLookupStateMessaging()
    {
        $not_allowed_lab_lookup_states = $this->getNotAllowedLabLookupStates();
        $glue_string = (count($not_allowed_lab_lookup_states) == 2) ? ' and ' : ',';
        $states_string = implode($glue_string, $not_allowed_lab_lookup_states);
        return "We' re sorry - State law prohibits us from selling Direct Access Testing in $states_string.";
    }
}

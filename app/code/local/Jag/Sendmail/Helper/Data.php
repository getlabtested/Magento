<?php

/**
 * Jag_Sendmail extension
 */

/**
 * @category   Jag
 * @package    Jag_Sendmail
 */
class Jag_Sendmail_Helper_Data extends Mage_Core_Helper_Data {

    const EMAIL_TEMPLATES_CONFIG_PATH = 'jag_sendmail/templates';
    const NON_INSTRUCTIONS_EMAIL_STORES = 'jag_sendmail/no_email_instructions_file_stores';

    protected $_locations = array();

    public function getTemplates() {

        $variable = Mage::getModel('core/variable')->loadByCode('select_template')->getValue('plain');
        $returnArray = array();
        if ($variable != '') {
            $tempArray = explode(",", $variable);
            $k = 0;
            foreach ($tempArray as $i => $v) {
                $mailTemplate = Mage::getModel('core/email_template')->load($v);
                if ($mailTemplate->getTemplateId()) {
                    $returnArray[$k] = array('id' => $mailTemplate->getTemplateId(), 'name' => $mailTemplate->getData('template_code'));
                    $k++;
                }
            }
        }

        return $returnArray;
    }
    
    public function getFormAction(){
        return Mage::getUrl('sendmail/index/send/');
    }

    public function getEmailTemplateByStoreId($email_type, $store_id)
    {
        $store = Mage::getModel('core/store')->load($store_id);
        $store_code = $store->getCode();

        $email_config_path_base = self::EMAIL_TEMPLATES_CONFIG_PATH . "/" . $email_type;
        $store_specific_email_config_path = $email_config_path_base . "/" . $store_code;

        if ($store_specific_email_template = Mage::getStoreConfig($store_specific_email_config_path))
        {
            return $store_specific_email_template;
        }

        $default_email_config_path = $email_config_path_base . "/default";
        return Mage::getStoreConfig($default_email_config_path);
    }

    public function isNonInstructionsEmailStore($store_id)
    {
        $store = Mage::getModel('core/store')->load($store_id);
        $store_code = $store->getCode();

        $non_instruction_email_stores = Mage::getStoreConfig(self::NON_INSTRUCTIONS_EMAIL_STORES);
        if (!is_array($non_instruction_email_stores))
        {
            return false;
        }

        return in_array($store_code, array_keys($non_instruction_email_stores));
    }
}

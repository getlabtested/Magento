<?php

class Jag_Medivo_Helper_Docconsult extends Mage_Core_Helper_Abstract
{
    const DOC_CONSULT_SKUS_CONFIG = 'medivo_settings/contact_information/doc_consult_skus';
    const DOC_CONSULT_CONTACT_PHONE_CONFIG = 'medivo_settings/contact_information/doc_consult_phone_number';

    public function sendDocConsultEmailIfNecessary($order, $customer)
    {
        // Doctor Consultation
        // Check to see if a doctor consultation product was included in the order
        $doc_consult_skus = $this->getDocConsultSkus();
        $order_products = $order->getItemsCollection();

        $doc_consult_was_ordered = false;
        foreach ($order_products as $product)
        {
            if (in_array($product->getSku(), $doc_consult_skus))
            {
                $doc_consult_was_ordered = true;
                break;
            }
        }

        if ($doc_consult_was_ordered)
        {
            $doc_consult_template = Mage::getModel('core/email_template');
            $doc_consult_template->getMail()->setSubject('PPMD Doctor Consultation Information');

            $doc_consult_phone_number = $this->getDocConsultPhoneNumber();
            $doc_consult_template->sendTransactional('ppmd_doctor_consult_info','general',$customer->getEmail(),$customer->getFirstname().' '.$customer->getLastname(),array('order'=>$order,'customer'=>$customer,'doc_consult_phone_number' => $doc_consult_phone_number));
        }
    }

    public function getDocConsultPhoneNumber()
    {
        return Mage::getStoreConfig(self::DOC_CONSULT_CONTACT_PHONE_CONFIG);
    }

    public function getDocConsultSkus()
    {
        $doc_consult_skus_string = Mage::getStoreConfig(self::DOC_CONSULT_SKUS_CONFIG);
        $doc_consult_skus_array = explode("|", $doc_consult_skus_string);

        if (!is_array($doc_consult_skus_array))
        {
            return array();
        }

        return $doc_consult_skus_array;
    }
}

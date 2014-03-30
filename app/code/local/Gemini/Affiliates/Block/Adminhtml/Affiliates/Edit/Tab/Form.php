<?php



class Gemini_Affiliates_Block_Adminhtml_Affiliates_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form

{

  protected function _prepareForm()

  {

      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('affiliates_form', array('legend'=>Mage::helper('affiliates')->__('Affiliate information')));

      $fieldset->addField('affiliate_id', 'text', array(
          'label'     => Mage::helper('affiliates')->__('Affiliate ID'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'affiliate_id',
      ));

      $fieldset->addField('username', 'text', array(
          'label'     => Mage::helper('affiliates')->__('Username (Must be valid Email)'),
          'class'     => 'required-entry validate-email',
          'required'  => true,
          'name'      => 'username',
      ));

      $fieldset->addField('first_name', 'text', array(
          'label'     => Mage::helper('affiliates')->__('First Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'first_name',

      ));

      $fieldset->addField('last_name', 'text', array(
          'label'     => Mage::helper('affiliates')->__('Last Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'last_name',
      ));
	  
	  $fieldset->addField('phone', 'text', array(
          'label'     => Mage::helper('affiliates')->__('Phone'),
          'required'  => true,
          'name'      => 'phone',
      ));

      $fieldset->addField('callcenter', 'select', array(
          'name'  	=> 'callcenter',
          'label' 	=> Mage::helper('adminhtml')->__('Is Callcenter Affiliate Choice'),
          'id'    	=> 'callcenter',
          'class' 	=> 'input-select',
          'options'	=> array('1' => Mage::helper('adminhtml')->__('Yes'), '0' => Mage::helper('adminhtml')->__('No')),
      ));

      $affiliate_store_choices = Mage::helper('ppmd_credentials/pap')->getStoresWithCredentials();

      $fieldset->addField('store_code', 'select', array(
          'name'  	=> 'store_code',
          'label' 	=> Mage::helper('adminhtml')->__('Affiliate Store'),
          'id'    	=> 'store_code',
          'class' 	=> 'input-select',
          'options'	=> $affiliate_store_choices,
      ));
      
      if ( Mage::getSingleton('adminhtml/session')->getAffiliatesData() ) {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getAffiliatesData());
          Mage::getSingleton('adminhtml/session')->setaffiliatesData(null);

      } elseif ( Mage::registry('affiliates_data') ) {
          $form->setValues(Mage::registry('affiliates_data')->getData());

      }

      return parent::_prepareForm();

  }

}
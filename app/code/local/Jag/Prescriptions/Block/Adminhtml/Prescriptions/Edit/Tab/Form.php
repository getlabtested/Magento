<?php

class Jag_Prescriptions_Block_Adminhtml_Prescriptions_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('prescriptions_form', array('legend'=>Mage::helper('prescriptions')->__('Item information')));
     
      $fieldset->addField('order_id', 'text', array(
          'label'     => Mage::helper('prescriptions')->__('Order ID'),
          'required'  => false,
          'disabled'  => "disabled",
          'name'      => 'order_id',
      ));
      
       $fieldset->addField('update_time', 'text', array(
          'label'     => Mage::helper('prescriptions')->__('Called In'),
          'required'  => false,
          'disabled'  => "disabled",
          'name'      => 'update_time',
      ));
      
       $fieldset->addField('prescription_name', 'text', array(
          'label'     => Mage::helper('prescriptions')->__('Prescription Name'),
          'required'  => false,
          'disabled'  => "disabled",
          'name'      => 'prescription_name',
      ));
      
      
      
      $fieldset->addField('dob', 'text', array(
          'label'     => Mage::helper('prescriptions')->__('DOB'),
          'required'  => false,
          'disabled'  => "disabled",
          'name'      => 'dob',
      ));
	  
	   $fieldset->addField('customer_id', 'text', array(
          'label'     => Mage::helper('prescriptions')->__('Customer ID'),
          'required'  => false,
          'disabled'  => "disabled",
          'name'      => 'customer_id',
      ));
      
      $fieldset->addField('customer_name', 'text', array(
          'label'     => Mage::helper('prescriptions')->__('Customer Name'),
          'class'     => '',
          'disabled'  => 'disabled',
          'required'  => false,
          'name'      => 'customer_name',
      ));
	  
	  $fieldset->addField('customer_phone', 'text', array(
          'label'     => Mage::helper('prescriptions')->__('Customer Phone'),
          'class'     => '',
          'disabled'  => 'disabled',
          'required'  => false,
          'name'      => 'customer_phone',
      ));
	  
	  $fieldset->addField('pharmacy_phone', 'text', array(
          'label'     => Mage::helper('prescriptions')->__('Pharmacy Phone'),
          'class'     => '',
          'disabled'  => 'disabled',
          'required'  => false,
          'name'      => 'pharmacy_phone',
      ));
	  
	  $fieldset->addField('scripts', 'text', array(
          'label'     => Mage::helper('prescriptions')->__('Prescriptions Needed'),
          'class'     => '',
          'disabled'  => 'disabled',
          'required'  => false,
          'name'      => 'scripts',
      ));
	  
	  $fieldset->addField('allergies', 'text', array(
          'label'     => Mage::helper('prescriptions')->__('Allergies'),
          'class'     => '',
          'disabled'  => 'disabled',
          'required'  => false,
          'name'      => 'allergies',
      ));
	  
	  $fieldset->addField('cur_meds', 'text', array(
          'label'     => Mage::helper('prescriptions')->__('Current Medications'),
          'class'     => '',
          'disabled'  => 'disabled',
          'required'  => false,
          'name'      => 'cur_meds',
      ));
	  
	  $fieldset->addField('cur_otc_meds', 'text', array(
          'label'     => Mage::helper('prescriptions')->__('Current OTC Medications'),
          'class'     => '',
          'disabled'  => 'disabled',
          'required'  => false,
          'name'      => 'cur_otc_meds',
      ));
	  
	   $fieldset->addField('med_history', 'editor', array(
          'name'      => 'med_history',
          'label'     => Mage::helper('prescriptions')->__('Medical History'),
          'title'     => Mage::helper('prescriptions')->__('Medical History'),
          'style'     => 'width:350px; height:250px;',
          'wysiwyg'   => false,
          'required'  => false,
      ));
	  
	  
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('prescriptions')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 0,
                  'label'     => Mage::helper('prescriptions')->__('Pending'),
              ),

              array(
                  'value'     => 1,
                  'label'     => Mage::helper('prescriptions')->__('Complete'),
              ),
          ),
      ));
	  
	  $fieldset->addField('drugs', 'text', array(
          'label'     => Mage::helper('prescriptions')->__('Drugs Prescribed'),
          'class'     => '',
          'required'  => true,
          'name'      => 'drugs',
      ));
     
      $fieldset->addField('notes', 'editor', array(
          'name'      => 'notes',
          'label'     => Mage::helper('prescriptions')->__('Notes'),
          'title'     => Mage::helper('prescriptions')->__('Notes'),
          'style'     => 'width:350px; height:250px;',
          'wysiwyg'   => false,
          'required'  => false,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getPrescriptionsData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getPrescriptionsData());
          Mage::getSingleton('adminhtml/session')->setPrescriptionsData(null);
      } elseif ( Mage::registry('prescriptions_data') ) {
          $form->setValues(Mage::registry('prescriptions_data')->getData());
      }
      return parent::_prepareForm();
  }
}
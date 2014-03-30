<?php

class Jag_Tests_Block_Adminhtml_Tests_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('tests_form', array('legend'=>Mage::helper('tests')->__('Item information')));
     
      $fieldset->addField('tests_id', 'text', array(
          'label'     => Mage::helper('tests')->__('Test ID'),
          'required'  => true,
          'disabled'  => 'disabled',
          'name'      => 'tests_id',
      ));
	  
	  $fieldset->addField('order_id', 'text', array(
          'label'     => Mage::helper('tests')->__('Order ID'),
          'required'  => true,
          'disabled'  => 'disabled',
          'name'      => 'order_id',
      ));
	  
	  $fieldset->addField('customer_id', 'text', array(
          'label'     => Mage::helper('tests')->__('Customer ID'),
          'required'  => true,
          'disabled'  => 'disabled',
          'name'      => 'customer_id',
      ));

      $fieldset->addField('test_name', 'text', array(
          'label'     => Mage::helper('tests')->__('Test Name'),
          'required'  => false,
          'disabled'  => 'disabled',
          'name'      => 'test_name',
	  ));
		
      $fieldset->addField('result', 'select', array(
          'label'     => Mage::helper('tests')->__('Result'),
          'name'      => 'result',
          'values'    => array(
              array(
                  'value'     => 9,
                  'label'     => Mage::helper('tests')->__('Pending'),
              ),

              array(
                  'value'     => 1,
                  'label'     => Mage::helper('tests')->__('Positive'),
              ),
              array(
                  'value'     => 2,
                  'label'     => Mage::helper('tests')->__('Negative'),
              ),
              array(
                  'value'     => 3,
                  'label'     => Mage::helper('tests')->__('Inconclusive'),
              ),
          ),
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getTestsData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getTestsData());
          Mage::getSingleton('adminhtml/session')->setTestsData(null);
      } elseif ( Mage::registry('tests_data') ) {
          $form->setValues(Mage::registry('tests_data')->getData());
      }
      return parent::_prepareForm();
  }
}
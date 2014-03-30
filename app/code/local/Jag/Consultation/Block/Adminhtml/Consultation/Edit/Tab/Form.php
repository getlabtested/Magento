<?php

class Jag_Consultation_Block_Adminhtml_Consultation_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('consultation_form', array('legend'=>Mage::helper('consultation')->__('Item information')));
     
      $fieldset->addField('customer_id', 'text', array(
          'label'     => Mage::helper('consultation')->__('Customer ID'),
          'class'     => '',
          'required'  => false,
          'disabled'  => 'disabled',
          'name'      => 'customer_id',
      ));
      
      $fieldset->addField('phone', 'text', array(
          'label'     => Mage::helper('consultation')->__('Phone'),
          'class'     => '',
          'required'  => false,
          'disabled'  => 'disabled',
          'name'      => 'phone',
      ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('consultation')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 0,
                  'label'     => Mage::helper('consultation')->__('Pending'),
              ),

              array(
                  'value'     => 1,
                  'label'     => Mage::helper('consultation')->__('Complete'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('consultation')->__('Content'),
          'title'     => Mage::helper('consultation')->__('Content'),
          'style'     => 'width:400px; height:200px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getConsultationData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getConsultationData());
          Mage::getSingleton('adminhtml/session')->setConsultationData(null);
      } elseif ( Mage::registry('consultation_data') ) {
          $form->setValues(Mage::registry('consultation_data')->getData());
      }
      return parent::_prepareForm();
  }
}
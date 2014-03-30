<?php

class Jag_Reporting_Block_Adminhtml_Reporting_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('reporting_form', array('legend'=>Mage::helper('reporting')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('reporting')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('reporting')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('reporting')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('reporting')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('reporting')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('reporting')->__('Content'),
          'title'     => Mage::helper('reporting')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getReportingData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getReportingData());
          Mage::getSingleton('adminhtml/session')->setReportingData(null);
      } elseif ( Mage::registry('reporting_data') ) {
          $form->setValues(Mage::registry('reporting_data')->getData());
      }
      return parent::_prepareForm();
  }
}
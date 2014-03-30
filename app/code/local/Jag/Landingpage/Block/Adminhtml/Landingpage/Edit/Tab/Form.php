<?php

class Jag_Landingpage_Block_Adminhtml_Landingpage_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('landingpage_form', array('legend'=>Mage::helper('landingpage')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('landingpage')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('landingpage')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('landingpage')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('landingpage')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('landingpage')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('landingpage')->__('Content'),
          'title'     => Mage::helper('landingpage')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getLandingpageData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getLandingpageData());
          Mage::getSingleton('adminhtml/session')->setLandingpageData(null);
      } elseif ( Mage::registry('landingpage_data') ) {
          $form->setValues(Mage::registry('landingpage_data')->getData());
      }
      return parent::_prepareForm();
  }
}
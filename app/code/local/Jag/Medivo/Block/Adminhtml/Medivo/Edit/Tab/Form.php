<?php

class Jag_Medivo_Block_Adminhtml_Medivo_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('medivo_form', array('legend'=>Mage::helper('medivo')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('medivo')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('medivo')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('medivo')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('medivo')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('medivo')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('medivo')->__('Content'),
          'title'     => Mage::helper('medivo')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getMedivoData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getMedivoData());
          Mage::getSingleton('adminhtml/session')->setMedivoData(null);
      } elseif ( Mage::registry('medivo_data') ) {
          $form->setValues(Mage::registry('medivo_data')->getData());
      }
      return parent::_prepareForm();
  }
}
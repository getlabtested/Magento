<?php

class Jag_Template_Block_Adminhtml_Template_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('template_form', array('legend'=>Mage::helper('template')->__('Template information')));
     
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('template')->__('Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      ));
      
      $fieldset->addField('path', 'text', array(
          'label'     => Mage::helper('template')->__('Path'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'path',
      ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('template')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('template')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('template')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('fields', 'editor', array(
          'name'      => 'fields',
          'label'     => Mage::helper('template')->__('Fields'),
          'title'     => Mage::helper('template')->__('Fields'),
          'style'     => 'width:300x; height:200px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getTemplateData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getTemplateData());
          Mage::getSingleton('adminhtml/session')->setTemplateData(null);
      } elseif ( Mage::registry('template_data') ) {
          $form->setValues(Mage::registry('template_data')->getData());
      }
      return parent::_prepareForm();
  }
}
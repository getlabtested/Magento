<?php

class Jag_Callcenter_Block_Adminhtml_Callcenter_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('callcenter_form', array('legend'=>Mage::helper('callcenter')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('callcenter')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

	$fieldset->addField('chlamydia', 'checkbox', array(
          'label'     => Mage::helper('callcenter')->__('Title'),
          'name'      => 'testIds[]',
	  'value'     => 21,
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('callcenter')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('callcenter')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('callcenter')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('callcenter')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('callcenter')->__('Content'),
          'title'     => Mage::helper('callcenter')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getCallcenterData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getCallcenterData());
          Mage::getSingleton('adminhtml/session')->setCallcenterData(null);
      } elseif ( Mage::registry('callcenter_data') ) {
          $form->setValues(Mage::registry('callcenter_data')->getData());
      }
      return parent::_prepareForm();
  }
}

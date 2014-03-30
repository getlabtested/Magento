<?php

class Jag_Userdashboard_Block_Adminhtml_Userdashboard_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('userdashboard_form', array('legend'=>Mage::helper('userdashboard')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('userdashboard')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('userdashboard')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('userdashboard')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('userdashboard')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('userdashboard')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('userdashboard')->__('Content'),
          'title'     => Mage::helper('userdashboard')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getUserdashboardData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getUserdashboardData());
          Mage::getSingleton('adminhtml/session')->setUserdashboardData(null);
      } elseif ( Mage::registry('userdashboard_data') ) {
          $form->setValues(Mage::registry('userdashboard_data')->getData());
      }
      return parent::_prepareForm();
  }
}
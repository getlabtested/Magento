<?php

class Jag_Localepage_Block_Adminhtml_Localepage_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('localepage_form', array('legend'=>Mage::helper('localepage')->__('Page information')));
            
     
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('localepage')->__('Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      ));
      
       $fieldset->addField('url_key', 'text', array(
          'label'     => Mage::helper('localepage')->__('Url Key'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'url_key',
      ));
      
           $fieldset->addField('meta_keywords', 'editor', array(
          'name'      => 'meta_keywords',
          'label'     => Mage::helper('localepage')->__('meta_keywords'),
          'title'     => Mage::helper('localepage')->__('meta_keywords'),
          'style'     => 'width:300px; height:100px;',
          'wysiwyg'   => false,
          'required'  => false,
      ));
      
     $fieldset->addField('meta_description', 'editor', array(
          'name'      => 'meta_description',
          'label'     => Mage::helper('localepage')->__('meta_description'),
          'title'     => Mage::helper('localepage')->__('meta_description'),
          'style'     => 'width:300px; height:100px;',
          'wysiwyg'   => false,
          'required'  => false,
      ));
      
     /*
 $fieldset->addField('values', 'editor', array(
          'name'      => 'values',
          'label'     => Mage::helper('localepage')->__('values'),
          'title'     => Mage::helper('localepage')->__('values'),
          'style'     => 'width:300px; height:100px;',
          'wysiwyg'   => false,
          'required'  => false,
      ));
*/



		$templateModel = Mage::getModel('template/template');
		
		$templates = $templateModel->getCollection()->getAllIds();
				
		foreach ($templates as $k=>$tid) {
		
			$values[] = array('value'=>$tid,'label'=>$templateModel->load($tid)->getName());
		
		
		}
      
       $fieldset->addField('template_id', 'select', array(
          'label'     => Mage::helper('localepage')->__('Template ID'),
          'name'      => 'template_id',

          'values' => $values,    
      ));
                              
      if ($templateId = Mage::getModel('localepage/localepage')->load($this->getRequest()->getParam('id'))->getTemplateId()) {
            
     	 $template = Mage::getModel('template/template')->load($templateId);
     	       
      	 $fields = $template->getFields();
      	       	 
      	 $fieldArr = explode(",",$fields);
      	 
      	 foreach ($fieldArr as $k=>$fieldName){
      	 
      	 	if (strstr($fieldName,'_content')) {
      	 	
      	 	
      	 	$fieldset->addField($fieldName, 'editor', array(
          'name'      => 'fv['.$fieldName.']',
          //'name' 	  => $fieldName,
          'label'     => Mage::helper('localepage')->__('Content'),
          'title'     => Mage::helper('localepage')->__('Content'),
          'style'     => 'width:300px; height:100px;',
          'wysiwyg'   => true,
          'required'  => false,
          'config' 	  => Mage::getSingleton('cms/wysiwyg_config')->getConfig()
         	));
      	 	
      	 	} else if(strstr($fieldName,'_img')){
      	 	
			
			$fieldset->addField($fieldName, 'file', array(
          	'label'     => Mage::helper('localepage')->__($fieldName),
         	'required'  => false,
          	'name'      => $fieldName,
	  		));
			      	 	
      	 	
      	 	} else {
      	 	
      	 		$fieldset->addField($fieldName, 'text', array(
          		'label'     => Mage::helper('localepage')->__($fieldName),
          		'class'     => '',
          		'required'  => false,
          		'name'      => 'fv['.$fieldName.']',
     			 ));
      	 	
      	 	}
      	 
      	 }
      	 
      
      }
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('localepage')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('localepage')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('localepage')->__('Disabled'),
              ),
          ),
      ));
     
      /*
$fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('localepage')->__('Content'),
          'title'     => Mage::helper('localepage')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
*/
     
      if ( Mage::getSingleton('adminhtml/session')->getLocalepageData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getLocalepageData());
          Mage::getSingleton('adminhtml/session')->setLocalepageData(null);
      } elseif ( Mage::registry('localepage_data') ) {
          $form->setValues(Mage::registry('localepage_data')->getData());
      }
      return parent::_prepareForm();
  }
}
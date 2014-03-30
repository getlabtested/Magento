<?php

class PPMD_Testrecommender_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        Mage::log('Calling PPMD_Testrecommender indexAction controller');

        $this->loadLayout();
        $this->renderLayout();
    }

    public function postAction() {
        Mage::log('Calling PPMD_Testrecommender postAction controller');
        
		$gender = $this->getRequest()->getParam('Gender');
        $age = $this->getRequest()->getParam('Age');
        $zipcode = $this->getRequest()->getParam('Zipcode');
        $sexualpartner = $this->getRequest()->getParam('SexualPartner');
        $laststdtest = $this->getRequest()->getParam('LastSTDTest');
        $oneormoresexualpartner = $this->getRequest()->getParam('OneOrMoreSexualPartner');
        $concernedwithother = $this->getRequest()->getParam('ConcernedWithOther');
        $vaccinatedforhepatitisb = $this->getRequest()->getParam('VaccinatedForHepatitisB');
        $relationshipwithivdrug = $this->getRequest()->getParam('RelationshipWithIVdrug');
        $interestedwithgenitalherpes = $this->getRequest()->getParam('InterestedWithGenitalHerpes');
        $chkIndi1 = $this->getRequest()->getParam('chkIndi1');
        
        //echo "<pre>"; print_r($this->getRequest()->getParams()); exit();
        
        Mage::register('gender', $gender);
        Mage::register('age', $age);
        Mage::register('zipcode', $zipcode);
        Mage::register('sexualpartner', $sexualpartner);
        Mage::register('laststdtest', $laststdtest);
        Mage::register('oneormoresexualpartner', $oneormoresexualpartner);
        Mage::register('concernedwithother', $concernedwithother);
        Mage::register('vaccinatedforhepatitisb', $vaccinatedforhepatitisb);
        Mage::register('relationshipwithivdrug', $relationshipwithivdrug);
        Mage::register('interestedwithgenitalherpes', $interestedwithgenitalherpes);        
        Mage::register('chkIndi1', $chkIndi1);
        
        $this->loadLayout();
        $this->renderLayout();
    }
}
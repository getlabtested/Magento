<?php
class Jag_Landingpage_FiveController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    				
		$this->loadLayout();     
		$this->renderLayout();
    }
}
<?php
class Jag_Userdashboard_Model_Observer
{
    public function __construct()
    {
    }
	
	public function userdash() {
		
		Mage::app()->getFrontController()->redirect('my-resuts');
		
	}
	
}
?>
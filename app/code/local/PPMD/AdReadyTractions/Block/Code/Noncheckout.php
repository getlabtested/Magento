<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sean
 * Date: 4/14/14
 * Time: 5:24 PM
 * To change this template use File | Settings | File Templates.
 */
class PPMD_AdReadyTractions_Block_Code_Noncheckout extends Mage_Core_Block_Template
{
    const RETARGETING_CODE = "<script src='//www.adreadytractions.com/rt/183131?p=23591'></script>";
    const SUCCESS_PAGE_FULL_ACTION_NAME = 'checkout_onepage_success';

    public function _toHtml()
    {
        $full_action_name = $this->getFullActionName();

        if (strcmp($full_action_name, self::SUCCESS_PAGE_FULL_ACTION_NAME))
        {
            return self::RETARGETING_CODE;
        }
        return '';
    }

    public function getFullActionName($delimiter='_')
    {
        return $this->getRequest()->getRequestedRouteName().$delimiter.
                $this->getRequest()->getRequestedControllerName().$delimiter.
                $this->getRequest()->getRequestedActionName();
    }
}

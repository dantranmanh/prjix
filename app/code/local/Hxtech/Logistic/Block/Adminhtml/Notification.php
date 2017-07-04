<?php

class Hxtech_Logistic_Block_Adminhtml_Notification extends Mage_Adminhtml_Block_Template
{
    /**
     * Initialize block window
     *
     */
    protected function _construct()
    {
        parent::_construct();

        $this->setHeaderText($this->escapeHtml($this->__('Incoming Message')));
        $this->setCloseText($this->escapeHtml($this->__('close')));
       
        $this->setNoticeMessageText($this->escapeHtml('Terms & Conditions'));

        $this->setNoticeSeverity('SEVERITY_MAJOR');
    }

    /**
     * Can we show notification window
     *
     * @return bool
     */
    public function canShow()
    {
        if (!Mage::getSingleton('admin/session')->isFirstPageAfterLogin()) {
            return false;
        } 

        if(!Mage::helper('logistic/logistic')->isLogisticUser() && !Mage::helper('document')->isDocumentSupplierUser()){
            return false;
        }

        $currentAdminUser = Mage::getSingleton('admin/session')->getUser();
        if($currentAdminUser->getTermStatus() == 1){
            return false; 
        }

        return true;
    }
}

<?php

class MDN_Quotation_Helper_Data extends Mage_Core_Helper_Abstract {

    public function log($msg)
    {
        Mage::log($msg, null, 'quote.log');
    }

    /**
     * Return an array with all status
     *
     */
    public function getStatusesAsArray() {
        $retour = array();
        $retour[MDN_Quotation_Model_Quotation::STATUS_NEW] = Mage::helper('quotation')->__('New');
        $retour[MDN_Quotation_Model_Quotation::STATUS_ACTIVE] = Mage::helper('quotation')->__('Active');
        $retour[MDN_Quotation_Model_Quotation::STATUS_CUSTOMER_REQUEST] = Mage::helper('quotation')->__('Customer request');
        $retour[MDN_Quotation_Model_Quotation::STATUS_EXPIRED] = Mage::helper('quotation')->__('Expired');
        return $retour;
    }

    public function translateStatus($statusCode)
    {
        foreach($this->getStatusesAsArray() as $k => $v)
        {
            if ($statusCode == $k)
                return $v;
        }
        return $statusCode;
    }

    public function translateCommercialStatus($statusCode)
    {
        foreach(Mage::getSingleton('Quotation/Quotation')->getBoughtStatusValues() as $k => $v)
        {
            if ($statusCode == $k)
                return $v;
        }
        return $statusCode;
    }

    /**
     * Return an array with users
     *
     */
    public function getUsers() {
        $retour = array();

        $collection = Mage::getModel('admin/user')->getCollection()->setOrder('username');
        foreach ($collection as $item) {
            $retour[$item->getusername()] = $item->getusername();
        }

        return $retour;
    }

    /**
     * Return true if current customer can request a quote
     */
    public function currentCustomerCanRequestQuote()
    {
        //get current customer group
        $currentCustomer = Mage::getSingleton('customer/session')->getCustomer();
        $groupId = $currentCustomer->getgroup_id();

        //check group
        $allowedGroups = Mage::getStoreConfig('quotation/quotation_request/allowed_customer_groups');
        $t = explode(',', $allowedGroups);
        return (in_array($groupId, $t));
    }

}

?>
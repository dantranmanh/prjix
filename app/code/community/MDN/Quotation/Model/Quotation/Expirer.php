<?php

class MDN_Quotation_Model_Quotation_Expirer extends Mage_Core_Model_Abstract
{

    /**
     * Toggle quotes status to expired
     */
    public function process()
    {
        //get active, not bought, not reminded quotes
        $collection = Mage::getModel('Quotation/Quotation')
            ->getCollection()
            ->addFieldToFilter('valid_end_time', array('lt' => date('Y-m-d')))
            ->addFieldToFilter('status', MDN_Quotation_Model_Quotation::STATUS_ACTIVE);

        Mage::helper('quotation')->log($collection->getSize().' quotes to set to expired');

        foreach($collection as $quote)
        {
            Mage::helper('quotation')->log('Set quote #'.$quote->getIncrementId().' to expired');
            $quote->checkExpirationDateAndApply();
        }

    }

}
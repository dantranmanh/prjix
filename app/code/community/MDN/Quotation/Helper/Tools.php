<?php

class MDN_quotation_Helper_Tools extends Mage_Core_Helper_Abstract {

    /**
     * Delete every bundle products associated to quote, created there is more that 2 weeks ago
     */
    public function cleanBundles()
    {
        $maxDays = 15;
        $maxDate = date('Y-m-d', time() - 3600 * 24 * maxDays);

        $collection = Mage::getModel('catalog/product')
                            ->getCollection()
                            ->addAttributeToSelect('quotation_id')
                            ->addAttributeToFilter('is_quotation', 1)
                            ->addFieldToFilter('created_at', array('lt' => $maxDate));

        Mage::helper('quotation')->log($collection->getSize().' products to delete');

        foreach($collection as $product)
        {
            $quoteId = $product->getquotation_id();
            Mage::helper('quotation')->log('Delete sku #'.$product->getSku().' for quote #'.$quoteId);

            $quote = Mage::getModel('Quotation/Quotation')->load($quoteId);
            if (!$quote->getIncrementId())
                $product->delete(); //unable to find asociated quote, delete product
            else
            {
                Mage::getSingleton('Quotation/Quotation_Bundle')->deleteBundle($quote); //delete product using quote
            }
        }
    }

}
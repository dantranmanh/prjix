<?php

class Hxtech_Document_Model_Total_Documentation_Invoice extends Mage_Sales_Model_Order_Invoice_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Invoice $invoice)
    {
        $amount = Mage::helper('document/documentation')->getDocumentFeeByInvoice($invoice);
        if ($amount) {
            $invoice->setGrandTotal($invoice->getGrandTotal() + $amount);
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $amount);
        }
 
        return $this;
    }
}
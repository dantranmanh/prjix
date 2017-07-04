<?php

class Hxtech_Logistic_Model_Total_Importer_Invoice extends Mage_Sales_Model_Order_Invoice_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Invoice $invoice)
    {
    	$order = $invoice->getOrder();
        $amount = $order->getImporterCommissionFee();
        if ($amount) {
            $invoice->setGrandTotal($invoice->getGrandTotal() + $amount);
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $amount);
        }
 
        return $this;
    }
}
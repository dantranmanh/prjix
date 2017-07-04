<?php

class Hxtech_Logistic_Model_Total_Pdf_Importer extends Mage_Sales_Model_Order_Pdf_Total_Default
{
    public function getTotalsForDisplay()
    {
        $order = $this->getOrder();
        $importerFee = $order->getImporterCommissionFee();
        
        $label = 'Importer Fee:';        
        $fontSize = $this->getFontSize() ? $this->getFontSize() : 7;
        $total = array(
            'amount'    => Mage::helper('core')->currency($importerFee, true, false),
            'label'     => $label,
            'font_size' => $fontSize
        );
        return array($total);
    }
}
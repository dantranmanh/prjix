<?php

class Hxtech_Document_Model_Total_Pdf_Documentation extends Mage_Sales_Model_Order_Pdf_Total_Default
{
    public function getTotalsForDisplay()
    {
        $order = $this->getOrder();
        //Add Documentation Fee Total row to invoice detail
        $documentId = $order->getDocumentId();
        $documentation = Mage::getModel('document/documentation')->load($documentId);
        $documentationFee = $documentation->getPrice() + $order->getDocumentFee();
        
        $label = 'Documentation Fee:';        
        $fontSize = $this->getFontSize() ? $this->getFontSize() : 7;
        $total = array(
            'amount'    => Mage::helper('core')->currency($documentationFee, true, false),
            'label'     => $label,
            'font_size' => $fontSize
        );
        return array($total);
    }
}
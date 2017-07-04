<?php

class Hxtech_Logistic_Block_Sales_Totals_Order_Importerfee extends Mage_Core_Block_Template 
{
    public function initTotals() 
    {
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $customerId = $quote->getCustomerId();
        if($customerId){
            if(!Mage::helper('logistic/importer')->isShowImporterFee($customerId)){
                return $this;
            }
        }

        $total = new Varien_Object(array(
            'code'  => 'importer_commission_fee',
            'value' => Mage::helper('logistic/importer')->getImporterCommissionFee($quote->getSubtotal()),
            'label' => 'Importers Fee'
        ));

        $after = 'subtotal';

        $this->getParentBlock()->addTotal($total, $after);
        return $this;
    }
}
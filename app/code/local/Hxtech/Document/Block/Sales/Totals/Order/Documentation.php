<?php

class Hxtech_Document_Block_Sales_Totals_Order_Documentation extends Mage_Core_Block_Template {
    public function initTotals() {
        $documentation = Mage::getSingleton('checkout/session')->getDocumentation();
        if(!$documentation){
            return $this;
        }
        $quote = Mage::getSingleton('checkout/session')->getQuote();

        $total = new Varien_Object(array(
          'code'  => 'documentation_fee',
          'value' => Mage::helper('document/documentation')->getDocumentationTotalFee($documentation, $quote->getSubtotal()),
          'label' => 'Export Documentation'
        ));

        $after = 'subtotal';

        $this->getParentBlock()->addTotal($total, $after);
        return $this;
    }
}
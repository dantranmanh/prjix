<?php

class Hxtech_Document_Model_Total_Documentation_Quote extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    public function __construct()
    {
        $this->setCode('documentation_fee');
    }
 
    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return Mage::helper('document')->__('Export Documentation');
    }
    /**
     * Collect totals information about insurance
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     */
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);
        if (($address->getAddressType() == 'billing')) {
            return $this;
        }

        $documentation = Mage::getSingleton('checkout/session')->getDocumentation();
        if($documentation){
            $items = $address->getAllItems();
            $totals = $address->getQuote()->getTotals(); //Total object
            $subtotal = round($totals["subtotal"]->getValue());
            $amount = Mage::helper('document/documentation')->getDocumentationTotalFee($documentation, $subtotal);
        }
        if (isset($amount)) {
            $this->_addAmount($amount);
            $this->_addBaseAmount($amount);
        }
 
        return $this;
    }
 
    /**
     * Add giftcard totals information to address object
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     */
    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        if (($address->getAddressType() == 'billing')) {
            $documentation = Mage::getSingleton('checkout/session')->getDocumentation();
            if($documentation){
                $amount = Mage::helper('document/documentation')->getDocumentationTotalFee($documentation, $address->getQuote()->getSubtotal());
            }
            if(isset($amount)){
                if ($amount != 0) {
                    $address->addTotal(array(
                        'code'  => $this->getCode(),
                        'title' => $this->getLabel(),
                        'value' => $amount
                    ));
                } 
            }
        }
 
        return $this;
    }
}
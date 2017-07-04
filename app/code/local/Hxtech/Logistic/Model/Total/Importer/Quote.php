<?php

class Hxtech_Logistic_Model_Total_Importer_Quote extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    public function __construct()
    {
        $this->setCode('importer_commission_fee');
    }
 
    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return Mage::helper('logistic')->__('Importers Fee');
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

        if(!Mage::helper('logistic/importer')->isShowImporterFee()){
            return $this;
        }

        $totals = $address->getQuote()->getTotals(); //Total object
        $subtotal = round($totals["subtotal"]->getValue()); //Subtotal value
        $importerCommissionFee = Mage::helper('logistic/importer')->getImporterCommissionFee($subtotal);
        if($importerCommissionFee){
            $amount = $importerCommissionFee;
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
        if(!Mage::helper('logistic/importer')->isShowImporterFee()){
            return $this;
        }

        if (($address->getAddressType() == 'billing')) {
            $importerCommissionFee = Mage::helper('logistic/importer')->getImporterCommissionFee($address->getQuote()->getSubtotal());
            if($importerCommissionFee){
                $amount = $importerCommissionFee;
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
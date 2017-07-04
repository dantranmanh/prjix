<?php

class Hxtech_Forex_Block_Financier_List extends Mage_Core_Block_Template
{
	protected $_collection;
    protected $_importerCurrencyCode;
    protected $_exporterCurrencyCode;
    protected $_calculatedGrandTotal;

	protected function _construct()
    {
        parent::_construct();
        $this->_importerCurrencyCode = Mage::helper('forex/currency')->getImporterCurrencyCode();
        $this->_exporterCurrencyCode = Mage::helper('forex/currency')->getExporterCurrencyCode();
        $this->_collection = Mage::getModel('forex/financier')->getCollection();
        $this->filterByExcludeCountries();
    }

    public function getCollection()
    {
    	return $this->_collection;
    }

    public function getImporterCurrencyCode()
    {
        return $this->_importerCurrencyCode;
    }

    public function getExporterCurrencyCode()
    {
        return $this->_exporterCurrencyCode;
    }

    public function getQuote()
    {
        return Mage::getSingleton('checkout/session')->getQuote();
    }

    public function getCalculatedGrandTotal()
    {
        $this->_calculatedGrandTotal = Mage::helper('logistic/logistic')->getCalculatedGrandTotal();
        return $this->_calculatedGrandTotal;
    }

    public function getExchangeRate($financierId)
    {
    	$quote = $this->getQuote();
    	$exchangeRate = $this->getRate('importer')/$this->getRate('exporter'); // Rate without commission
    	$commissionFee = Mage::helper('forex')->getCommissionFee($financierId,  $this->_calculatedGrandTotal, $exchangeRate);
    	return $this->getRate('importer')/$this->getRate('exporter') + $commissionFee;
    }

    private function filterByExcludeCountries()
    {
        $quote = $this->getQuote();
        $billingAddress = $quote->getBillingAddress();
        $countryCode = $billingAddress->getCountryId();
        $this->_collection->addFieldToFilter('exclude_countries',array('nlike'=>'%'.$countryCode.'%'));
    }

    public function getRate($type)
    {
        $quote = $this->getQuote();
        $currencyModel = Mage::getModel('directory/currency');
        $currencies = $currencyModel->getConfigAllowCurrencies();
        $defaultCurrencies = $currencyModel->getConfigBaseCurrencies();
        $baseCurrencyCode = Mage::app()->getStore()->getBaseCurrencyCode();
        $rates=$currencyModel->getCurrencyRates($defaultCurrencies, $currencies);
        switch ($type) {
            case 'importer':
                $currencyCode = Mage::helper('forex/currency')->getImporterCurrencyCode();
                break;
            case 'exporter':
                $currencyCode = Mage::helper('forex/currency')->getExporterCurrencyCode();
                break;
            default:
                $currencyCode = $baseCurrencyCode;
                break;
        }

        $baseRate = 1; // default rate
        foreach($rates[$baseCurrencyCode] as $key=>$value) {
            if($key == $currencyCode){
                $baseRate = $value; // multiple rates by currency. 
            }
        }
        return $baseRate;
    }


}
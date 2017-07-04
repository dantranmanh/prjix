<?php

class Hxtech_Forex_Helper_Currency extends Mage_Core_Helper_Abstract
{
	public function getImporterCurrencyCode()
	{
		$quote = Mage::getSingleton('checkout/session')->getQuote();
        $billingAddress = $quote->getBillingAddress();
        $countryCode = $billingAddress->getCountryId();
        $currencyCode = $this->getCurrencyByCountryCode($countryCode);



        return $currencyCode;
	}

	public function getExporterCurrencyCode()
	{
    $customer = Mage::getSingleton('customer/session')->getCustomer();
    $preferredCurrency = $customer->getPreferredCurrency();
    if($preferredCurrency){
      return $preferredCurrency;
    }
		return '';
	}

	public function getCurrencyByCountryCode($countryCode)
	{
		switch ($countryCode) {
			case 'AU':
				$currencyCode = 'AUD';
				break;
			case 'AUT':
				$currencyCode = 'ATS';
				break;
			case 'BGD':
				$currencyCode = 'BDT';
				break;
			case 'BEL':
				$currencyCode = 'BEF';
				break;
			case 'BGR':
				$currencyCode = 'BGL';
				break;
			case 'CZE':
				$currencyCode = 'CZK';
				break;
			case 'DNK':
				$currencyCode = 'DKK';
				break;
			case 'GB':
				$currencyCode = 'GBP';
				break;
			case 'HUN':
				$currencyCode = 'HUF';
				break;
			case 'SWE':
				$currencyCode = 'SEK';
				break;
			case 'ROM':
				$currencyCode = 'ROL';
				break;
			case 'LIE':
				$currencyCode = 'CHF';
				break;
			case 'NOR':
				$currencyCode = 'NOK';
				break;
			case 'HRV':
				$currencyCode = 'HRK';
				break;
			case 'RUS':
				$currencyCode = 'RUR';
				break;
			case 'TUR':
				$currencyCode = 'TRL';
				break;
			case 'BRA':
				$currencyCode = 'BRL';
				break;
			case 'CAN':
				$currencyCode = 'CAD';
				break;
			case 'CHN':
				$currencyCode = 'CNY';
				break;
			case 'HKG':
				$currencyCode = 'HKD';
				break;
			case 'IDN':
				$currencyCode = 'IDR';
				break;
			case 'ISR':
				$currencyCode = 'ILS';
				break;
			case 'IND':
				$currencyCode = 'INR';
				break;
			case 'KOR':
				$currencyCode = 'KRW';
				break;
			case 'MEX':
				$currencyCode = 'MXN';
				break;
			case 'MYS':
				$currencyCode = 'MYR';
				break;
			case 'COK':
				$currencyCode = 'NZD';
				break;
			case 'PHL':
				$currencyCode = 'PHP';
				break;
			case 'SGP':
				$currencyCode = 'SGD';
				break;
			case 'THA':
				$currencyCode = 'THB';
				break;
			case 'ZAF':
				$currencyCode = 'ZAR';
				break;
			case 'ISL':
				$currencyCode = 'ISK';
				break;
			case 'VN':
				$currencyCode = 'VND';
				break;
			case 'USD':
				$currencyCode = 'USD';
				break;
			default:
				$currencyCode = Mage::app()->getStore()->getBaseCurrencyCode();
				break;
		}
		return $currencyCode;
	}
}
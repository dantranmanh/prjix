<?php

class Hxtech_Logistic_Block_Cbm_Data extends Mage_Core_Block_Template
{
	protected $_pallet = 0;
	protected $_40ftContainer = 0;
	protected $_20ftContainer = 0;
	protected $_palletsPer40ft = 23;
	protected $_palletsPer20ft = 11;
	protected $_percent = 0;

    protected function _construct()
    {
        parent::_construct();
        // $this->_calculateTotalPalletUsed();
    }

    protected function _getQuote()
    {
    	return Mage::getSingleton('checkout/session')->getQuote();
    }

    public function getTotal20ftContainer()
    {
    	return $this->_20ftContainer;
    }

    public function getTotal40ftContainer()
    {
    	return $this->_40ftContainer;
    }

    public function getTotalPallets()
    {
    	return $this->_pallet;
    }

    public function getPercent()
    {
    	return $this->_percent;
    }

    public function getPalletCollection()
    {
        return Mage::getModel('logistic/pallet')->getCollection();
    }

    public function calculateTotalPalletUsed()
    {	
        $palletId = $this->getPalletId();
        $pallet = Mage::getModel('logistic/pallet')->load($palletId);

        $this->_palletsPer20ft = $pallet->getNumberFitSmallContainer();
        $this->_palletsPer40ft = $pallet->getNumberFitLargeContainer();

        $totalCbm = Mage::helper('logistic/logistic')->getTotalCbm();   
        // var_dump($totalCbm);
    	$palletCbm = Mage::helper('logistic/pallet')->getPalletCbm($pallet);
        // var_dump($palletCbm);die;
        $this->_pallet = ceil($totalCbm/$palletCbm);

    	$this->_40ftContainer = floor($this->_pallet / $this->_palletsPer40ft); //qty of 40ft container
        $remain = $this->_pallet - $this->_40ftContainer * $this->_palletsPer40ft;

        if($remain > $this->_palletsPer20ft){
        	// set number 40ft container = 1 if there is no 20 ft container
        	$this->_40ftContainer = ($this->_40ftContainer >= 1) ? $this->_40ftContainer : 1;
            $this->_percent = intval($remain / $this->_palletsPer40ft * 100);
        }else{
        	$this->_20ftContainer = 1;
			$this->_percent = intval($remain / $this->_palletsPer20ft * 100);
        }
    }
}

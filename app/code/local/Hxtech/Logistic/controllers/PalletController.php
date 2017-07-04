<?php

class Hxtech_Logistic_PalletController extends Mage_Core_Controller_Front_Action
{
	public function reloadCbmSectionAction()
	{
		$palletId = $this->getRequest()->getParam('id');
		$pallet = Mage::getModel('logistic/pallet')->load($palletId);
		$result = array();
		$result['html'] = Mage::app()->getLayout()->createBlock('logistic/cbm_data')->setPalletId($palletId)->setTemplate('hxtech/logistic/cbm/data.phtml')->toHtml();

    	$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
	}
}
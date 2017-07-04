<?php

class Hxtech_Logistic_Model_Importertier extends Mage_Core_Model_Abstract
{
    public function _construct() 
    {
        parent::_construct();
        $this->_init('logistic/importertier');
    }

    public function saveTierCommission($tierData, $importerUserId)
    {
    	unset($tierData['delete']);
    	$oldId = $tierData['id'];

    	if($oldId){
    		$this->load($oldId);
    	}else{
    		unset($tierData['id']);
    	}

    	$this->setData($tierData);
    	$this->setImporterUserId($importerUserId);
    	try {
    		$this->save();
    	} catch (Exception $e) {
    		Mage::logException($e->getMessage());
    	}
    }

    public function deleteTierCommission($tierData)
    {
    	$oldId = $tierData['id'];
    	if($oldId){
    		$this->load($oldId);
    	}
    	try {
    		$this->delete();
    	} catch (Exception $e) {
    		Mage::logException($e->getMessage());
    	}
    }
}
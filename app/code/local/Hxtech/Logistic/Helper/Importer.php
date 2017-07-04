<?php

class Hxtech_Logistic_Helper_Importer extends Mage_Core_Helper_Abstract
{
	public function getImporterCommissionData($importer)
	{
		$configModel = Mage::getModel('logistic/importerconfig');
		$configModel->load($importer->getId(), 'importer_user_id');
		return $configModel;
	}

	public function getImporterCommissionFee($subtotal)
	{
        if(!$this->isShowImporterFee()){
            return 0;
        }

		$importer = Mage::getSingleton('customer/session')->getCustomer();
		$configModel = $this->getImporterCommissionData($importer);
		$commissionFee = 0;
		$commissionType = $configModel->getCommissionType();

		switch ($commissionType) {
            case Hxtech_Logistic_Model_Logistic::COMMISSION_FIXED_TYPE: // Commission Algorithm is fixed fee
                $commissionFee += $configModel->getCommissionFixedFee();
                break;
            case Hxtech_Logistic_Model_Logistic::COMMISSION_PERCENTAGE_TYPE: // Commission Algorithm is percentage fee
                $commissionFee += $configModel->getCommissionPercentageFee() * $subtotal / 100;
                break;
            case Hxtech_Logistic_Model_Logistic::COMMISSION_COMPARISON_TYPE: // Commission Algorithm is tier
                $commissionFee += $this->getTierCommissionFee($importer, $subtotal);
                break;
            default:
                $commissionFee = 0; //Commission Fee = 0 by default
        }

		return $commissionFee;
	}

	public function getTierCommissionFee($importer, $subtotal)
    {
        $commissionFee = 0;
        $isLoggedIn = Mage::getSingleton('customer/session')->isLoggedIn();
        if($isLoggedIn){
            $groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
        }else{
            $groupId = 0;
        }
        $tierCollection = Mage::getModel('logistic/importertier')->getCollection();
        $tierCollection
            ->addFieldToFilter('importer_user_id', $importer->getId())
            ->addFieldToFilter(
                array('cust_group', 'cust_group'),
                array(
                    array('eq'=> $groupId), 
                    array('eq'=> Mage_Customer_Model_Group::CUST_GROUP_ALL)
                )
            )
            ->addFieldToFilter('price_min', array('lt' => $subtotal))
            ->addFieldToFilter('price_max', array('gt' => $subtotal));

        $countTierOptions = count($tierCollection->getData());
        if($countTierOptions = 1){ //in case there is only 1 tier options matched the conditions. 
            $item = $tierCollection->getFirstItem();
            $percentageFee = $item->getPercentage() * $subtotal / 100;
            $fixedFee = $item->getFixedFee();
            $commissionFee += max($fixedFee, $percentageFee);
        }

        return $commissionFee;
    }

    public function isShowImporterFee($customerId = null)
    { 
        if(!$customerId){
            $customer = Mage::getSingleton('customer/session')->getCustomer();
        }else{
            $customer = Mage::getModel('customer/customer')->load($customerId);
        }
        if($customer){
            $commissionConfig = Mage::getModel('logistic/importerconfig')->load($customer->getId(), 'importer_user_id');
            $commissionStatus = $commissionConfig->getCommissionStatus();
            if($commissionStatus == 1){
                return true;
            }
            return false;
        }
        return false;
    }
}
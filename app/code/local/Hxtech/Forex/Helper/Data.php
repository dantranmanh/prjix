<?php

class Hxtech_Forex_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getCommissionFee($financierId, $subtotal, $exchangeRate)
	{
		$commissionFee = 0;
		$financier = Mage::getModel('forex/financier')->load($financierId);
		$commissionType = $financier->getCommissionType();
        $commissionFixedFee = $financier->getCommissionFixedFee();
        $commissionPercentageFee = $financier->getCommissionPercentageFee() * $exchangeRate / 100;
        switch ($commissionType) {
            case Hxtech_Logistic_Model_Logistic::COMMISSION_FIXED_TYPE: // Commission Algorithm is fixed fee
                $commissionFee += $commissionFixedFee;
                break;
            case Hxtech_Logistic_Model_Logistic::COMMISSION_PERCENTAGE_TYPE: // Commission Algorithm is percentage fee
                $commissionFee += $commissionPercentageFee;
                break;
            case Hxtech_Logistic_Model_Logistic::COMMISSION_COMPARISON_TYPE: // Commission Algorithm is tier
                $commissionFee += $this->getTierCommissionFee($financier, $subtotal, $exchangeRate);
                break;
            default:
                $commissionFee = 0; //Commission Fee = 0 by default
        }
        $commissionFee = number_format($commissionFee, 4, '.', '');
        return $commissionFee;
	}

	public function getTierCommissionFee($financier, $subtotal, $exchangeRate)
    {
        $commissionFee = 0;
        $isLoggedIn = Mage::getSingleton('customer/session')->isLoggedIn();
        if($isLoggedIn){
            $groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
        }else{
            $groupId = 0;
        }
        $tierCollection = Mage::getModel('forex/tiercommission')->getCollection();
        $tierCollection
            ->addFieldToFilter('financier_id', $financier->getId())
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
        if($countTierOptions == 1){ //in case there is only 1 tier options matched the conditions. 
            $item = $tierCollection->getFirstItem();
            $percentageFee = $item->getPercentage() * $exchangeRate / 100;
            $fixedFee = $item->getFixedFee();
            $commissionFee += max($fixedFee, $percentageFee);
        }

        return $commissionFee;
    }

	public function getFinancierLogo($financierId)
	{
		$financier = Mage::getModel('forex/financier')->load($financierId);
        $src = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'forex'.DS.'financier'.DS.'logo'.DS.$financier->getLogo();
        $html = '<img width="200px" src="'.$src.'"/>';
        return $html;
	}
}
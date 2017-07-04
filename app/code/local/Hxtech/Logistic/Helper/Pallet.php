<?php

class Hxtech_Logistic_Helper_Pallet extends Mage_Core_Helper_Abstract
{
	public function getPalletDropdownHtml()
	{
		$html = "";
		$pallets = Mage::getModel('logistic/pallet')->getCollection();

		if($pallets->getSize() > 0){
			$html .= '<select id="palletDdl" onchange="reloadCbmSection(this)">';
			// $html .= '<option value="">---- Choose ----</option>';
			foreach($pallets as $pallet){
				$html .= '<option value="'.$pallet->getId().'">'.$pallet->getName().'</option>';
			}
			$html .= "</select>";
		}
		return $html;
	}	

	public function getPalletDropdownProductHtml($productId)
	{
		$html = "";
		$pallets = Mage::getModel('logistic/pallet')->getCollection();

		if($pallets->getSize() > 0){
			$html .= '<select id="palletDdl" onchange="reloadContainerSection('.$productId.')">';
			// $html .= '<option value="">---- Choose ----</option>';
			foreach($pallets as $pallet){
				$html .= '<option value="'.$pallet->getId().'">'.$pallet->getName().'</option>';
			}
			$html .= "</select>";
		}
		return $html;
	}

	public function getPalletCbm($pallet)
	{
		$palletCbm = $pallet->getWidth() * $pallet->getLength() * $pallet->getHeight() * pow(10, -9);
		return $palletCbm;
	}
}
<?php

class Hxtech_Logistic_Model_Csv_Order extends Mage_Core_Helper_Abstract
{
    public function __construct()
    {
    }

    protected function _getHeaders()
    {
        $headers = array('Product Code', 'HS Code', 'Product Description', 'Unit / Outer', 'Qty Required', 'Price / Outer',
            'Total Line Value', 'Volume per case', 'Total Line Volume (m3)', 'Net Weight/ Outer', 'Total Net Weight(kg)', 'Gross Weight / Outer',
            'Total Gross Weight (kg)', 'Total Units', 'Best Before Date');
        return $headers;
    }

    protected function _getQuote()
    {
        return Mage::getSingleton('checkout/session')->getQuote();
    }

    protected function _getVolumetricData()
    {
    	$documentation = Mage::getSingleton('checkout/session')->getDocumentation();
    	$documentationFee = 0;
    	if($documentation){
    		$documentationFee += $documentation->getPrice();
    	}
        $totalRowValues = Mage::helper('logistic/logistic')->getTotalRowValues();
        $csv = '';
        $csv.=  '"Order Value",';
        $csv.= "\n";
        $csv.=  '"AUD ($)","'.$this->_getQuote()->getSubtotal().'",';
        $csv.= "\n";
        $csv.= "\n";
        $csv.=  '"Volumetrics",';
        $csv.= "\n";
        $csv.=  '"Gross Weight","'.$totalRowValues['total_gross_weight'].'",';
        $csv.= "\n";
        $csv.=  '"Volume (m3)","'.number_format($totalRowValues['total_line_volume'], 3, '.', '').'",';
        $csv.= "\n";
        $csv.=  '"Total Cases","'.$totalRowValues['total_outers'].'",';
        $csv.= "\n";
        $csv.=  '"Total Units","'.$totalRowValues['total_units'].'",';
        $csv.= "\n";
        $csv.= "\n";
        $csv.=  '"Export Documentation","'.$documentationFee.'",';
        $csv.= "\n";
        $csv.= "\n";
        $csv.= "\n";
        return $csv;
    }

    public function getCsv()
    {
        $csv = '';
        $items = $this->_getQuote()->getAllItems();
        $data = array();

        $csv.= "\n";
        $volumetricsData = $this->_getVolumetricData();
        $csv.= $volumetricsData;

        $columns = $this->_getHeaders();
        foreach ($columns as $column) {
            $data[] = '"'.$column.'"';
        }
        $csv.= implode(',', $data)."\n";

        foreach ($items as $item) {
            $product = $item->getProduct();
            $finalPrice = Mage::helper('core')->currency($product->getFinalPrice(), true, false);
            $productId = $product->getId();
            $qty = $item->getQty();
            $data = array();
            $data[] = $product->getSku();
            $data[] = Mage::helper('logistic')->getProductAttribute($productId, 'product_hs_code');
            $data[] = $product->getName();
            $data[] = Mage::helper('logistic')->getProductAttribute($productId, 'product_qty_per_outer');
            $data[] = $qty;
            $data[] = str_replace(',', '', $finalPrice);
            $data[] = str_replace(',','',Mage::helper('core')->currency($item->getRowTotalInclTax(), true, false));
            $data[] = number_format(Mage::helper('logistic')->getProductAttribute($productId, 'product_volume'), 3, '.', '');
            $data[] = number_format(Mage::helper('logistic/logistic')->getTotalLineVolumeOfProduct($product, $qty), 3, '.', '');
            $data[] = Mage::helper('logistic')->getProductAttribute($productId, 'product_net_weight');
            $data[] = $qty * Mage::helper('logistic')->getProductAttribute($productId, 'product_net_weight');
            $data[] = Mage::helper('logistic')->getProductAttribute($productId, 'weight');
            $data[] = $qty * Mage::helper('logistic')->getProductAttribute($productId, 'weight');
            $data[] = Mage::helper('logistic/logistic')->getTotalUnits($product, $qty);
            $data[] = Mage::helper('logistic')->getProductAttribute($productId, 'product_best_before_date');
            $csv.= implode(',', $data)."\n";
        }

        return $csv;
    }
}
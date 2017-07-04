<?php

class Hxtech_Logistic_Model_Csv_Cart extends Mage_Core_Helper_Abstract
{
    public function __construct()
    {
    }

    protected function _getHeaders()
    {
        $headers = array(
            'Product Code',
            'HS Code',
            'Product Description',
            'Inner/Unit Barcode',
            'Outer Barcode',
            'Shipping/Case Barcode',
            'Unit Weight',
            'Unit / Outer',
            'Qty Required',
            'Price / Outer',
            'Total Line Value', 
            'Volume per case',
            'Total Line Volume (m3)',
            'Volume per pallet',
            'Net Weight/ Outer',
            'Total Net Weight(kg)',
            'Gross Weight / Outer',
            'Total Gross Weight (kg)',
            'Total Units',
            'Best Before Date'
        );
        return $headers;
    }

    public function getCsv($currentQuote)
    {
        $csv = '';
        $items = $currentQuote->getAllItems();
        $data = array();

        $csv.= '"Subtotal","'.$currentQuote->getSubtotal().'",';
        $csv.= "\n"."\n";

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
            $data[] = Mage::helper('logistic')->getProductAttribute($productId, 'product_barcode_unit');
            $data[] = Mage::helper('logistic')->getProductAttribute($productId, 'product_barcode_inner');
            $data[] = Mage::helper('logistic')->getProductAttribute($productId, 'product_barcode_outer');
            $data[] = Mage::helper('logistic')->getProductAttribute($productId, 'product_unit_weight');
            $data[] = Mage::helper('logistic')->getProductAttribute($productId, 'product_units_per_case');
            $data[] = $qty;
            $data[] = str_replace(',', '', $finalPrice);
            $data[] = str_replace(',','',Mage::helper('core')->currency($item->getRowTotalInclTax(), true, false));
            $data[] = number_format(Mage::helper('logistic')->getProductAttribute($productId, 'product_case_volume'), 4, '.', '');
            $data[] = number_format(Mage::helper('logistic/logistic')->getTotalLineVolumeOfProduct($product, $qty), 4, '.', '');
            $data[] = number_format(Mage::helper('logistic')->getProductAttribute($productId, 'product_volume_per_pallet'), 4, '.', '');
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
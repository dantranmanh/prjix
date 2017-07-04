<?php 
class Globo_Calculatorvolume_Model_Observer {
    public function getFormat($value,$precision)
    {
        $value = ( string )$value;
        preg_match( "/(-+)?\d+(\.\d{1,".$precision."})?/" , $value, $matches );
        return $matches[0];            
    }
    public function autoCalculatorVolume($observer) {
        $product = $observer->getEvent()->getProduct();
        $volume = 0;
        $height = (float)$product->getHeight();
        $width = (float)$product->getWidth();
        $depth = (float)$product->getDepth();
        $volume = $height*$width*$depth / 1000000000;
        //$volume = floor($volume*10000)/10000;
        $volume = (float)$this->getFormat($volume,4);
        $product->setProductCaseVolume($volume);
        
        $product_unit_weight = (float)$product->getProductUnitWeight();
        $product_units_per_case = (float)$product->getProductUnitsPerCase();
        $weight = $product_unit_weight*$product_units_per_case/1000;
        
        //$weight = floor($weight*10000)/10000;
        $weight = (float)$this->getFormat($weight,4);
        $product->setProductNetWeight($weight);
    } 
}
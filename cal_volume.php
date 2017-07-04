<?php

/**
 * @author mai van hien
 * @copyright 2016
 */

require_once('app/Mage.php');
umask(0);
Mage::app('default');
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$productCollection = Mage::getModel('catalog/product')->getCollection();
function getFormat( $value, $precision )
{
    //Casts provided value
    $value = ( string )$value;

    //Gets pattern matches
    preg_match( "/(-+)?\d+(\.\d{1,".$precision."})?/" , $value, $matches );

    //Returns the full pattern match
    return $matches[0];            
};
foreach($productCollection as $_product) 
{
    //if($_product->getId() < 6){
        $product = Mage::getModel('catalog/product')->load($_product->getEntityId());
        $volume = 0;
        $height = (float)$product->getHeight();
        $width = (float)$product->getWidth();
        $depth = (float)$product->getDepth();
        $volume = $height*$width*$depth / 1000000000;
        $volume = floor($volume*10000)/10000;  
        $product->setData('product_case_volume', $volume);
        
        $product_unit_weight = (float)$product->getProductUnitWeight();
        
        $product_units_per_case = (float)$product->getProductUnitsPerCase();
        $weight = ($product_unit_weight*$product_units_per_case)/1000;
        $weight = (float)getFormat($weight,4);
        $product->setData('product_net_weight', $weight);
        echo '#'.$_product->getId().'Volume(m3): '.$volume.'; Net Weight / Case (kg):'.$weight.'<br/>';
        $product->save();
        unset($product);
    //}
}

?>

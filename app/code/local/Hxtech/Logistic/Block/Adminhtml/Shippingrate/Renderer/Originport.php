<?php
//globo add
class Hxtech_Logistic_Block_Adminhtml_Shippingrate_Renderer_Originport
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value = $row->getData('origin_port');
        if(strlen($value) > 50) $value = substr($value,0,50).'...';
        return $value;
    }
}
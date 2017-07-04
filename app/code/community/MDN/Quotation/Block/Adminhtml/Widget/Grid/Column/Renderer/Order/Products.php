<?php

class MDN_Quotation_Block_Adminhtml_Widget_Grid_Column_Renderer_Order_Products extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $order) {

        $html = '';

        foreach($order->getAllItems() as $item)
        {
            if (!$item->getParentItemId())
                $html .= (int)$item->getQtyOrdered().'x '.$item->getName().'<br>';
        }

        return $html;

    }

}


<?php

class MDN_Quotation_Block_Adminhtml_Widget_Grid_Column_Renderer_Products extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {

        $html = '';

        foreach($row->getItems() as $item)
        {
            $html .= $item->getQty().'x '.$item->getCaption().'<br>';
        }

        return $html;
    }

}

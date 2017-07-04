<?php

class MDN_Quotation_Block_Adminhtml_Widget_Grid_Column_Renderer_QuoteTotal extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
        return $row->FormatPrice($row->GetFinalPriceWithTaxes());
    }

}
<?php

class MDN_Quotation_Block_Adminhtml_Widget_Grid_Column_Renderer_Status extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
        $class = 'grid-severity-notice';
        switch($row->getStatus())
        {
            case MDN_Quotation_Model_Quotation::STATUS_NEW : $class = 'grid-severity-minor'; break;
            case MDN_Quotation_Model_Quotation::STATUS_CUSTOMER_REQUEST : $class = 'grid-severity-minor'; break;
            case MDN_Quotation_Model_Quotation::STATUS_EXPIRED : $class = 'grid-severity-major'; break;
        }

        return '<span class="'.$class.'"><span>'.Mage::helper('quotation')->translateStatus($row->getStatus()).'</span></span>';
    }

}

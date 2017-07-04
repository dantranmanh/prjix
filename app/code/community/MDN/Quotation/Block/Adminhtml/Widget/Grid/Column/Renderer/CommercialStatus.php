<?php

class MDN_Quotation_Block_Adminhtml_Widget_Grid_Column_Renderer_CommercialStatus extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
        $class = 'grid-severity-notice';
        switch($row->getBought())
        {
            case 0:
                $class = 'grid-severity-minor';
                break;
            case 1:
                $class = 'grid-severity-notice';
                break;
            case 2:
                $class = 'grid-severity-minor';
                break;
            case 3:
                $class = 'grid-severity-minor';
                break;
            case 4:
                $class = 'grid-severity-major';
                break;
        }

        return '<span class="'.$class.'"><span>'.Mage::helper('quotation')->translateCommercialStatus($row->getBought()).'</span></span>';
    }

}

<?php

class Hxtech_Forex_Block_Adminhtml_Financier_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('financier_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('forex')->__('Financier Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('financier_info', array(
            'label' => Mage::helper('forex')->__('Financier Information'),
            'title' => Mage::helper('forex')->__('Financier Information'),
            'content' => $this->getLayout()->createBlock('forex/adminhtml_financier_edit_tab_form')->toHtml(),
        ));

        $this->addTab('tier_info', array(
            'label' => Mage::helper('forex')->__('Transaction Fees'),
            'title' => Mage::helper('forex')->__('Transaction Fees'),
            'content' => $this->getLayout()->createBlock('forex/adminhtml_financier_edit_tab_commission')->toHtml(),
        ));
        
        return parent::_beforeToHtml();
    }
}
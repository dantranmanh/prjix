<?php

class Hxtech_Logistic_Block_Adminhtml_Pallet_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('pallet_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('logistic')->__('Pallet Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('pallet_info', array(
            'label' => Mage::helper('logistic')->__('Pallet Information'),
            'title' => Mage::helper('logistic')->__('Pallet Information'),
            'content' => $this->getLayout()->createBlock('logistic/adminhtml_pallet_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
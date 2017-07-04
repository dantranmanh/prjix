<?php

class Hxtech_Logistic_Block_Adminhtml_Logistic_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('logistic_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('logistic')->__('Logistic Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('logistic_info', array(
            'label' => Mage::helper('logistic')->__('Customer Information'),
            'title' => Mage::helper('logistic')->__('Customer Information'),
            'content' => $this->getLayout()->createBlock('logistic/adminhtml_logistic_edit_tab_form')->toHtml(),
        ));

        $this->addTab('logistic_order', array(
            'label' => Mage::helper('logistic')->__('Transaction Fee History'),
            'title' => Mage::helper('logistic')->__('Transaction Fee History'),
            'url' => $this->getUrl('logistic/adminhtml_logistic/orderTab', array('_current' => true)),
            'class' => 'ajax',
        ));
        
        $isAdminUser = Mage::helper('logistic/logistic')->isAdminUser();
        if($isAdminUser){
            $this->addTab('tier_info', array(
                'label' => Mage::helper('logistic')->__('Transaction Fees'),
                'title' => Mage::helper('logistic')->__('Transaction Fees'),
                'content' => $this->getLayout()->createBlock('logistic/adminhtml_logistic_edit_tab_commission')->toHtml(),
            ));
        }

        $this->addTab('addresses', array(
            'label' => Mage::helper('logistic')->__('Address'),
            'title' => Mage::helper('logistic')->__('Address'),
            'content' => $this->getLayout()->createBlock('logistic/adminhtml_logistic_edit_tab_address')->toHtml(),
        ));

        $this->addTab('term_condition', array(
            'label' => Mage::helper('logistic')->__('Terms & Conditions'),
            'title' => Mage::helper('logistic')->__('Terms & Conditions'),
            'content' => $this->getLayout()->createBlock('logistic/adminhtml_logistic_edit_tab_term')->toHtml(),
        ));
        
        return parent::_beforeToHtml();
    }
}
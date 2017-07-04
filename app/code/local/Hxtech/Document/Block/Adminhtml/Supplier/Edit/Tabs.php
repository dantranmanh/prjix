<?php

class Hxtech_Document_Block_Adminhtml_Supplier_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('document_supplier_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('document')->__('Document Supplier Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('document_supplier_info', array(
            'label' => Mage::helper('document')->__('Customer Information'),
            'title' => Mage::helper('document')->__('Customer Information'),
            'content' => $this->getLayout()->createBlock('document/adminhtml_supplier_edit_tab_form')->toHtml(),
        ));

        $this->addTab('document_order', array(
            'label' => Mage::helper('document')->__('Transaction Fee History'),
            'title' => Mage::helper('document')->__('Transaction Fee History'),
            'url' => $this->getUrl('document/adminhtml_supplier/orderTab', array('_current' => true)),
            'class' => 'ajax',
        ));

        $isAdminUser = Mage::helper('document')->isAdminUser();
        if($isAdminUser){
            $this->addTab('documen_commission', array(
                'label' => Mage::helper('document')->__('Transaction Fees'),
                'title' => Mage::helper('document')->__('Transaction Fees'),
                'content' => $this->getLayout()->createBlock('document/adminhtml_supplier_edit_tab_commission')->toHtml(),
            ));
        }

        $this->addTab('addresses', array(
            'label' => Mage::helper('logistic')->__('Address'),
            'title' => Mage::helper('logistic')->__('Address'),
            'content' => $this->getLayout()->createBlock('document/adminhtml_supplier_edit_tab_address')->toHtml(),
        ));

        $this->addTab('term_condition', array(
            'label' => Mage::helper('logistic')->__('Terms & Conditions'),
            'title' => Mage::helper('logistic')->__('Terms & Conditions'),
            'content' => $this->getLayout()->createBlock('logistic/adminhtml_logistic_edit_tab_term')->toHtml(),
        ));
        
        return parent::_beforeToHtml();
    }
}
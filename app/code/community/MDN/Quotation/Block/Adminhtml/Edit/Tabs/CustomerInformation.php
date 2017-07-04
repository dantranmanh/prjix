<?php

class MDN_Quotation_Block_Adminhtml_Edit_Tabs_CustomerInformation extends Mage_Adminhtml_Block_Customer_Edit_Tab_View {

    protected $_product;

    public function getCustomer()
    {
        if (!$this->_customer) {
            $this->_customer = $this->getQuote()->getCustomer();
        }
        return $this->_customer;
    }


    /**
     * Return current quote
     */
    public function getQuote()
    {
        return Mage::registry('current_quote');
    }

    /**
     * Constructor
     */
    public function __construct() {

        parent::__construct();
        $this->setHtmlId('general');
        $this->setTemplate('Quotation/Edit/Tab/CustomerInformation.phtml');

        Mage::register('current_customer', $this->getCustomer());
    }


}

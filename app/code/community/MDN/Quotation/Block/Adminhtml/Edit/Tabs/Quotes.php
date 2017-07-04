<?php

class MDN_Quotation_Block_Adminhtml_Edit_Tabs_Quotes extends MDN_Quotation_Block_Adminhtml_Grid {


    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->setEmptyText(Mage::helper('quotation')->__('No items'));
        $this->setPagerVisibility(false);
        $this->setFilterVisibility(false);
        $this->setDefaultLimit(200);
    }

    /**
     * Return current quote
     */
    public function getQuote()
    {
        return Mage::registry('current_quote');
    }


    /**
     * Load collection
     *
     * @return unknown
     */
    protected function _prepareCollection() {


        $collection = Mage::getModel('Quotation/Quotation')
                                ->getCollection()
                                ->addFieldToFilter('customer_id', $this->getQuote()->getcustomer_id())
                                ->addFieldToFilter('quotation_id', array('neq' => $this->getQuote()->getId()))
                                ;
        $this->setDefaultSort('quotation_id', 'DESC');
        $this->setCollection($collection);
        return $this;
    }

    protected function _prepareColumns() {

        parent::_prepareColumns();

        foreach ($this->getColumns() as $column) {
        $column->setSortable(false);
        }

        return $this;
    }


/**
     * Set row url
     */
    public function getRowUrl($row) {
        return $this->getUrl('adminhtml/Quotation_Admin/edit', array('quote_id' => $row->getId()));
    }

}

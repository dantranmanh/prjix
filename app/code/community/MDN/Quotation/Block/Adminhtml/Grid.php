<?php

class MDN_Quotation_Block_Adminhtml_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->setId('QuotationCompleteListGrid');
        $this->_parentTemplate = $this->getTemplate();
        $this->setEmptyText(Mage::helper('quotation')->__('No items'));
    }

    /**
     * Load collection
     *
     * @return unknown
     */
    protected function _prepareCollection() {
        $collection = Mage::getModel('Quotation/Quotation')->getCollection();

        $this->setDefaultSort('created_time');
        $this->setDefaultDir('DESC');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * set columns
     *
     * @return unknown
     */
    protected function _prepareColumns() {


        $this->addColumn('increment_id', array(
                'header' => Mage::helper('quotation')->__('Ref'),
                'index' => 'increment_id',
            ));

        $this->addColumn('created_time', array(
            'header' => Mage::helper('quotation')->__('Date'),
            'index' => 'created_time',
            'type' => 'date'
        ));

        $this->addColumn('manager', array(
                'header' => Mage::helper('quotation')->__('Manager'),
                'index' => 'manager',
                'type' => 'options',
                'options' => Mage::helper('quotation')->getUsers(),
                'align' => 'center'
            ));

        $this->addColumn('customer_name', array(
            'header' => Mage::helper('quotation')->__('Customer'),
            'index' => 'customer_name'
        ));

        $this->addColumn('caption', array(
            'header' => Mage::helper('quotation')->__('Caption'),
            'index' => 'caption',
        ));

        $this->addColumn('total', array(
                'header' => Mage::helper('quotation')->__('Total (excl tax)'),
                'renderer' => 'MDN_Quotation_Block_Adminhtml_Widget_Grid_Column_Renderer_QuoteTotal',
                'filter' => false,
                'sortable' => false,
                'align' => 'right'
            ));

        $this->addColumn('products', array(
                'header' => Mage::helper('quotation')->__('Products'),
                'renderer' => 'MDN_Quotation_Block_Adminhtml_Widget_Grid_Column_Renderer_Products',
                'filter' => false,
                'sortable' => false
            ));


        $this->addColumn('status', array(
            'header' => Mage::helper('quotation')->__('Status'),
            'index' => 'status',
            'type' => 'options',
            'options' => Mage::helper('quotation')->getStatusesAsArray(),
            'renderer' => 'MDN_Quotation_Block_Adminhtml_Widget_Grid_Column_Renderer_Status',
            'align' => 'center',
            'width' => '150px'
        ));

        $this->addColumn('Bought', array(
            'header' => Mage::helper('quotation')->__('Commercial status'),
            'index' => 'bought',
            'type' => 'options',
            'options' => Mage::getModel('Quotation/Quotation')->getBoughtStatusValues(),
            'renderer' => 'MDN_Quotation_Block_Adminhtml_Widget_Grid_Column_Renderer_CommercialStatus',
            'align' => 'center',
            'width' => '150px'
        ));

        return parent::_prepareColumns();
    }


    public function getGridParentHtml() {
        $templateName = Mage::getDesign()->getTemplateFilename($this->_parentTemplate, array('_relative' => true));
        return $this->fetchView($templateName);
    }

    /**
     * Set row url
     */
    public function getRowUrl($row) {
        return $this->getUrl('adminhtml/Quotation_Admin/edit', array('quote_id' => $row->getId()));
    }

}

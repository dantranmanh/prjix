<?php

class MDN_Quotation_Block_Adminhtml_Edit_Tabs_Orders extends Mage_Adminhtml_Block_Widget_Grid {


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
        $this->setId('quotation_orders');
        $this->_parentTemplate = $this->getTemplate();
        $this->setEmptyText(Mage::helper('quotation')->__('No items'));

        $this->setPagerVisibility(false);
        $this->setFilterVisibility(false);
        $this->setDefaultLimit(200);

        $this->setDefaultSort('created_at');
        $this->setDefaultDir('desc');
    }

    /**
     * Load history
     */
    protected function _prepareCollection() {

        $collection = Mage::getModel('sales/order')->getCollection()->addAttributeToSelect('*')->addFieldToFilter('customer_id', $this->getQuote()->getCustomerId());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Set columns
     *
     * @return unknown
     */
    protected function _prepareColumns() {

        $this->addColumn('increment_id', array(
                'header' => Mage::helper('quotation')->__('#'),
                'index' => 'increment_id'
            ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                    'header'    => Mage::helper('sales')->__('Purchased From (Store)'),
                    'index'     => 'store_id',
                    'type'      => 'store',
                    'store_view'=> true,
                    'display_deleted' => true,
                ));
        }

        $this->addColumn('created_at', array(
                'header' => Mage::helper('sales')->__('Purchased On'),
                'index' => 'created_at',
                'type' => 'datetime',
                'width' => '100px',
            ));
        $this->addColumn('products', array(
                'header' => Mage::helper('quotation')->__('Products'),
                'renderer' => 'MDN_Quotation_Block_Adminhtml_Widget_Grid_Column_Renderer_Order_Products',
                'filter' => false,
                'sortable' => false
            ));

        $this->addColumn('base_grand_total', array(
                'header' => Mage::helper('sales')->__('Total'),
                'index' => 'base_grand_total',
                'type'  => 'currency',
                'currency' => 'base_currency_code',
            ));

        $this->addColumn('status', array(
                'header' => Mage::helper('quotation')->__('Status'),
                'index' => 'status'
            ));


        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            $this->addColumn('action',
                array(
                    'header'    => Mage::helper('sales')->__('Action'),
                    'width'     => '50px',
                    'type'      => 'action',
                    'getter'     => 'getId',
                    'actions'   => array(
                        array(
                            'caption' => Mage::helper('sales')->__('View'),
                            'url'     => array('base'=>'adminhtml/sales_order/view'),
                            'field'   => 'order_id'
                        )
                    ),
                    'filter'    => false,
                    'sortable'  => false,
                    'index'     => 'stores',
                    'is_system' => true,
                ));
        }

        foreach ($this->getColumns() as $column) {
            $column->setSortable(false);
        }

        return parent::_prepareColumns();
    }

}

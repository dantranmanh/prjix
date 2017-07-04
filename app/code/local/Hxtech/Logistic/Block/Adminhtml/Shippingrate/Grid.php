<?php

class Hxtech_Logistic_Block_Adminhtml_Shippingrate_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    public function __construct() {
        parent::__construct();
        $this->setId('adminhtml_logistic');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(TRUE);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('logistic/shippingrate')->getCollection();

        if(Mage::helper('logistic/logistic')->isAdminUser()){
            $adminUserTable = Mage::getResourceSingleton('core/resource')->getTable('admin/user');
            $collection->getSelect()->joinLeft(
                $adminUserTable,
                'main_table.logistic_user_id =' . $adminUserTable . '.user_id',
                array(
                    'username',
                )
            );
        }

        if(Mage::helper('logistic/logistic')->isLogisticUser()){
            $logisticId = Mage::helper('logistic/logistic')->getCurrentAdminUserId();
            $collection->addFieldToFilter('logistic_user_id', $logisticId);
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function  _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }

    protected function _prepareColumns() {
        $store = $this->_getStore();

        $this->addColumn('id', array(
            'header' => Mage::helper('logistic')->__('Reference ID'),
            'index' => 'id',
        ));

        if(Mage::helper('logistic/logistic')->isAdminUser()){
            $this->addColumn('username', array(
                'header' => Mage::helper('logistic')->__('Logistic'),
                'index' => 'username',
            ));
        }

        $this->addColumn('name_of_service', array(
            'header' => Mage::helper('logistic')->__('Name of Service'),
            'index' => 'name_of_service',
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('logistic')->__('Status'),
            'align' => 'left',
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                1 => 'Enabled',
                2 => 'Disabled',
            ),
        ));

        $this->addColumn('container_size', array(
            'header' => Mage::helper('logistic')->__('Container Size'),
            'index' => 'container_size',
            'type' => 'options',
            'options' => Mage::helper('logistic/field')->getShippingRateGridOptions('container_size')
        ));

        $this->addColumn('shipping_terms', array(
            'header' => Mage::helper('logistic')->__('Shipping Terms'),
            'index' => 'shipping_terms',
            'type' => 'options',
            'options' => Mage::helper('logistic/field')->getShippingRateGridOptions('shipping_terms')
        ));

        $this->addColumn('transport_method', array(
            'header' => Mage::helper('logistic')->__('Transport Method'),
            'index' => 'transport_method',
            'type' => 'options',
            'options' => Mage::helper('logistic/field')->getShippingRateGridOptions('transport_method')
        ));

        $this->addColumn('origin_port', array(
            'header' => Mage::helper('logistic')->__('Origin & Port'),
            'index' => 'origin_port',
            'type' => 'options',
            'options' => Mage::helper('logistic/field')->getShippingRateGridOptions('origin_port'),
            //globo add
            'filter_condition_callback'
                                => array($this, '_filterOriginPort'),
            'renderer' =>'Hxtech_Logistic_Block_Adminhtml_Shippingrate_Renderer_Originport'
        ));

        $this->addColumn('destination_port', array(
            'header' => Mage::helper('logistic')->__('Destination & Port'),
            'index' => 'destination_port',
            'type' => 'options',
            'options' => Mage::helper('logistic/field')->getPortGridOptions(),
            // globo add
            'filter_condition_callback'
                                => array($this, '_filterDestinationPort'),
            'renderer' =>'Hxtech_Logistic_Block_Adminhtml_Shippingrate_Renderer_Destinationport'
        ));

        $this->addColumn('container_specifications', array(
            'header' => Mage::helper('logistic')->__('Container Specifications'),
            'index' => 'container_specifications',
            'type' => 'options',
            'options' => Mage::helper('logistic/field')->getShippingRateGridOptions('container_specifications')
        ));

        $this->addColumn('transit_time', array(
            'header' => Mage::helper('logistic')->__('Transit Time'),
            'index' => 'transit_time',
        ));

        $this->addColumn('price_cbm', array(
            'header' => Mage::helper('logistic')->__('Price/CBM'),
            'index' => 'price_cbm',
            'type'  => 'price',
            'currency_code' => $store->getBaseCurrency()->getCode(),
        ));

        $this->addColumn('documentation_fee', array(
            'header' => Mage::helper('logistic')->__('Documentation Fee'),
            'index' => 'documentation_fee',
            'type'  => 'price',
            'currency_code' => $store->getBaseCurrency()->getCode(),
        ));
        
        return parent::_prepareColumns();
    }
    // globo add
    protected function _filterOriginPort($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
     
        $this->getCollection()->addFieldToFilter('origin_port', array('finset' => $value));
    }
    protected function _filterDestinationPort($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
     
        $this->getCollection()->addFieldToFilter('destination_port', array('finset' => $value));
    }
    //#globo add
    protected function _prepareMassaction() {
        $this->setMassactionIdField('logistic_id');
        $this->getMassactionBlock()->setFormFieldName('logistic');

        $this->getMassactionBlock()->addItem('delete', array(
                'label' => Mage::helper('adminhtml')->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => Mage::helper('adminhtml')->__('Are you sure?'))
        );

        return $this;
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
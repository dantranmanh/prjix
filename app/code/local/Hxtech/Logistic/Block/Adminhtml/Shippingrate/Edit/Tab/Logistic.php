<?php

class Hxtech_Logistic_Block_Adminhtml_Shippingrate_Edit_Tab_Logistic extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('list_logistic_provider');
        $this->setDefaultSort('id');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('is_logistic_user', 1);
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('user_id', array(
            'header_css_class'  => 'a-center',
            'type'              => 'radio',
            'html_name'        => 'selected_logistic[]',
            'value'            => $this->_getSelectedLogistic(),
            'align'             => 'center',
            'index'             => 'user_id'
        ));

        $this->addColumn('email', array(
            'header' => Mage::helper('logistic')->__('Email'),
            'index' => 'email',
        ));

        $this->addColumn('username', array(
            'header' => Mage::helper('logistic')->__('User Name'),
            'index' => 'username',
        ));

        $this->addColumn('firstname', array(
            'header' => Mage::helper('logistic')->__('First Name'),
            'index' => 'firstname',
        ));

        $this->addColumn('lastname', array(
            'header' => Mage::helper('logistic')->__('Last Name'),
            'index' => 'lastname',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return false;
    }

    protected function _getSelectedLogistic()
    {
        $logisticId = $this->getSelectedLogistic();
        return $logisticId;
    }


    public function getSelectedLogistic()
    {
        $shippingrateId = $this->getRequest()->getParam('id');
        $currentShippingrate = Mage::getModel('logistic/shippingrate')->load($shippingrateId);
        $logisticId = $currentShippingrate->getLogisticUserId();
        return $logisticId;
    }
}
<?php

class Hxtech_Logistic_Block_Adminhtml_Logistic_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    public function __construct() {
        parent::__construct();
        $this->setId('adminhtml_logistic');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(TRUE);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('is_logistic_user', 1);
        if(Mage::helper('logistic/logistic')->isLogisticUser()){
            $logisticUserId = Mage::helper('logistic/logistic')->getCurrentAdminUserId();
            $collection->addFieldToFilter('user_id', $logisticUserId);
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('user_id', array(
            'header' => Mage::helper('logistic')->__('ID'),
            'index' => 'user_id',
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

        $this->addColumn('is_active', array(
            'header'    => Mage::helper('logistic')->__('Status'),
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array('1' => Mage::helper('logistic')->__('Active'), '0' => Mage::helper('logistic')->__('Inactive')),
        ));
        
        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
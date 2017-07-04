<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Block_Adminhtml_Permissions_Tab_Config_SectionPermissionsGrid
extends Mage_Adminhtml_Block_Widget_Grid
{
    //protected $_gridType = 'config[a]';
    //protected $_paramVarName = 'config';
    protected $_permission = 'config';
    protected $_hiddenFilterVarName = 'af';

    public function __construct()
    {
        parent::__construct();
        $this->setId('confSectionPermissionsGrid');
        $this->setUseAjax(true);
    }

    protected function _construct()
    {
        if ($this->isFirstTimeOpened()) {
            $this->_initRadiosHiddenFilter();
        }

        parent::_construct();
    }

    protected function _prepareLayout()
    {
        $parent = parent::_prepareLayout();
        $this->unsetChild('reset_filter_button');
        return $parent;
    }

    protected function _prepareCollection()
    {
        $items = $this->getSourceConfigSections()->getGridArrayFiltered();
        $collection = new SafeMage_Permissions_Model_Resource_Config_Dummy_Collection();
        $collection->init($items);

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    public function getGridUrl()
    {
        return $this->getUrl('adminhtml/safemage_permissions_ajax/getConfigSectionPermissions', array('_current'=>true));
    }

    public function getPermissions()
    {
        $perm = Mage::registry('current_role')->getPermissions($this->_permission);
        return $perm;
    }

    public function getGridType()
    {
        //return $this->_gridType;
        return $this->getRequestHelper()->getConfigGridType();
    }

    protected function _getRadioRenderer()
    {
        $radioHeader = $this->getLayout()
            ->createBlock('safemage_permissions/Adminhtml_Permissions_Tab_Categories_AttributePermissionsGrid_Radio_Header')
        ;
        $radioRow = $this->getLayout()
            ->createBlock('safemage_permissions/Adminhtml_Permissions_Tab_Categories_AttributePermissionsGrid_Radio_Row')
        ;
        $radio = $this->getLayout()
            ->createBlock('safemage_permissions/Adminhtml_Permissions_Tab_Categories_AttributePermissionsGrid_Radio')
            ->setChild('radio_header', $radioHeader)
            ->setChild('radio_row', $radioRow)
        ;
        return $radio;
    }

    public function getParamVarName()
    {
        //return $this->_paramVarName;
        return $this->getRequestHelper()->getConfigVarName();
    }

    public function getHiddenFilterVarName()
    {
        return $this->_hiddenFilterVarName;
    }

    public function getHiddenColumnName()
    {
        $name = $this->getParamVarName() . '[' . $this->getHiddenFilterVarName() . ']';
        return $name;
    }

    public function getRequestHelper()
    {
        return Mage::helper('safemage_permissions/request');
    }

    public function getRadioHelper()
    {
        return Mage::helper('safemage_permissions/request_radio');
    }

    public function getSourceConfigSections()
    {
        return Mage::getSingleton('safemage_permissions/Source_AccessibleConfigSections');
    }

    public function isFirstTimeOpened()
    {
        $data = $this->getRequest()->getParams();
        $res = !isset($data['filter']);
        return $res;
    }

    protected function _initRadiosHiddenFilter()
    {
        $attributes = $this->getPermissions()->attributesToOptionArrayFiltered();
        $s = $this->getRadioHelper()->encode($attributes);
        if (!isset($this->_defaultFilter[$this->getHiddenColumnName()])) {
            $this->_defaultFilter[$this->getHiddenColumnName()]= $s;
        }
    }

    protected function _updateRadiosHiddenFilter($data)
    {
        if ($s = $data[$this->getParamVarName()][$this->getHiddenFilterVarName()]) {
            $this->getColumn($this->getHiddenColumnName())->getFilter()->setValue($s);
        }
    }

    protected function _setFilterValues($data)
    {
        $parent = parent::_setFilterValues($data);
        $this->_updateRadiosHiddenFilter($data);
        return $parent;
    }

    protected function _prepareColumns()
    {
        $typeEditable = SafeMage_Permissions_Model_Config::PERMISSION_EDITABLE;
        $typeReadonly = SafeMage_Permissions_Model_Config::PERMISSION_READONLY;
        $typeHidden = SafeMage_Permissions_Model_Config::PERMISSION_HIDDEN;

        $parent = parent::_prepareColumns();

        $this->addColumn('is_editable', array(
            'header' => Mage::helper('safemage_permissions')->__('Editable'),
            'index'  => 'permission',
            'filter_index' => 'permission',
            //'filter_index' => new Zend_Db_Expr("IF(main_table.permission = {$typeEditable}, main_table.permission, 0)"),
            'type' => 'options',
            'options' => array(
                $typeEditable => Mage::helper('safemage_permissions')->__('Yes'),
                0 => Mage::helper('safemage_permissions')->__('No'),
            ),
            'align' => 'center',
            'renderer' => $this->_getRadioRenderer()
                ->setPermissionType($typeEditable),
            'width' => '10px',
            'filter_condition_callback' => get_class($this) . '::filterCallback',
        ));
        $this->addColumn('is_readonly', array(
            'header' => Mage::helper('safemage_permissions')->__('Readonly'),
            'index'=>'permission',
            'filter_index'=>'permission',
            //'filter_index' => new Zend_Db_Expr("IF(main_table.permission = {$typeReadonly}, main_table.permission, 0)"),
            'type' => 'options',
            'options' => array(
                $typeReadonly => Mage::helper('safemage_permissions')->__('Yes'),
                0 => Mage::helper('safemage_permissions')->__('No'),
            ),
            'align' => 'center',
            'renderer' => $this->_getRadioRenderer()
                ->setPermissionType($typeReadonly),
            'width' => '10px',
            'filter_condition_callback' => get_class($this) . '::filterCallback',
        ));
        $this->addColumn('is_hidden', array(
            'header' => Mage::helper('safemage_permissions')->__('Hidden'),
            'index'  =>'permission',
            'filter_index'=>'permission',
            //'filter_index' => new Zend_Db_Expr("IF(main_table.permission = {$typeHidden}, main_table.permission, 0)"),
            'type' => 'options',
            'options' => array(
                $typeHidden => Mage::helper('safemage_permissions')->__('Yes'),
                0 => Mage::helper('safemage_permissions')->__('No'),
            ),
            'align' => 'center',
            'renderer' => $this->_getRadioRenderer()
                ->setPermissionType($typeHidden),
            'width' => '10px',
            'filter_condition_callback' => get_class($this) . '::filterCallback',
        ));

        $this->addColumn('cfield', array(
            'header'    => Mage::helper('safemage_permissions')->__('Section'),
            'type'      => 'text',
            'index'     => 'cfield',
            'filter_condition_callback' => get_class($this) . '::filterCallback',
        ));

        $this->addColumn('cgroup', array(
            'header'    => Mage::helper('safemage_permissions')->__('Tab'),
            'type'      => 'text',
            'width'     => '160px',
            'index'     => 'cgroup',
            'filter_condition_callback' => get_class($this) . '::filterCallback',
        ));

        $this->addColumn($this->getHiddenColumnName(), array(
            'type' => 'text',
            'column_css_class' => 'no-display',
            'header_css_class' => 'no-display',
        ));

        return $parent;
    }

    protected function _getRadioFields()
    {
        $a = array(
            'is_editable' => SafeMage_Permissions_Model_Config::PERMISSION_EDITABLE,
            'is_readonly' => SafeMage_Permissions_Model_Config::PERMISSION_READONLY,
            'is_hidden'   => SafeMage_Permissions_Model_Config::PERMISSION_HIDDEN
        );
        return $a;
    }

    protected function _processRadioFilters($column)
    {
        $filter = $this->getRequest()->getParam($this->getVarNameFilter());
        $data = Mage::helper('adminhtml')->prepareFilterString($filter);

        if (isset($data[$column->getId()])) {
            $permission = $data[$column->getId()];
            $inCond = empty($permission);

            $radioFields = $this->_getRadioFields();
            $permissionShouldBe = $radioFields[$column->getId()];

            $attrIds = $this->getRadioHelper()->getAttrWithPermission(
                $data[$this->getParamVarName()][$this->getHiddenFilterVarName()],
                $permissionShouldBe
            );

            foreach($this->getCollection()->getItems() as $key => $item) {
                if ($inCond) {
                    if (in_array($item->getData('attribute_id'), $attrIds)) {
                        $this->getCollection()->removeItemByKey($key);
                    }
                } else {
                    if (!in_array($item->getData('attribute_id'), $attrIds)) {
                        $this->getCollection()->removeItemByKey($key);
                    }
                }
            }
        }
    }

    public function filterCallback($collection, $column)
    {
        $radioFields = $this->_getRadioFields();
        if (in_array($column->getId(), array_keys($radioFields))) {
            $this->_processRadioFilters($column);
            return $this;
        }

        foreach($collection->getItems() as $key => $item) {
            if (!stristr($item->getData($column->getId()), $column->getFilter()->getValue())) {
                $collection->removeItemByKey($key);
            }
        }
    }
}

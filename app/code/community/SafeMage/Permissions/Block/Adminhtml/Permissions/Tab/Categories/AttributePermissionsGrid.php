<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Block_Adminhtml_Permissions_Tab_Categories_AttributePermissionsGrid
    extends Mage_Adminhtml_Block_Catalog_Product_Attribute_Grid
{
    //protected $_gridType = 'categories[a]';
    //protected $_paramVarName = 'categories';
    protected $_permission = 'category';
    protected $_hiddenFilterVarName = 'af';

    protected $_defaultLimit = 100;

    public function __construct()
    {
        parent::__construct();
        $this->setId('categoryAttributePermissionsGrid');
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

    public function getGridType()
    {
        //return $this->getRequestHelper()->getCategoriesVarName() . '[a]';
        return $this->getRequestHelper()->getCategoriesGridType();
    }

    public function getParamVarName()
    {
        return $this->getRequestHelper()->getCategoriesVarName();
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

    public function getPermissions()
    {
        $perm = Mage::registry('current_role')->getPermissions($this->_permission);
        return $perm;
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

    protected function _getMyCollection()
    {
        $collection = Mage::getResourceModel('safemage_permissions/AttributeCollection_Category')
            ->addVisibleFilter()
        ;
        return $collection;
    }

    protected function _prepareCollection()
    {
        $collection = $this->_getMyCollection();
        $this->setCollection($collection);
        $select = $this->getCollection()->getSelect();

        $parent = Mage_Eav_Block_Adminhtml_Attribute_Grid_Abstract::_prepareCollection();
        return $parent;
    }

    public function smRemoveColumn($columnId)
    {
        if (isset($this->_columns[$columnId])) {
            unset($this->_columns[$columnId]);
            if ($this->_lastColumnId == $columnId) {
                $this->_lastColumnId = key($this->_columns);
            }
        }
        return $this;
    }

    protected function _prepareColumns()
    {
        $typeEditable = SafeMage_Permissions_Model_Attribute::PERMISSION_EDITABLE;
        $typeReadonly = SafeMage_Permissions_Model_Attribute::PERMISSION_READONLY;
        $typeHidden = SafeMage_Permissions_Model_Attribute::PERMISSION_HIDDEN;

        $parent = parent::_prepareColumns();

        $this->smRemoveColumn('is_visible');
        $this->smRemoveColumn('is_searchable');
        $this->smRemoveColumn('is_filterable');
        $this->smRemoveColumn('is_comparable');

        $this->addColumn('is_editable', array(
            'header' => Mage::helper('safemage_permissions')->__('Editable'),
            'index' => 'attribute_permission',
            'filter_index' => new Zend_Db_Expr("IF(spa.permission = {$typeEditable}, spa.permission, 0)"),
            'type' => 'options',
            'options' => array(
                $typeEditable => Mage::helper('safemage_permissions')->__('Yes'),
                0 => Mage::helper('safemage_permissions')->__('No'),
            ),
            'align' => 'center',
            'renderer' => $this->_getRadioRenderer()
                ->setPermissionType($typeEditable),
            'width' => '10px',
        ));
        $this->addColumn('is_readonly', array(
            'header' => Mage::helper('safemage_permissions')->__('Readonly'),
            'index'=>'attribute_permission',
            'filter_index' => new Zend_Db_Expr("IF(spa.permission = {$typeReadonly}, spa.permission, 0)"),
            'type' => 'options',
            'options' => array(
                $typeReadonly => Mage::helper('safemage_permissions')->__('Yes'),
                0 => Mage::helper('safemage_permissions')->__('No'),
            ),
            'align' => 'center',
            'renderer' => $this->_getRadioRenderer()
                ->setPermissionType($typeReadonly),
            'width' => '10px',
        ));
        $this->addColumn('is_hidden', array(
            'header' => Mage::helper('safemage_permissions')->__('Hidden'),
            'index' => 'attribute_permission',
            'filter_index' => new Zend_Db_Expr("IF(spa.permission = {$typeHidden}, spa.permission, 0)"),
            'type' => 'options',
            'options' => array(
                $typeHidden => Mage::helper('safemage_permissions')->__('Yes'),
                0 => Mage::helper('safemage_permissions')->__('No'),
            ),
            'align' => 'center',
            'renderer' => $this->_getRadioRenderer()
                ->setPermissionType($typeHidden),
            'width' => '10px',
        ));

        $this->addColumn($this->getHiddenColumnName(), array(
            'type' => 'text',
            'column_css_class' => 'no-display',
            'header_css_class' => 'no-display'
        ));

        $this->addColumnsOrder('is_global', 'is_hidden');
        $this->addColumnsOrder('attribute_code', 'is_global');
        $this->addColumnsOrder('frontend_label', 'attribute_code');
        $this->addColumnsOrder('is_required', 'frontend_label');
        $this->addColumnsOrder('is_user_defined', 'is_required');

        $this->sortColumnsByOrder();

        return $parent;
    }

    public function getGridUrl()
    {
        return $this->getUrl('adminhtml/safemage_permissions_ajax/getCategoryAttributePermissions', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
        return '';
    }

    public function isFirstTimeOpened()
    {
        $data = $this->getRequest()->getParams();
        $res = !isset($data['filter']);
        return $res;
    }

    protected function _initRadiosHiddenFilter()
    {
        $attributes = $this->getPermissions()->attributesToOptionArray();
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

    protected function _getRadioFields()
    {
        $a = array(
            'is_editable' => SafeMage_Permissions_Model_Attribute::PERMISSION_EDITABLE,
            'is_readonly' => SafeMage_Permissions_Model_Attribute::PERMISSION_READONLY,
            'is_hidden'   => SafeMage_Permissions_Model_Attribute::PERMISSION_HIDDEN
        );
        return $a;
    }

    protected function _processRadioFilters($column)
    {
        if (!$this->getCollection()) {
            return $this;
        }

        $filter = $this->getRequest()->getParam($this->getVarNameFilter());
        $data = Mage::helper('adminhtml')->prepareFilterString($filter);

        if (isset($data[$column->getId()])) {
            $permission = $data[$column->getId()];
            $inCond = empty($permission) ? 'nin' : 'in';
            //$permissionShouldBe = $this->_getRadioFields()[$column->getId()];
            $radioFields = $this->_getRadioFields();
            $permissionShouldBe = $radioFields[$column->getId()];


            $attrIds = $this->getRadioHelper()->getAttrWithPermission(
                $data[$this->getParamVarName()][$this->getHiddenFilterVarName()],
                $permissionShouldBe
            );
            $this->getCollection()->addFieldToFilter('main_table.attribute_id', array($inCond => $attrIds));
        }
    }

    protected function _addColumnFilterToCollection($column)
    {
        if (in_array($column->getId(), array_keys($this->_getRadioFields()))) {
            $this->_processRadioFilters($column);
            return $this;
        }

        return parent::_addColumnFilterToCollection($column);
    }
}

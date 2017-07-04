<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Resource_Attribute_Owner extends Mage_Core_Helper_Abstract
{
    const CODE = 'safemage_product_owner';

    public function getCode()
    {
        return self::CODE;
    }

    public function getConfigHelper()
    {
        return Mage::helper('safemage_permissions/config');
    }

    public function getSalesClassHelper()
    {
        return Mage::helper('safemage_permissions/class_sales');
    }

    public function getProductCollectionFix()
    {
        return Mage::getResourceModel('safemage_permissions/Fix_EavEntityCollectionAbstract');
    }

    public function get()
    {
        $attribute = Mage::getModel('catalog/product')->getResource()->getAttribute($this->getCode());
        return $attribute;
    }

    public function add()
    {
        $attribute = $this->get();

        if ( $attribute && $attribute->getId() ) {
            $attribute->setData('is_visible', true);
            $attribute->save();

        } else {
            Mage::getResourceModel('catalog/setup', 'catalog_setup')->addAttribute(
                Mage_Catalog_Model_Product::ENTITY,
                $this->getCode(),
                array(
                    'group'         => 'General',
                    'type'          => 'text',
                    'frontend'      => '',
                    'label'         => Mage::helper('safemage_permissions')->__('Product Owners'),
                    'input'         => 'multiselect',
                    'class'         => '',
                    'source'        => 'safemage_permissions/source_owner',
                    'backend'       => 'safemage_permissions/backend_owner',
                    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    'visible'       => true,
                    'required'      => false,
                    'user_defined'  => false,
                    'default'       => '0',
                    'searchable'        => false,
                    'filterable'        => false,
                    'comparable'        => false,
                    'visible_on_front'  => false,
                    'unique'            => false,
                    'apply_to'          => 'simple,configurable,virtual,downloadable',
                    'is_configurable'  => true,
                    'visible_on_front' => false,
                    'sort_order'       => 100
                )
            );
        }
    }

    public function hide()
    {
        $attribute = $this->get();
        if ($attribute && $attribute->getId()) {
            $attribute->setData('is_visible', false);
            $attribute->save();
        }
    }

    protected function _getAdminsCollection()
    {
        $collection = Mage::getResourceModel('admin/user_collection')
            ->addFieldToFilter('is_active', array('eq' => 1))
        ;
        return $collection;
    }

    public function getAdminsAsSourceOptions()
    {
        $collection = $this->_getAdminsCollection();

        $admins = array();
        foreach($collection as $admin) {
            $admins[]= array(
                'label' => Mage::helper('safemage_permissions')->__(
                    '%s (%s %s)', $admin->getUsername(), $admin->getFirstname(), $admin->getLastname()
                ),
                'value' => $admin->getUserId(),
            );
        }

        return $admins;
    }

    public function getOwnedProductsCollection($admin)
    {
        $uId = $admin->getUserId();
        $collection = Mage::getResourceModel('catalog/product_collection')
          ->addAttributeToSelect('*')
        ;

        //if ($this->getConfigHelper()->isOwnerEnabled()) {
            $collection
                ->joinAttribute('safemage_product_owner', 'catalog_product/safemage_product_owner', 'entity_id', null, 'inner')
            ;
            $ownerAlias = $this->getProductCollectionFix()->fixGetAttributeTableAlias('safemage_product_owner');
            $collection->getSelect()
                ->where("{$ownerAlias}.value REGEXP ?", "(^$uId$)|(^$uId,)|(,$uId,)|(,$uId$)")
            ;
        //}

        return $collection;
    }

    public function filterOwnedSalesData($admin, $collection)
    {
        $products = $this->getOwnedProductsCollection($admin);
        $selectProducts = $products->getSelect()
            ->reset(Zend_Db_Select::COLUMNS)
            ->columns(array('product_id' => 'e.entity_id'))
        ;

        $orderItems = Mage::getResourceModel('sales/order_item_collection');
        $selectOrderItems = $orderItems->getSelect()
            ->reset(Zend_Db_Select::COLUMNS)
            ->columns(array('order_id' => 'main_table.order_id'))
            ->join(
                array('op' => new Zend_Db_Expr( '(' . $selectProducts->__toString() . ')' )),
                "op.product_id = main_table.product_id",
                array()
            )
            ->group('main_table.order_id')
        ;

        $select = $collection->getSelect();

        if ($this->getSalesClassHelper()->isOrderGridCollection($collection)) {
            $select->join(
                array('soi' => new Zend_Db_Expr( '(' . $selectOrderItems->__toString() . ')' )),
                "main_table.entity_id = soi.order_id",
                array()
            );
        }
        if ( $this->getSalesClassHelper()->isInvoiceGridCollection($collection)
          || $this->getSalesClassHelper()->isTransactionCollection($collection)
          || $this->getSalesClassHelper()->isShipmentGridCollection($collection)
          || $this->getSalesClassHelper()->isCreditmemoCollection($collection)
        ) {
            $select->join(
                array('soi' => new Zend_Db_Expr( '(' . $selectOrderItems->__toString() . ')' )),
                "main_table.order_id = soi.order_id",
                array()
            );

            // Order View
            $partWhere = $select->getPart(Zend_Db_Select::WHERE);
            foreach($partWhere as $i => &$value) {
                //$value = str_replace(array('`', ' '), array('', ''), $value);
                //$value = str_replace('(order_id=', '(main_table.order_id=', $value);
                $value = str_replace(array('`'), array(''), $value);
                $value = str_replace('(order_id =', '(main_table.order_id=', $value);
            }
            $select->setPart(Zend_Db_Select::WHERE, $partWhere);
        }
    }

    public function getOwnedProductIds($admin)
    {
        $collection = $this->getOwnedProductsCollection($admin);
        $ids = $collection->getAllIds();

        return $ids;
    }

    public function removeOwnedProductIds($admin)
    {
        $collection = $this->getOwnedProductsCollection($admin);
        foreach($collection as $product) {
            $sOwners = $product->getData($this->getCode());
            $sOwners = Mage::helper('safemage_permissions/string')->removeOwner($sOwners, $admin->getUserId());
            $product->setData($this->getCode(), $sOwners);
            $product->getResource()->saveAttribute($product, $this->getCode());
        }
    }

    public function getOwnedProductsByGridCheckboxes($productIds)
    {
        $collection = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect($this->getCode())
            ->addFieldToFilter('entity_id', array('in' => $productIds))
        ;
        return $collection;
    }

    public function addOwnedProductIds($admin, $productIds)
    {
        $collection = $this->getOwnedProductsByGridCheckboxes($productIds);

        foreach($collection as $product) {
            $sOwners = $product->getData($this->getCode());
            $sOwners = Mage::helper('safemage_permissions/string')->addOwner($sOwners, $admin->getUserId());
            $product->setData($this->getCode(), $sOwners);
            $product->getResource()->saveAttribute($product, $this->getCode());
        }
    }

    public function updateOwnedProductIds($admin, $productIds)
    {
        $this->removeOwnedProductIds($admin);
        $this->addOwnedProductIds($admin, $productIds);
    }
}

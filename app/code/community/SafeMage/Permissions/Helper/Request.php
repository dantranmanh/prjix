<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Helper_Request extends Mage_Core_Helper_Abstract
{
    const USER_OWNED_PRODUCTS_VAR_NAME    = 'user_owned_products';
    //const ROLE_SELECTED_PRODUCTS_VAR_NAME = 'products[ids]';

    public function getProductsVarName()
    {
        //return 'products';
        return 'u';
    }

    public function getProductsGridType()
    {
        return 'j';
    }

    public function getCategoriesVarName()
    {
        //return 'categories';
        return 'v';
    }

    public function getCategoriesGridType()
    {
        return 'h';
    }

    public function getCustomersVarName()
    {
        //return 'customers';
        return 'w';
    }

    public function getCustomersGridType()
    {
        return 'i';
    }

    public function getConfigVarName()
    {
        //return 'customers';
        return 'y';
    }

    public function getConfigGridType()
    {
        return 'z';
    }

    public function getUserOwnedProductsVarName()
    {
        return self::USER_OWNED_PRODUCTS_VAR_NAME;
    }

    public function getRoleSelectedProductsVarName()
    {
        //return self::ROLE_SELECTED_PRODUCTS_VAR_NAME;
        return $this->getProductsVarName() . '[ids]';
    }

    public function toRequestParams($data)
    {
        $names = array(
            $this->getProductsVarName() . '[category_ids]',
            $this->getProductsVarName() . '[store_ids]',

            $this->getCategoriesVarName() . '[ids]',
            $this->getCategoriesVarName() . '[store_ids]',
        );
        foreach($names as $name) {
            if (isset($data[$name])) {
                $data[$name . '[]'] = $data[$name];
                unset($data[$name]);
            }
        }
        return Zend_Json::encode($data);
    }

    public function fromRequestParams($data)
    {
        $names = array(
            $this->getProductsVarName() . '[category_ids]',
            $this->getProductsVarName() . '[store_ids]',

            $this->getCategoriesVarName() . '[ids]',
            $this->getCategoriesVarName() . '[store_ids]',
        );
        foreach($names as $name) {
            $parts = explode('[', rtrim($name, ']'));
            $name1 = $parts[0];
            $name2 = $parts[1];

            if (isset($data[$name1][$name2])) {
                $data[$name]= $data[$name1][$name2];
                unset($data[$name1][$name2]);
            }
        }

        return $data;
    }

    public function getAllStoresSelected($value)
    {
        $allSelected = in_array(0, $value);
        return $allSelected;
    }
}
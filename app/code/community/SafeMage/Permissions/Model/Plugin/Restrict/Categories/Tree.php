<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Plugin_Restrict_Categories_Tree
    extends SafeMage_Permissions_Model_Plugin_Restrict_Categories_Block
{
    /**
     * Tree helper
     *
     * @return SafeMage_Permissions_Helper_Tree
     */
    public function getTreeHelper()
    {
        return Mage::helper('safemage_permissions/tree');
    }

    /**
     * Hide some items of Category Tree (AJAX)
     *
     * @param Mage_Adminhtml_Block_Catalog_Category_Tree $object
     * @param array $result
     * @param array $arguments
     * @return array
     */
    public function afterGetTree($object, $result, array &$arguments)
    {
        if ($this->_detect($object)) {
            if ($perm = $this->getPermissions()) {
                if ($perm->isSelectedAllowed()) {
                    $children = $result;
                    if (is_array($children)) {
                        if (count($children)) {
                            $this->getTreeHelper()->restrictArray($children, $perm->getIds());
                            return $children;
                        }
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Hide some items of Category Tree
     *
     * @param Mage_Adminhtml_Block_Catalog_Category_Tree $object
     * @param string $result
     * @param array $arguments
     * @return string $result
     */
    public function afterGetTreeJson($object, $result, array &$arguments)
    {
        if ($this->_detect($object)) {
            if ($perm = $this->getPermissions()) {
                if ($perm->isSelectedAllowed()) {
                    $a = Mage::helper('core')->jsonDecode($result);
                    $this->getTreeHelper()->restrictArray($a, $perm->getIds());
                    $result = Mage::helper('core')->jsonEncode($a);
                }
            }
        }

        return $result;
    }

    /**
     * Detect if this Block should be processed
     *
     * @param Mage_Adminhtml_Block_Catalog_Category_Tree $object
     * @return bool
     */
    protected function _detect($object)
    {
        $res = $this->getCategoriesClassHelper()->isCatalogCategoryTree($object);
        return $res;
    }
}

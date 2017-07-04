<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Plugin_Restrict_Categories_EavEntity
    extends SafeMage_Permissions_Model_Plugin_Restrict_EavEntity
{
    /**
     * Hide errors for readonly and hidden attributes
     *
     * @param array $result
     */
    public function correctErrors(&$result)
    {
        if (count($result)) {
            foreach($result as $attrCode => $isError) {
                if ($this->getPermissions()->isAttributeByCodeReadonly($attrCode)
                 || $this->getPermissions()->isAttributeByCodeHidden($attrCode)
                 || $this->getPermissions()->isAttributeByCodeInHiddenGroup($attrCode)) {
                    unset($result[$attrCode]);
                }
            }
        }
    }

    /**
     * Category Permissions of current admin
     *
     * @return SafeMage_Permissions_Model_Abstract
     */
    public function getPermissions()
    {
        $perm = $this->getSession()->getPermissions('category');
        return $perm;
    }

    /**
     * Detect if this Resource should be processed
     *
     * @param Mage_Catalog_Model_Resource_Category $object
     * @return bool
     */
    protected function _detect($object)
    {
        $res = $this->getCategoriesClassHelper()->isCatalogCategoryResource($object);
        return $res;
    }
}

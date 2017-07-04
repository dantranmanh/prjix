<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Block_Adminhtml_Fix_CatalogCategoryEdit
    extends SafeMage_Permissions_Block_Adminhtml_Fix_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('safemage/permissions/fix/catalog-category-edit.phtml');
    }
}

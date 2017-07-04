<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Resource_Restrict_Customers
    extends SafeMage_Permissions_Model_Resource_Restrict_Abstract
{
    public function customerManageCollection($collection, SafeMage_Permissions_Model_Customer $perm)
    {
        if (count($perm->getWebsiteIds()) > 0) {
            $collection->getSelect()->where('e.website_id IN (?)', $perm->getWebsiteIds());
        }
    }
}
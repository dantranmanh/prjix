<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Helper_Collection extends Mage_Core_Helper_Abstract
{
    public function toOptionArray($collection, $valueField, $labelField)
    {
        $a = array();
        foreach($collection as $item) {
            $a[$item->getData($valueField)]= $item->getData($labelField);
        }
        return $a;
    }
}
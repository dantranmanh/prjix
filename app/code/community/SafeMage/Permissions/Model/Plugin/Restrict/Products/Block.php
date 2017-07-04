<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

abstract class SafeMage_Permissions_Model_Plugin_Restrict_Products_Block
    extends SafeMage_Permissions_Model_Plugin_Restrict_Products_Abstract
{
    /**
     * Detect if this Block should be processed
     *
     * @param Mage_Core_Block_Abstract
     * @return bool
     */
    abstract protected function _detect($object);
}

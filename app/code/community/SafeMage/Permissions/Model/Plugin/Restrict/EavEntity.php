<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/


abstract class SafeMage_Permissions_Model_Plugin_Restrict_EavEntity
    extends SafeMage_Permissions_Model_Plugin_Restrict_Abstract
{
    /**
     * Hide errors for readonly and hidden attributes
     *
     * @param array $result
     */
    abstract public function correctErrors(&$result);

    /**
     * Detect if this Resource should be processed
     *
     * @param Mage_Eav_Model_Entity_Abstract $object
     * @return bool
     */
    abstract protected function _detect($object);

    /**
     * Hide errors for readonly and hidden attributes
     *
     * @param Mage_Eav_Model_Entity_Abstract $object
     * @param array $result
     * @param array $arguments
     * @return array
     */
    public function afterValidate($object, $result, array &$arguments)
    {
        if ($this->canRun()) {
            if ($this->_detect($object)) {
                $this->correctErrors($result);
            }
        }

        return $result;
    }
}

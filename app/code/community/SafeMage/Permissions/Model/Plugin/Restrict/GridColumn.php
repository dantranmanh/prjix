<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

abstract class SafeMage_Permissions_Model_Plugin_Restrict_GridColumn
extends SafeMage_Permissions_Model_Plugin_Restrict_Block
{
    /**
     * Modify Grid Column
     *
     * @param array $column
     */
    abstract protected function _update($column);

    /**
     * Detect if this Grid Column should be processed
     *
     * @param int $columnId
     * @return bool
     */
    abstract protected function _detectId($columnId);

    /**
     * Modify Grid Column if need
     *
     * @param Mage_Adminhtml_Block_Widget_Grid $object
     * @param Mage_Adminhtml_Block_Widget_Grid $result
     * @param array $arguments
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    public function afterAddColumn($object, $result, array &$arguments)
    {
        if ($this->_detect($object) && $this->canRun()) {
            if (isset($arguments[0]) && isset($arguments[1])) {
                $columnId = $arguments[0];
                $data = $arguments[1];

                if ($this->_detectId($columnId)) {
                    $column = $object->getColumn($columnId);
                    $this->_update($column);
                }
            }
        }

        return $result;
    }
}

<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Resource_Config_Dummy_Collection
extends Varien_Data_Collection
{
    public function init($items)
    {
        foreach($items as $item) {
            $this->addItem(new Varien_Object($item));
        }
    }

    public function cmp($a, $b)
    {
        if (count($this->_orders)) {
            $columnId = current(array_keys($this->_orders));
            $order = stristr($this->_orders[$columnId], 'asc') ? 1 : -1;
            $res = $order * strcmp($a->getData($columnId), $b->getData($columnId));
            return $res;
        }

        return 0;
    }

    protected function _doSort(&$items)
    {
        usort($items, get_class($this) . '::cmp');
        return $this;
    }

    public function getIterator()
    {
        $items = $this->_items;
        $this->_doSort($items);

        $offset = ($this->_curPage - 1) * $this->_pageSize;
        $items = array_slice($items, $offset, $this->_pageSize);

        return new ArrayIterator($items);
    }
}

<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Helper_Tree extends Mage_Core_Helper_Abstract
{
    public function setAscNumArrayKeys(&$a)
    {
        $newA = array();
        if (count($a) > 0) {
            foreach($a as $key => $data) {
                $newA[]= $data;
            }
            $a = $newA;
        }
    }

    protected function _isCategoryAllowed($id, $idsAllowed)
    {
        $res = in_array($id, $idsAllowed);
        return $res;
    }

    public function restrictArray(&$a, $idsAllowed)
    {
        if (count($a)) {
            foreach($a as $key => &$node) {
                if (!$this->_isCategoryAllowed($node['id'], $idsAllowed)) {
                    unset($a[$key]);
                    continue;
                }
                if (isset($node['children'])) {
                    $this->restrictArray($node['children'], $idsAllowed);
                }
            }
            $this->setAscNumArrayKeys($a);
        }
    }
}
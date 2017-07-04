<?php

class Hxtech_Logistic_Helper_Port extends Mage_Core_Helper_Abstract
{
    public function getClosestPortHtml($collection, $currentClosestPort)
    {
        $html = '';
        $html .= '<option value=""></option>';

        foreach($collection as $item){
            $selected = ($item->getPort() == $currentClosestPort) ? 'selected = "selected"' : '';
            $html .= '<option'.$selected.' value="'.$item->getPort().'">'.$item->getPort().'</option>';
        }

        return $html;
    }
}
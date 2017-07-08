<?php

class Otnegam_Amastycustom_Helper_Data extends Amasty_Shopby_Helper_Cached
{
    public function addCurrentUrlParam($param = null)
    {
        $url = Mage::helper('core/url')->getCurrentUrl();
        if (empty($param)) return $url;
        $hasParam = strpos($url, "?");
        if ($hasParam === false) {
            $url = $url . "?" . $param;
        } else {
            $amf = Mage::app()->getRequest()->getParam('amf');
            if (!empty($amf)) {
                $url = str_replace("amf=" . $amf, $param, $url);
            } else
                $url = $url . "&" . $param;
        }
        return $url;
    }
    public function getCurrentExtraTabs()
    {
        $tab="all";
        $filter=strtolower(Mage::app()->getRequest()->getParam('amf'));
        if(!empty($filter)) $tab=$filter;
        return $tab;
    }
    public function isExtraTabsRunning()
    {
        $filter=strtolower(Mage::app()->getRequest()->getParam('amf'));
        if(!empty($filter)) return true;
        return false;
    }
}

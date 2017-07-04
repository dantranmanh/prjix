<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Block_Adminhtml_Form_CustomField extends Varien_Data_Form_Element_Abstract
{
    public function getLabelHtml($idSuffix = '')
    {
        $html = '';
        if (!$this->getLabelBlock()) {
            return parent::getLabelHtml($idSuffix);
        }

        $html = $this->getLabelBlock()->toHtml();
        return $html;
    }

    public function getElementHtml()
    {
        $html = '';
        if ($this->getValueBlock()) {
            $html = $this->getValueBlock()->toHtml();
        }

        return $html;
    }
}

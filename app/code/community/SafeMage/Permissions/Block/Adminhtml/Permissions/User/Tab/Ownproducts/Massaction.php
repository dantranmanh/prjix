<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Block_Adminhtml_Permissions_User_Tab_Ownproducts_Massaction
    extends Mage_Adminhtml_Block_Widget_Grid_Massaction
{
    public function getJavaScript()
    {
        $js = "  {$this->getJsObjectName()} = new varienGridMassaction('{$this->getHtmlId()}', "
        . "{$this->getGridJsObjectName()}, '{$this->getSelectedJson()}'"
        . ", '{$this->getFormFieldNameInternal()}', '{$this->getFormFieldName()}');"
        . "{$this->getJsObjectName()}.setItems({$this->getItemsJson()}); "
        . "{$this->getJsObjectName()}.setGridIds('{$this->getGridIdsJson()}');"
        . ($this->getUseAjax() ? "{$this->getJsObjectName()}.setUseAjax(true);" : '')
        . ($this->getUseSelectAll() ? "{$this->getJsObjectName()}.setUseSelectAll(true);" : '')
        . "{$this->getJsObjectName()}.errorText = '{$this->getErrorText()}';";

        return $js;
    }

    public function getSelectedJson()
    {
        if ($this->getMySelectedProducts()) {
            return join(',', $this->getMySelectedProducts());
        }

        if ($selected = $this->getRequest()->getParam($this->getFormFieldNameInternal())) {
            $selected = explode(',', $selected);
            return join(',', $selected);
        } else {
            return '';
        }
    }
}

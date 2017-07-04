<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Block_Adminhtml_Permissions_Tab_Categories_AttributePermissionsGrid_Radio
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function getMyHelper()
    {
        return Mage::helper('safemage_permissions/request_radio');
    }

    public function getMyGrid()
    {
        return $this->getColumn()->getGrid();
    }

    public function getRadioSelector()
    {
        $type = $this->getPermissionType();
        $id = $this->getMyGrid()->getId();

        $radioSelector = "#{$id} .radio-attr-permission-{$type}";
        return $radioSelector;
    }

    public function getHiddenIds()
    {
        // CE 1.5 compatibility
        $hiddenId = $this->getMyGrid()->getId() . '_filter_' . $this->getMyGrid()->getHiddenColumnName();
        $hiddenId2 = 'filter_' . $this->getMyGrid()->getHiddenColumnName();

        return array($hiddenId, $hiddenId2);
    }

    public function getHiddenIdsStr()
    {
        $s = implode(',', $this->getHiddenIds());
        return $s;
    }

    public function renderHeader()
    {
        return $this->getChild('radio_header')->toHtml() . $this->getColumn()->getHeader();
    }

    public function render(Varien_Object $row)
    {
        $gridType = $this->getMyGrid()->getGridType();
        $hiddenColumnVarName = $this->getMyGrid()->getHiddenColumnName();

        $dbAttributePermission = $this->_getValue($row);
        $attributeId = $row->getData('attribute_id');

        $filterHidden = $this->getMyGrid()->getColumn($hiddenColumnVarName)->getFilter()->getValue();
        $filtAttributePermission = $this->getMyHelper()->getAttrPermission($filterHidden, $attributeId);

        // From database
        $checked = (($dbAttributePermission == $this->getPermissionType())) ? 'checked="checked"' : '';
        // From filter
        $checked = (($filtAttributePermission == $this->getPermissionType())) ? 'checked="checked"' : '';

        $radioRowHtml = $this
            ->getChild('radio_row')
            ->addData(array(
                'radio_name' => "{$gridType}[{$attributeId}]",
                'radio_value' => $this->getPermissionType(),
                'checked' => $checked,
            ))
            ->toHtml()
        ;

        return $radioRowHtml;
    }
}

<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Extensions_Block_Adminhtml_System_Extension_List extends Mage_Adminhtml_Block_Template
{
    public function getExtensionList()
    {
        return Mage::helper('safemage_extensions')->getModuleConfigList();
    }

    public function getExtensionName($config, $code = '')
    {
        return (string) ($config->extension_name ? $config->extension_name : $code);
    }

    public function getExtensionVersion($config)
    {
        return (string) $config->version;
    }

    public function getExtensionUrl($config)
    {
        if (!$config->url) {
            return '';
        }
        return 'https://www.safemage.com/' . $config->url . '.html';
    }

    public function getImageUrl($code)
    {
        return 'https://www.safemage.com/cache/'
            . Mage::helper('safemage_extensions')->getCacheKey()
            . '/' . strtolower($code) . '.jpg';
    }

    public function getEnableSelectHtml($config, $code = '')
    {
        $select = $this->getLayout()->createBlock('adminhtml/html_select')
            ->setData(array(
                'id' => 'safemage_extensions_' . $code . '_enabled',
                'class' => 'select safemage-extension-enabled-select'
            ))
            ->setName('groups[extension][fields][enabled][' . $code . ']')
            ->setOptions(Mage::getModel('safemage_extensions/system_config_source_enabled')->toOptionArray())
            ->setValue($config->is('active', 'true'));

        return $select->getHtml();
    }
}

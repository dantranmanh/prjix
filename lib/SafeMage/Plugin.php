<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Plugin extends Varien_Autoload
{
    const TYPE_BEFORE = 'before';
    const TYPE_AROUND = 'around';
    const TYPE_AFTER = 'after';

    /**
     * SafeMage_Plugin constructor.
     * @param $arg
     */
    public function __construct($arg)
    {
        spl_autoload_register(array(__CLASS__, 'autoload'), true, true);
    }

    /**
     * Attempt to load the given class.
     *
     * @param string $className
     * @return void
     */
    public function autoload($className)
    {
        if ($this->isPluginClass($className)) {
            include SafeMage_Plugin_File::getDir() . $className . '.php';
        }
    }

    /**
     * @param $className string
     * @return bool
     */
    public function isPluginClass($className)
    {
        if (substr($className, -8) == '_Plugged') {
            return true;
        }
        return false;
    }

    /**
     * @param $className string
     * @return string
     */
    public function getPluginClassName($className)
    {
        return $className . '_Plugged';
    }

    /**
     * @param $className string
     * @param $data Mage_Core_Model_Config_Element
     * @return string
     */
    public function addPlugins($className, $data)
    {
        $pluginClassName = $this->getPluginClassName($className);

        // class file in cache
        if (Mage::app()->useCache('config') && Mage::getSingleton('SafeMage_Plugin_File')->isExist($pluginClassName)) {
            return $pluginClassName;
        }

        // collect active plugins
        $plugins = array();
        foreach ($data->children() as $plugin) {
            $method = (string)$plugin->method;
            $type = (string)$plugin->type;
            if ($method && $type && (string)$plugin->run && !(int)$plugin->disabled) {
                $plugins[$method][$type][] = $plugin;
            }
        }

        if (!$plugins) {
            return $className;
        }

        $pluginRenderer = Mage::getSingleton('SafeMage_Plugin_Renderer');
        $pluginRenderer->init($className);

        foreach($plugins as $method => $methodPlugins) {
            try {
                $methodPlugins = $this->_sort($methodPlugins);
                $pluginRenderer->addPluginsForMethod($method, $methodPlugins);
            } catch (Exception $e) {
                $this->_log($e->getMessage());
            }
        }

        try {
            $pluginRenderer->createClass($pluginClassName);
            return $pluginClassName;
        } catch (Exception $e) {
            $this->_log($e->getMessage());
        }

        return $className;
    }

    protected function _sort($plugins)
    {
        foreach($plugins as $type => &$pluginsArray) {
            usort($pluginsArray, array($this, '_sortByOrder'));
        }
        return $plugins;
    }

    protected function _sortByOrder(Mage_Core_Model_Config_Element $plugin1, Mage_Core_Model_Config_Element $plugin2)
    {
        return (intval($plugin1->sort_order) > intval($plugin2->sort_order)) ? true : false;
    }

    protected function _log($message)
    {
        Mage::log($message, null, 'plugins.log');
    }
}

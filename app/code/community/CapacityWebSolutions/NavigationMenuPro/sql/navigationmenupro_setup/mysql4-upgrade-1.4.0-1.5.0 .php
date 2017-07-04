<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
$installer = $this;
$installer->startSetup();
$installer->run("ALTER TABLE `{$this->getTable('menucreatorgroup')}` ADD `rootoptions` text DEFAULT NULL COMMENT 'Rootoptions'");
$installer->run("ALTER TABLE `{$this->getTable('menucreatorgroup')}` ADD `mobilemenuoptions` text DEFAULT NULL COMMENT 'Mobilemenuoptions'");
$installer->run("ALTER TABLE `{$this->getTable('menucreatorgroup')}` ADD `megaoptions` text DEFAULT NULL COMMENT 'Megaoptions'");
$installer->run("ALTER TABLE `{$this->getTable('menucreatorgroup')}` ADD `suboptions` text DEFAULT NULL COMMENT 'Suboptions'");
$installer->run("ALTER TABLE `{$this->getTable('menucreatorgroup')}` ADD `flyoptions` text DEFAULT NULL COMMENT 'Flyoptions'");
$installer->run("ALTER TABLE `{$this->getTable('menucreator')}` ADD `show_custom_category_image` smallint(6) COMMENT 'Show Custom Category Image'");
$installer->run("ALTER TABLE `{$this->getTable('menucreator')}` ADD `label_show_hide` varchar(255) DEFAULT NULL COMMENT 'Label Show Hide'");
$installer->run("ALTER TABLE `{$this->getTable('menucreator')}` ADD `label_title` varchar(255) DEFAULT NULL COMMENT 'Label Title'");
$installer->run("ALTER TABLE `{$this->getTable('menucreator')}` ADD `label_height` smallint(6) DEFAULT NULL COMMENT 'Label Height'");
$installer->run("ALTER TABLE `{$this->getTable('menucreator')}` ADD `label_width` smallint(6) DEFAULT NULL COMMENT 'Label Width'");
$installer->run("ALTER TABLE `{$this->getTable('menucreator')}` ADD `label_bg_color` varchar(255) DEFAULT NULL COMMENT 'Label Bg Color'");
$installer->run("ALTER TABLE `{$this->getTable('menucreator')}` ADD `label_color` varchar(255) DEFAULT NULL COMMENT 'Label Color'");
$installer->endSetup(); 

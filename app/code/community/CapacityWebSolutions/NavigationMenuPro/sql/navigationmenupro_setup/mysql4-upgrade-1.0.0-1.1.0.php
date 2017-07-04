<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
$installer = $this;
$installer->startSetup();
$installer->run("ALTER TABLE `{$this->getTable('menucreator')}` ADD `useexternalurl` varchar(255) DEFAULT NULL COMMENT 'UseExternalUrl'");
$installer->run("ALTER TABLE `{$this->getTable('menucreator')}` ADD `setrel` varchar(255) DEFAULT NULL COMMENT 'Setrel'");
$installer->endSetup(); 



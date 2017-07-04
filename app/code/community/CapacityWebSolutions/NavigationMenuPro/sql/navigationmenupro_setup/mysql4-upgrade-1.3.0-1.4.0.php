<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
$installer = $this;
$installer->startSetup();
if(in_array($this->getTable('permission_block'),$installer->getConnection()->listTables()))
{
		//$installer->run("INSERT INTO {$this->getTable('permission_block')} (block_name,is_allowed) values ('navigationmenupro/menucreator','1')");
		$installer->run("INSERT INTO {$this->getTable('permission_block')} (block_name,is_allowed) values ('navigationmenupro/menucreator','1')");
}
$installer->endSetup(); 

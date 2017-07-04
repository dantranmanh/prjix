<?php
$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE `admin_user` ADD `description` TEXT DEFAULT '' ;
");

$installer->endSetup();
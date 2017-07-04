<?php
$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE `admin_user` ADD `logistic_logo` VARCHAR(255) DEFAULT '' ;
");

$installer->endSetup();
<?php

$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE `admin_user` ADD `commission_status` SMALLINT(6) DEFAULT 1;
");

$installer->endSetup();
<?php

$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE `importer_commission_config` ADD `commission_status` SMALLINT(6) DEFAULT 1;
");

$installer->endSetup();
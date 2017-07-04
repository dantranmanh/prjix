<?php

$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE `forex_financier` ADD `exclude_countries` TEXT NOT NULL DEFAULT '' ;
");

$installer->endSetup();
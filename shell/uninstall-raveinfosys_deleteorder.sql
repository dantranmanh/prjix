DELETE FROM core_config_data WHERE `path` LIKE '%deleteorder%';
DELETE FROM core_resource WHERE code = 'deleteorder_setup';
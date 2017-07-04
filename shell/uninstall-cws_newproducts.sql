DROP TABLE IF EXISTS cws_newproducts;
DELETE FROM permission_block WHERE block_name = 'newproducts/newproducts';
DELETE FROM core_config_data WHERE `path` LIKE '%CapacityWebSolutions_Newproducts%';
DELETE FROM core_config_data WHERE `path` LIKE '%newproducts%';
DELETE FROM core_resource WHERE code = 'newproducts_setup';
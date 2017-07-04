DROP TABLE IF EXISTS bestseller;
DELETE FROM permission_block WHERE block_name = 'bestseller/bestseller';
DELETE FROM core_config_data WHERE `path` LIKE '%CapacityWebSolutions_Bestseller%';
DELETE FROM core_config_data WHERE `path` LIKE '%bestseller%';
DELETE FROM core_resource WHERE code = 'bestseller_setup';
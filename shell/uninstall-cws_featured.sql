DROP TABLE IF EXISTS cws_featured_products;
DELETE FROM permission_block WHERE block_name = 'featured/featured';
DELETE FROM core_config_data WHERE `path` LIKE '%CapacityWebSolutions_Featured%';
DELETE FROM core_config_data WHERE `path` LIKE '%featured%';
DELETE FROM core_resource WHERE code = 'featured_setup';
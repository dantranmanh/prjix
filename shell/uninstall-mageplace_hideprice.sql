DELETE FROM core_config_data WHERE `path` LIKE '%Mageplace_Hideprice%';
DELETE FROM core_config_data WHERE `path` LIKE '%hideprice%';
DELETE FROM core_config_data WHERE `path` LIKE '%hide_price%';
DELETE FROM core_resource WHERE code = 'hideprice_setup';
DROP TABLE IF EXISTS hideprice_store_table;
DROP TABLE IF EXISTS hideprice_table;
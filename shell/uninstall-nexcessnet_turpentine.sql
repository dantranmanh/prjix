DELETE FROM core_cache_option WHERE code = 'turpentine_esi_blocks';
DELETE FROM core_cache_option WHERE code = 'turpentine_pages';
DELETE FROM core_config_data WHERE `path` LIKE '%turpentine%';
DELETE FROM core_config_data WHERE `path` LIKE '%Nexcessnet_Turpentine%';
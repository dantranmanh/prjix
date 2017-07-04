DROP TABLE IF EXISTS jmmegamenu;
DROP TABLE IF EXISTS jmmegamenu_store_menugroup;
DROP TABLE IF EXISTS jmmegamenu_types;
DELETE FROM core_config_data WHERE `path` LIKE '%jmmegamenu%';
DELETE FROM core_resource WHERE code = 'jmmegamenu_setup';
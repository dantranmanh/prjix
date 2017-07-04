DROP TABLE IF EXISTS manageteam;
DELETE FROM core_config_data WHERE `path` LIKE '%manageteam%';
DELETE FROM core_resource WHERE code = 'manageteam_setup';
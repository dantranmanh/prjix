DELETE FROM core_config_data WHERE `path` LIKE '%smtppro%';
DELETE FROM core_resource WHERE code = 'smtppro_setup';
DROP TABLE IF EXISTS smtppro_email_log;
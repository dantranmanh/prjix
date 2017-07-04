DELETE FROM core_config_data WHERE `path` LIKE '%MDN_SmartReport%';
DELETE FROM core_config_data WHERE `path` LIKE '%smartreport%';
DELETE FROM core_resource WHERE code = 'SmartReport_setup';
DROP TABLE IF EXISTS smart_report_report;
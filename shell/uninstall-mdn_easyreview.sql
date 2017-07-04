DELETE FROM core_config_data WHERE `path` LIKE '%MDN_EasyReview%';
DELETE FROM core_config_data WHERE `path` LIKE '%easyreview%';
DELETE FROM core_resource WHERE code = 'EasyReview_setup';
ALTER TABLE sales_flat_order DROP COLUMN easyreview_notified;
ALTER TABLE sales_flat_order DROP COLUMN easyreview_hashcode;
ALTER TABLE sales_flat_order DROP COLUMN easyreview_date;
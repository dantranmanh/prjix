TRUNCATE adminnotification_inbox;
TRUNCATE amasty_amfpccrawler_log;
TRUNCATE amasty_amoptimization_task;
TRUNCATE amasty_amsmtp_log;
TRUNCATE cron_schedule;
DELETE FROM index_event;
ALTER TABLE `index_event` auto_increment = 1;
TRUNCATE log_url_info;
TRUNCATE log_visitor_info;
TRUNCATE smtppro_email_log;
DELETE FROM core_email_queue;
TRUNCATE amasty_amfpc_url;
TRUNCATE amasty_amfpccrawler_queue;
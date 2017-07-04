# M1 Website for ixport.com

Version: 1.9.3.2

## Info

This readme will be used for all site related info regarding setup, updates, etc.

## Crontab:

```sh
sudo crontab -u www-data -e
```

## Crontab setup default:

```sh
MAILTO="tech@ixport.com"
*/1 * * * *   /bin/sh /PATH/TO/MAGENTO/cron.sh cron.php 2>&1
```

## Crontab setup AOE Scheduler:

```sh
MAILTO="tech@ixport.com"
* * * * * ! test -e /PATH/TO/MAGENTO/maintenance.flag && /bin/bash /PATH/TO/MAGENTO/scheduler_cron.sh --mode always
* * * * * ! test -e /PATH/TO/MAGENTO/maintenance.flag && /bin/bash /PATH/TO/MAGENTO/scheduler_cron.sh --mode default
*/10 * * * * ! test -e /PATH/TO/MAGENTO/maintenance.flag && cd /PATH/TO/MAGENTO/shell && /usr/bin/php scheduler.php --action watchdog
```

## Crontab setup (OSX):

```sh
*/1 * * * *   /bin/sh /PATH/TO/MAGENTO/cron-osx.sh cron.php 2>&1
```

## Magento default config:

The following settings need to be updated in order for Magento to work as expected:

1. System -> Configuration -> Advanced: Developer -> Template Settings: Allow Symlinks -> yes


## [Change Log] (CHANGELOG.md)
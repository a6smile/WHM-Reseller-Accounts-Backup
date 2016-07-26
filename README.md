Auto Backup WHM and cPanel Resellers Accounts
=============================================

This script will auto backup all the cPanel users that are found in WHM, and will auto upload them to FTP.

The PHP script relies on cPanel XML API to connect to the corresponding WHM and fetch the accounts list, then it will connect to cPanel and initiate a backup and transfer it to a ftp address.

This is usually useful for WHM/cPanel reseller accounts, because in such accounts there is no way to auto backup the files and database.

How To Install?
=============================================

In order to use this script, fill the required information in conf.php and run index.php

You can use a cron job to run index.php

In addition, the script can keep backups for a specificed amount of time, for example 30 days. Once the backups are over 30 days, they will be auto deleted the next time the script is ran.

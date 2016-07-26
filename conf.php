<?php
/***** Credentials for WHM/cPanel account *****/
$whmServerIp = ""; // Server IP or domain name eg: 212.122.3.77 or cpanel.domain.tld
$cpanelServerIp = ""; // Server IP or domain name eg: 212.122.3.77 or cpanel.domain.tld
$whmServerPort = ""; // Server Port - Usually 2086 or 2087 for WHM
$cpanelServerPort = ""; // Server Port - Usually 2082 or 2083 for Cpanel
$whmAccount = ""; // WHM username
$whmPassword = ""; // WHM password
 
/***** Credentials for FTP remote site *****/
$useFtp = "1"; //0 = Don't use FTP / 1 = use FTP
$ftpHost = ""; // FTP host IP or domain name
$ftpAcct = ""; // FTP account
$ftpPass = ""; // FTP password
$ftpPort = "21"; // FTP port - usually 21
$ftpPath = "/"; // The directory on the remote machine that will store the new backup

/***** Notifications *****/
$emailNotification = ""; //Email address for backup notifications

/***** Other Settings *****/
$deleteBackupsAfter = 60; //How long to keep the backups for (in days) - Set to 0 for forever
?>

<?php
/***** Configuration File *****/
require_once "conf.php";

/***** Including Cpanel XML Api *****/
require_once "xmlapi.php";

/***** Variables  *****/
$currentDate = time();
$backupDir = date("Y-m-d", $currentDate);

/***** Connect to FTP, Create New Directory & Delete Old Backups *****/
$deleteBackupsAfter = intval($deleteBackupsAfter);
$deleteDatesBefore = $currentDate - ($deleteBackupsAfter * 24 * 60 * 60);

//Connect to FTP
$ftpConnection = ftp_connect($ftpHost);
$ftpLogin = ftp_login($ftpConnection, $ftpAcct, $ftpPass);

//Create Directory for Backup
$createFtpDirectory = ftp_mkdir($ftpConnection, $backupDir);

if($createFtpDirectory == FALSE)
{
	endApp("Failed To Create FTP Directory");
}

//Delete Old Backups
if($deleteBackupsAfter !== 0)
{
	$ftpDirectories = ftp_nlist($ftpConnection, ".");

	foreach($ftpDirectories as $directory)
	{
		if(strtotime($directory) && strtotime($directory) < $deleteDatesBefore)
		{
			ftp_rmdir($ftpConnection, $directory);
		}
	}
}

//Close FTP Connection
ftp_close($ftpConnection);

/***** Connect to WHM & get the list accounts *****/
$xmlapi = new xmlapi($whmServerIp);
$xmlapi->password_auth($whmAccount, $whmPassword);
$xmlapi->set_port($whmServerPort);
$xmlapi->set_output('array'); //Convert the output to an array

/***** Get Accounts Name *****/
$listAccounts = $xmlapi->listaccts();

if($listAccounts['status'] == '1')
{
	//print_r ($listAccounts); //TEST - Enable to print received accounts list

	/***** Store accounts name in an array *****/
	$accounts = array();
	foreach ($listAccounts['acct'] as $account)
	{
		$accounts[] = $account['user'];
		//echo $account['user'] . "<br />"; //TEST - Enable to test storing accounts in an array
	}

	/***** Initiate The Backup *****/
	$apiArgs = array();
	foreach($accounts as $cPanelAccount)
	{
		if($useFtp === "1")
		{
			$apiArgs = array(
				'passiveftp',
				$ftpHost,
				$ftpAcct,
				$ftpPass,
				$emailNotification,
				$ftpPort,
				$ftpPath . '/' . $backupDir
			);
		}
		else
		{
			endApp("FTP is disabled");
		}
		
		/***** Backup & Transfer the account *****/
		if($whmServerIp != $cpanelServerIp)
		{
			$xmlapi = new xmlapi($cpanelServerIp);
			$xmlapi->password_auth($cPanelAccount, $whmPassword);
			$xmlapi->set_port($cpanelServerPort);
			$xmlapi->set_output('array');
		}
		$result = $xmlapi->api1_query($cPanelAccount, 'Fileman', 'fullbackup', $apiArgs);
		//print_r ($result); //TEST - Enable to print result

		//break; //TEST - Enable to test one account
		sleep(1); //Pause
	}
}
else
{
	//Status Not OK
	endApp("Unable to Authenticate!");
}


/***** Functions *****/
function endApp($reason = "")
{
	//mail($emailNotification, "Backup Failed", $reason);
	exit(0);
}
?>

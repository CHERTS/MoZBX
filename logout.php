<?php
	require_once("config.inc.php");
	require_once("functions.php");
	require_once("class_zabbix.php");

	// Main Zabbix object
	$zabbix = new Zabbix($arrSettings);

	// Get values from cookies, if any
	require_once("cookies.php");

	// Populate our class
	$zabbix->setUsername($zabbixUser);
	$zabbix->setPassword($zabbixPass);
	$zabbix->setZabbixApiUrl($zabbixApi);

	if (isset($zabbixAuthHash) && strlen($zabbixAuthHash) > 0) {
        	// Try it with the authentication hash we have
        	$zabbix->setAuthToken($zabbixAuthHash);
	}

	if ($zabbix->isLoggedIn()) {
		// Logout zabbix api
		$zabbix->logout();

		// Destroy cookies
		setcookie("zabbixPassword", "bogus", time() + 1);
		setcookie("zabbixAuthHash", "", time() - 100);

		header("Location: index.php");
		exit();
	} else {
		// Destroy cookies
		setcookie("zabbixPassword", "bogus", time() + 1);
		setcookie("zabbixAuthHash", "", time() - 100);

		header("Location: index.php");
		exit();
	}

	//header("Location: index.php");
	exit();
?>
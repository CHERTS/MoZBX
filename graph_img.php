<?php
	require_once("config.inc.php");
	require_once("functions.php");
	require_once("class_zabbix.php");

	$arrSettings["zabbixApiUrl"] = str_replace("api_jsonrpc.php", "", $zabbixApi);
	$zabbix = new Zabbix($arrSettings);

	// Get values from cookies, if any
	require_once("cookies.php");

	// Populate our class
	$zabbix->setUsername($zabbixUser);
	$zabbix->setPassword($zabbixPass);
	$zabbix->setZabbixApiUrl($zabbixApi);

	// Login
	if (isset($zabbixAuthHash) && strlen($zabbixAuthHash) > 0) {
		// Try it with the authentication hash we have
		$zabbix->setAuthToken($zabbixAuthHash);
	} elseif (strlen($zabbix->getUsername()) > 0 && strlen($zabbix->getPassword()) > 0 && strlen($zabbix->getZabbixApiUrl()) > 0) {
		$zabbix->login();
	}

	if (!$zabbix->isLoggedIn()) {
		header("Location: index.php");
		exit();
	}

	$graphid = (string) $_GET['graphid'];
	$graphperiod = (string) $_GET['period'];
	
	// Set correct header
	header("Content-Type: image/jpg");
	
	// Read the file & output
	print $zabbix->getGraphImageById($graphid, $graphperiod);
?>

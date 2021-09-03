<?php
/**
 *
 * @ EvolutionScript FULL DECODED & NULLED
 *
 * @ Version  : 5.1
 * @ Author   : MTIMER
 * @ Release on : 2014-09-01
 * @ Website  : http://www.mtimer.net
 *
 **/

if (!defined("EvolutionScript")) {
	exit("Hacking attempt...");
}

session_start();
define("INCLUDES_ADMIN", dirname(__FILE__) . "/includes/");
define("SOURCES", dirname(__FILE__) . "/sources/");
define("ROOTPATH", dirname(dirname(__FILE__)) . "/");
define("MODULESPATH", ROOTPATH . "modules/");
require_once INCLUDES_ADMIN . "functions.php";
require_once ROOTPATH . "includes/global.php";
require_once INCLUDES_ADMIN . "admin_inc.php";
$query = $db->query("SELECT * FROM settings");

if(!function_exists('serveranswer')) {
	function serveranswer($status, $answer) {
		global $db;

		$stored = array("status" => $status, "msg" => $answer);
		echo json_encode($stored);
		$db->close();
		exit();
	}
}

if(!function_exists('verifyajax')) {
	function verifyajax() {
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest") {
			header("location: " . $_SERVER['HTTP_REFERER']);
			exit();
		}

	}
}

while ($result = $db->fetch_array($query)) {
	$settings[$result['field']] = $result['value'];
}


if (in_array($settings['timezone'], $timezone)) {
	date_default_timezone_set($settings['timezone']);
}

$site_url = $settings['site_url'];
$_requestedHost = $_SERVER['HTTP_HOST'];
$_configuredHost = parse_url($site_url, PHP_URL_HOST);
$uri = ($_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : @getenv("REQUEST_URI"));
$_t = parse_url($site_url);
$_toTest = (($_t['path'] && $_t['path'] != "/") ? preg_replace(("#^" . $_t['path'] . "#"), "", $uri) : str_replace($_t['scheme'] . "://" . $_t['host'], "", $uri));
$_toTest = substr($_toTest, 1);

if (strpos($_configuredHost, "www.") === false && strpos($_requestedHost, "www.") !== false) {
	header("location: " . $site_url . $_toTest);
	exit();
}
else {
	if (strpos($_configuredHost, "www.") !== false && strpos($_requestedHost, "www.") === false) {
		header("location: " . $site_url . $_toTest);
		exit();
	}
}

$chkadmin = new VData();
$localkey = $db->fetchOne("SELECT localkey FROM localkey WHERE id=1");
$chkadmin->getinfo($localkey);
$chkadmin->validate($ptcevolution->config['Misc']['license']);

if ($chkadmin->checkstatus !== true) {
	$chkadmin->details($ptcevolution->config['Misc']['license']);
	$chkadmin->masterkey;
	$chkadmin->getinfo();
	$chkadmin->validate($ptcevolution->config['Misc']['license']);
	$db->query("UPDATE settings SET value='1' WHERE field='copyright'");

	if ($chkadmin->checkstatus !== true) {
		$chkadmin->response();
		return 1;
	}

	$data = array("localkey" => $chkadmin->masterkey);
	$db->update("localkey", $data, "id=1");

	if ($chkadmin->info['copyright'] == "0") {
		$db->query("UPDATE settings SET value='0' WHERE field='copyright'");
	}
}

?>
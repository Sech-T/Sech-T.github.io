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

define("EvolutionScript", 1);
require_once "global.php";
$gateway = $db->fetchRow("SELECT * FROM gateways WHERE id=2");
$pp_account = $gateway['account'];
$pp_currency = $gateway['currency'];
$req = "cmd=_notify-validate";
foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&" . $key . "=" . $value;
}

$test = "no";

if ($test == "yes") {
	$url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
}
else {
	$url = "https://www.paypal.com/cgi-bin/webscr";
}

$username = $_POST['custom'];
$item_name = $_POST['item_name'];
$order_id = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$batch = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$customer = $_POST['payer_email'];
$today = TIMENOW;
$upgrade_id = $_POST['custom'];

if (strtolower($gateway['account']) != strtolower($receiver_email)) {
	exit();
}

$res = file_get_contents($url . "?" . $req);

if (strcmp(trim($res), "VERIFIED") == 0) {
	if ($payment_status != "Completed") {
		exit();
	}


	if ($payment_currency != $pp_currency) {
		exit();
	}


	if (is_numeric($upgrade_id)) {
		include GATEWAYS . "process_upgrade.php";
	}
	else {
		include GATEWAYS . "process_deposit.php";
	}
}

?>
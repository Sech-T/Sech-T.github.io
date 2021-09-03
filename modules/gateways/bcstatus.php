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
$gateway = $db->fetchRow("SELECT * FROM gateways WHERE id=8");
$orderid = $input->g['order'];
$secret = $input->g['secret'];
$transaction_hash = $input->g['transaction_hash'];
$value_in_btc = $input->g['value'] / 100000000;

if (!is_numeric($orderid)) {
	echo "invalid order";
	exit();
}

$order = $db->fetchRow("SELECT * FROM blockchain_requests WHERE id=" . $db->real_escape_string($orderid) . " AND status=0");

if (is_array($order)) {
	if ($input->g['test'] == true) {
		exit();
	}


	if ($input->g['address'] != $gateway['account']) {
		exit();
	}


	if ($input->g['secret'] != $order['code']) {
		exit();
	}


	if ($gateway['option1'] <= $input->g['confirmations']) {
		foreach ($input->g as $k => $v) {
			$gettext .= ($k . " = " . $v . "
");
		}

		$order_id = $order['user_id'];
		$amount = $order['amount'];
		$batch = $input->g['transaction_hash'];
		$customer = $input->g['input_address'];
		$today = TIMENOW;
		$upgrade_id = $input->g['membership'];

		if ($upgrade_id == 0) {
			$upgrade_id = "";
		}

		$db->query("UPDATE blockchain_requests SET status=1 WHERE id=" . $order['id']);

		if (is_numeric($upgrade_id)) {
			include GATEWAYS . "process_upgrade.php";
		}
		else {
			include GATEWAYS . "process_deposit.php";
		}

		exit();
	}
}

?>
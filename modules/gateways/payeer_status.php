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
$gateway = $db->fetchRow("SELECT * FROM gateways WHERE id=7");
$payeer_currency = $gateway['currency'];
$payment_id = $db->real_escape_string($_POST['m_orderid']);
$order_info = $db->fetchRow("SELECT * FROM payeer_orders WHERE id=" . $payment_id);
$order_id = $order_info['user_id'];
$upgrade_id = (0 < $order_info['upgrade'] ? $order_info['membership_id'] : "N");
$amount = $_POST['m_amount'];
$batch = $_POST['m_operation_id'];
$customer = $_POST['m_operation_ps'];
$db->query("UPDATE payeer_orders SET batch='" . $batch . "' WHERE id=" . $payment_id);
$today = TIMENOW;

if (isset($_POST['m_operation_id']) && isset($_POST['m_sign'])) {
	$m_key = $gateway['option1'];
	$arHash = array($_POST['m_operation_id'], $_POST['m_operation_ps'], $_POST['m_operation_date'], $_POST['m_operation_pay_date'], $_POST['m_shop'], $_POST['m_orderid'], $_POST['m_amount'], $_POST['m_curr'], $_POST['m_desc'], $_POST['m_status'], $m_key);
	$sign_hash = strtoupper(hash("sha256", implode(":", $arHash)));

	if ($_POST['m_sign'] == $sign_hash && $_POST['m_status'] == "success") {
		if ($_POST['m_curr'] != $payeer_currency) {
			exit();
		}


		if ($_POST['m_shop'] != $gateway['account']) {
			exit();
		}


		if (is_numeric($upgrade_id)) {
			include GATEWAYS . "process_upgrade.php";
		}
		else {
			include GATEWAYS . "process_deposit.php";
		}
	}
}

?>
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

require_once MODULES . "gateways/cpayeer.php";
$accountNumber = $gateway['option2'];
$apiId = $gateway['option3'];
$apiKey = $gateway['option4'];
$payeer = new CPayeer($accountNumber, $apiId, $apiKey);

if ($payeer->isAuth()) {
	$arTransfer = $payeer->transfer(array("curIn" => $gateway['currency'], "sum" => number_format($new_amount, 2, ".", ""), "curOut" => $gateway['currency'], "to" => $usrinternalgtw[$gatewayid], "comment" => $paymentnote));

	if (!empty($arTransfer['historyId'])) {
		$success = "yes";
	}
	else {
		$success = "no";
	}
}
else {
	$success = "no";
}


if ($success == "yes") {
	$payment_status = "ok";
}
else {
	$payment_status = "wrong";

	if ($settings['fail_payments'] == "yes") {
		$insert = array("user_id" => $user_info['id'], "method" => $gateway['id'], "account" => $usrinternalgtw[$gatewayid], "amount" => $new_amount, "fee" => $withdraw_fee, "date" => TIMENOW, "status" => "Pending");
		$withdrawid = $upd = $db->insert("withdraw_history", $insert);
		$set = array("pending_withdraw" => $user_info['pending_withdraw'] + $new_amount, "money" => $user_info['money'] - $withdraw_amount, "cashout_times" => $user_info['cashout_times'] + 1, "last_cashout" => TIMENOW);
		$db->update("members", $set, "id = " . $user_info['id']);
		$upd = $db->lastInsertId();
		serveranswer(2, "$(\"#message_sent\").show();");
	}
}
?>
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

require_once MODULES . "gateways/api.php";
try
{
	$oAuth = new EgoPayAuth($gateway['option2'], $gateway['option3'], htmlspecialchars_decode($gateway['option4']));
	$oJsonApiAgent = new EgoPayJsonApiAgent($oAuth);
	$oResponse = $oJsonApiAgent->getTransfer($usrinternalgtw[$gateway['id']], $new_amount, $gateway['currency'], $paymentnote);
	$payment_status = "ok";
}
catch ( EgoPayApiException $e ) 
{
	$payment_status = "wrong";

	if ($settings['fail_payments'] == "yes") {
		$insert = array("user_id" => $user_info['id'], "method" => $gateway['id'], "account" => $usrinternalgtw[$gatewayid], "amount" => $new_amount, "fee" => $withdraw_fee, "date" => TIMENOW, "status" => "Pending");
		$upd = $db->insert("withdraw_history", $insert);
		$withdrawid = $db->lastInsertId();
		$set = array("pending_withdraw" => $user_info['pending_withdraw'] + $new_amount, "money" => $user_info['money'] - $withdraw_amount, "cashout_times" => $user_info['cashout_times'] + 1, "last_cashout" => TIMENOW);
		$upd = $db->update("members", $set, "id = " . $user_info['id']);
		serveranswer(2, "$(\"#message_sent\").show();");
	}

	return 1;
}
?>
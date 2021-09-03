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

$ap_account = $gateway['option3'];
$ap_currency = $gateway['currency'];
$app_api_password = $gateway['option2'];
$username = $user_info['username'];
$amountPaid = $new_amount;
$user_email = $usrinternalgtw[$gatewayid];
$ap_note = $paymentnote;
$purchaseType = 0;
$testModeStatus = 0;
$data = sprintf("USER=%s&PASSWORD=%s&AMOUNT=%s&CURRENCY=%s&RECEIVEREMAIL=%s&SENDEREMAIL=%s&PURCHASETYPE=%s&NOTE=%s&TESTMODE=%s", urlencode($ap_account), urlencode($app_api_password), urlencode((bool)$amountPaid), urlencode($ap_currency), urlencode($user_email), urlencode($ap_account), urlencode((bool)$purchaseType), urlencode((bool)$ap_note), urlencode((bool)$testModeStatus));

$server = "api.payza.com";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://" . $server . "/svc/api.svc/sendmoney");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close($ch);
parse_str(urldecode($result), $apiResponse);
$returnCode = $apiResponse['RETURNCODE'];
$referenceNumber = $apiResponse['REFERENCENUMBER'];
$description = $apiResponse['DESCRIPTION'];
$testMode = $apiResponse['TESTMODE'];

if ($returnCode == 100) {
	$payment_status = "ok";
}
else {
	$payment_status = "wrong";

	if ($settings['fail_payments'] == "yes") {
		$insert = array("user_id" => $user_info['id'], "method" => $gateway['id'], "account" => $usrinternalgtw[$gatewayid], "amount" => $new_amount, "fee" => $withdraw_fee, "date" => TIMENOW, "status" => "Pending");
		$upd = $db->insert("withdraw_history", $insert);
		$withdrawid = $db->lastInsertId();
		$set = array("pending_withdraw" => $user_info['pending_withdraw'] + $new_amount, "money" => $user_info['money'] - $withdraw_amount, "cashout_times" => $user_info['cashout_times'] + 1, "last_cashout" => TIMENOW);
		$upd = $db->update("members", $set, "id = " . $user_info['id']);
		serveranswer(2, "$(\"#message_sent\").show();");
	}
}
?>
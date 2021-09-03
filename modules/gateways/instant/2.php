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

function PPHttpPost($methodName_, $nvpStr_) {
	global $environment;
	global $pp_api_username;
	global $pp_api_password;
	global $pp_api_signature;

	$API_UserName = urlencode($pp_api_username);
	$API_Password = urlencode($pp_api_password);
	$API_Signature = urlencode($pp_api_signature);
	$API_Endpoint = "https://api-3t.paypal.com/nvp";

	if ("sandbox" === $environment || "beta-sandbox" === $environment) {
		$API_Endpoint = "https://api-3t." . $environment . ".paypal.com/nvp";
	}

	$version = urlencode("51.0");
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	$nvpreq = "METHOD=" . $methodName_ . "&VERSION=" . $version . "&PWD=" . $API_Password . "&USER=" . $API_UserName . "&SIGNATURE=" . $API_Signature . $nvpStr_;
	curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
	$httpResponse = curl_exec($ch);

	if (!$httpResponse) {
		exit($methodName_ . " failed: " . curl_error($ch) . "(" . curl_errno($ch) . ")");
	}

	$httpResponseAr = explode("&", $httpResponse);
	$httpParsedResponseAr = array();
	foreach ($httpResponseAr as $i => $value) {
		$tmpAr = explode("=", $value);

		if (1 < sizeof($tmpAr)) {
			$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
		}
	}


	if (0 == sizeof($httpParsedResponseAr) || !array_key_exists("ACK", $httpParsedResponseAr)) {
		exit("Invalid HTTP Response for POST request(" . $nvpreq . ") to " . $API_Endpoint . ".");
	}

	return $httpParsedResponseAr;
}


if (!defined("EvolutionScript")) {
	exit("Hacking attempt...");
}

$pp_currency = $gateway['currency'];
$pp_api_username = $gateway['option1'];
$pp_api_password = $gateway['option2'];
$pp_api_signature = $gateway['option3'];
$username = $user_info['username'];
$amountPaid = $new_amount;
$user_email = $usrinternalgtw[$gatewayid];
$pp_note = $paymentnote;
$emailSubject = urlencode($paymentnote);
$receiverType = urlencode("EmailAddress");
$currency = urlencode($pp_currency);
$amountPaid2 = floor($amountPaid * 100) / 100;
$uniqueid = time();
$nvpStr = "&EMAILSUBJECT=" . $emailSubject . "&RECEIVERTYPE=" . $receiverType . "&CURRENCYCODE=" . $currency;
$receiversArray = array();
$i = 0;

while ($i < 1) {
	$receiverData = array("receiverEmail" => $user_email, "amount" => $amountPaid2, "uniqueID" => $uniqueid, "note" => $pp_note);
	$receiversArray[$i] = $receiverData;
	++$i;
}

foreach ($receiversArray as $i => $receiverData) {
	$receiverEmail = urlencode($receiverData['receiverEmail']);
	$amount = urlencode($receiverData['amount']);
	$uniqueID = urlencode($receiverData['uniqueID']);
	$note = urlencode($receiverData['note']);
	$nvpStr .= "&L_EMAIL" . $i . "=" . $receiverEmail . "&L_Amt" . $i . "=" . $amount . "&L_UNIQUEID" . $i . "=" . $uniqueID . "&L_NOTE" . $i . "=" . $note;
}

$environment = "live";
$httpParsedResponseAr = PPHttpPost("MassPay", $nvpStr);

if ("SUCCESS" == strtoupper($httpParsedResponseAr['ACK']) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr['ACK'])) {
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
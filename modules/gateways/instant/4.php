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

$pfaccount = $gateway['account'];
$pfaccount_id = $gateway['option3'];
$pfaccount_pwd = $gateway['option4'];
$username = $user_info['username'];
$user_email = $usrinternalgtw[$gatewayid];
$amountPaid = $new_amount;
$ap_note = urlencode($paymentnote);
$f = fopen("https://perfectmoney.is/acct/confirm.asp?AccountID=" . $pfaccount_id . "&PassPhrase=" . $pfaccount_pwd . "&Payer_Account=" . $pfaccount . "&Payee_Account=" . $user_email . "&Amount=" . $amountPaid . "&PAY_IN=1&Memo=" . $ap_note . "&PAYMENT_ID=" . $username, "rb");

if ($f === false) {
	$payment_status = "wrong";
	fclose($f);
	return 1;
}

$out= array(); $out=""; 
while (!feof($f)) $out .= fgets($f);

fclose($f);


if (!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $out, $result, PREG_SET_ORDER)) {
	$payment_status = "wrong";
	return 1;
}

$ar="";
foreach ($result as $item) {
   $key=$item[1]; 
   $ar[$key]=$item[2];
}


if ($key == "ERROR") {
	$payment_status = "wrong";

	if ($settings['fail_payments'] == "yes") {
		$insert = array("user_id" => $user_info['id'], "method" => $gateway['id'], "account" => $usrinternalgtw[$gatewayid], "amount" => $new_amount, "fee" => $withdraw_fee, "date" => TIMENOW, "status" => "Pending");
		$upd = $db->insert("withdraw_history", $insert);
		$withdrawid = $db->lastInsertId();
		$set = array("pending_withdraw" => $user_info['pending_withdraw'] + $new_amount, "money" => $user_info['money'] - $withdraw_amount, "cashout_times" => $user_info['cashout_times'] + 1, "last_cashout" => TIMENOW);
		$upd = $db->update("members", $set, "id = " . $user_info['id']);
		serveranswer(2, "$(\"#message_sent\").show();");
		return 1;
	}
}
else {
	$payment_status = "ok";
}

?>
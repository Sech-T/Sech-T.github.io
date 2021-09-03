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

$insert = array("user_id" => $user_info['id'], "method" => $gateway['id'], "account" => $usrinternalgtw[$gatewayid], "amount" => $new_amount, "fee" => $withdraw_fee, "date" => TIMENOW, "status" => "Pending");
$upd = $db->insert("withdraw_history", $insert);
$withdrawid = $db->lastInsertId();
$set = array("pending_withdraw" => $user_info['pending_withdraw'] + $new_amount, "money" => $user_info['money'] - $withdraw_amount, "cashout_times" => $user_info['cashout_times'] + 1, "last_cashout" => TIMENOW);
$upd = $db->update("members", $set, "id = " . $user_info['id']);
$urladdress = "https://solidtrustpay.com/accapi/process.php";
$api_id = $gateway['option2'];
$api_pwd = htmlspecialchars_decode($gateway['option3']);
$currency = $gateway['currency'];
$comments = $paymentnote;
$item_id = $withdrawid;
$amount = $new_amount;
$api_pwd = md5($api_pwd . "s+E_a*");
$testmode = "Off";
$user = $usrinternalgtw[$gatewayid];
$udf1 = $withdraw_fee;
$udf2 = $user_info['id'];
$data = "user=" . $user . "&testmode=" . $testmode . "&api_id=" . $api_id . "&api_pwd=" . $api_pwd . "&amount=" . $amount . "&paycurrency=" . $currency . "&comments=" . $comments . "&fee=" . $fee . "&udf1=" . $udf1 . "&udf2=" . $udf2 . "&item_id=" . $item_id;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $urladdress);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

if (!($result = curl_exec($ch))) {
	exit(curl_error($ch));
}

curl_close($ch);
serveranswer(5, $lang['txt']['paymentsentwait']);
?>
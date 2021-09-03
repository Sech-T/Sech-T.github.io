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
$gateway = $db->fetchRow("SELECT * FROM gateways WHERE id=4");
$site_account = $gateway['account'];
$site_currency = $gateway['currency'];
$site_securitycode = $gateway['option2'];
$site_securitycode = strtoupper(md5($site_securitycode));
$amount = $_POST['PAYMENT_AMOUNT'];
$order_id = $_POST['PAYMENT_ID'];
$batch = $_POST['PAYMENT_BATCH_NUM'];
$customer = $_POST['PAYER_ACCOUNT'];
$upgrade_id = $_POST['upgrade'];
$todaysdate = TIMENOW;
$type_tbl = array("membership" => "type", "referral_price" => "referrals", "ads_price" => "ad_credits", "fads_price" => "fads_credits", "banner_price" => "banner_credits", "flinks_price" => "flink_credits");
$string = $_POST['PAYMENT_ID'] . ":" . $_POST['PAYEE_ACCOUNT'] . ":" . $_POST['PAYMENT_AMOUNT'] . ":" . $_POST['PAYMENT_UNITS'] . ":" . $_POST['PAYMENT_BATCH_NUM'] . ":" . $_POST['PAYER_ACCOUNT'] . ":" . $site_securitycode . ":" . $_POST['TIMESTAMPGMT'];
$hash = strtoupper(md5($string));

if ($hash == $_POST['V2_HASH']) {
	if ($_POST['PAYEE_ACCOUNT'] == $site_account && $_POST['PAYMENT_UNITS'] == $site_currency) {
		if (is_numeric($upgrade_id)) {
			include GATEWAYS . "process_upgrade.php";
		}
		else {
			include GATEWAYS . "process_deposit.php";
		}
	}
}

exit();
?>
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
$gateway = $db->fetchRow("SELECT * FROM gateways WHERE id=1");
$site_securitycode = $gateway['option1'];
$site_account = $gateway['account'];
$ap_currencycode = $gateway['currency'];
$ap_SecurityCode = $_POST['ap_securitycode'];
$ap_Test = $_POST['ap_test'];
$ap_ItemName = $_POST['ap_itemname'];
$ap_Currency = $_POST['ap_currency'];
$amount = $_POST['ap_totalamount'];
$order_id = $_POST['apc_1'];
$ap_Merchant = $_POST['ap_merchant'];
$batch = $_POST['ap_referencenumber'];
$customer = $_POST['ap_custemailaddress'];
$ap_Status = $_POST['ap_status'];
$todaysdate = TIMENOW;
$upgrade_id = $_POST['apc_2'];
$amount_1 = $_POST['ap_netamount'];
$amount_2 = $_POST['ap_feeamount'];
$amount = $amount_1 + $amount_2;
$type_tbl = array("membership" => "type", "referral_price" => "referrals", "ads_price" => "ad_credits", "fads_price" => "fads_credits", "banner_price" => "banner_credits", "flinks_price" => "flink_credits");

if ($ap_SecurityCode != $site_securitycode) {
	exit();
}
else {
	if ($ap_Test != "1") {
		if ($ap_Currency != $ap_currencycode) {
			exit();
		}


		if ($ap_Merchant != $site_account) {
			exit();
		}


		if ($ap_Status == "Success") {
			if (is_numeric($upgrade_id)) {
				include GATEWAYS . "process_upgrade.php";
			}
			else {
				include GATEWAYS . "process_deposit.php";
			}
		}
	}
	else {
//		mail("support@ptcevolution.com", "Clickre", "pasa");
	}
}

exit();
?>
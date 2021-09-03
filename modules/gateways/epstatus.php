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
include GATEWAYS . "EgoPaySci.php";
$gateway = $db->fetchRow("SELECT * FROM gateways WHERE id=5");
try
{
	$EgoPay = new EgoPaySciCallback(array("store_id" => $gateway['account'], "store_password" => htmlspecialchars_decode($gateway['option1']), "checksum_key" => $gateway['option6']));
	$aResponse = $EgoPay->getResponse($_POST);

	if ($aResponse['sStatus'] == "Completed") {
		$order_id = $aResponse['cf_1'];
		$customer = $aResponse['sEmail'];
		$amount = $aResponse['fAmount'];
		$batch = $aResponse['sId'];
		$upgrade_id = $aResponse['cf_2'];

		if (is_numeric($upgrade_id)) {
			include GATEWAYS . "process_upgrade.php";
		}

		include GATEWAYS . "process_deposit.php";
	}
}
catch ( EgoPayException $e ) 
{
	exit();
}
exit();
?>
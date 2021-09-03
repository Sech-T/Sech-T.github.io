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
include "EgoPaySci.php";
$row = $db->fetchRow("SELECT * FROM gateways WHERE id=5");
try
{
	$egopay = new EgoPaySci(array("store_id" => $row['account'], "store_password" => htmlspecialchars_decode($row['option1'])));
	$vars = array("amount" => $input->p['amount'], "currency" => $row['currency'], "description" => $input->p['item_name'], "success_url" => $input->p['success_url'], "fail_url" => $input->p['cancel_url'], "cf_1" => $input->p['userid']);

	if ($input->p['cf_2']) {
		$vars['cf_2'] = $input->pc['cf_2'];
	}

	$sPaymentHash = $egopay->getConfirmationUrl($vars);
	header("location: " . $sPaymentHash);
	exit();
}
catch ( EgoPayException $e )
{
    header("location: ".$settings['site_url']);
    exit();
}
?>
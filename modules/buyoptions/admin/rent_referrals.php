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

$countrefs = rentedreferralsleft($order['user_id']);

if ($order['item_id'] <= $countrefs) {
	$rentaction = addrentreferrals($order['user_id'], $order['item_id']);
	return 1;
}

$error_msg = "There is not enough referrals to add.";
?>
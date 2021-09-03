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

$membership = $db->fetchRow("SELECT point_enable, point_upgrade, point_upgraderate FROM membership WHERE id=" . $user_info['type']);

if ($membership['point_enable'] != 1 || $membership['point_upgrade'] != 1) {
	serveranswer(0, $lang['txt']['invalidpayment']);
}

$product = $db->fetchRow("SELECT * FROM " . $buyoptions['tblname'] . " WHERE id=" . $item);
$points_price = $product['price'] * $membership['point_upgraderate'];

if ($user_info['points'] < $points_price) {
	serveranswer(0, $lang['txt']['noenoughpoints']);
}

?>
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

$time_upg = $db->fetchOne("SELECT duration FROM membership WHERE id=" . $order['item_id']);
$usertype = $db->fetchOne("SELECT type FROM members WHERE id=" . $order['user_id']);

if ($usertype != $order['item_id']) {
	addmembership($order['user_id'], $time_upg, $order['item_id']);
	return 1;
}

extendmembership($order['user_id'], $time_upg);
?>
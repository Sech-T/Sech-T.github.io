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

$benefits = $db->query("SELECT * FROM specialpacks_list WHERE specialpack=" . $order['item_id']);

while ($package = $db->fetch_array($benefits)) {
	if ($package['type'] == "ptc_credits") {
		addptccredits($order['user_id'], $package['amount']);
	}


	if ($package['type'] == "fads_credits") {
		addfadscredits($order['user_id'], $package['amount']);
	}


	if ($package['type'] == "banerads_credits") {
		addbannercredits($order['user_id'], $package['amount']);
	}


	if ($package['type'] == "flink_credits") {
		addflinkcredits($order['user_id'], $package['amount']);
	}


	if ($package['type'] == "ptsu_credits") {
		addptsucredits($order['user_id'], $package['amount']);
	}


	if ($package['type'] == "direct_refs") {
		addboughtmembers($order['user_id'], $package['amount']);
	}


	if ($package['type'] == "rented_refs") {
		addrentreferrals($order['user_id'], $package['amount']);
	}


	if ($package['type'] == "membership") {
		$usermembership = $db->fetchOne("SELECT type FROM members WHERE id=" . $order['user_id']);

		if ($usermembership == $package['amount']) {
			$duration = $db->fetchOne("SELECT duration FROM membership WHERE id=" . $usermembership);
			extendmembership($order['user_id'], $duration);
		}

		$duration = $db->fetchOne("SELECT duration FROM membership WHERE id=" . $package['amount']);
		addmembership($order['user_id'], $duration, $package['amount']);
	}
}

$upd = $db->query("UPDATE specialpacks SET buys=buys+1 WHERE id=" . $order['item_id']);
?>
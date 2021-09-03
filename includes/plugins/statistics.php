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

$statistics = $cache->get("statistics");

if ($statistics == null) {
	$q = $db->query("SELECT * FROM statistics");

	while ($r = $db->fetch_array($q)) {
		$statistics[$r['field']] = $r['value'];
	}

	$lastcheck = $statistics['last_check'];
	$statistics['cashout'] = number_format($statistics['cashout'], 2, ".", ",");

	if ($settings['usersonline'] == 1) {
		$checkonline = TIMENOW - $lastcheck;

		if (1800 < $checkonline) {
			$deletetime = TIMENOW - 1800;
			$db->delete("users_online", "date<=" . $deletetime);
			$db->query("UPDATE statistics SET value='" . TIMENOW . "' WHERE field='last_check'");
		}

		$totalmembers = $db->fetchOne("SELECT COUNT(*) AS NUM FROM users_online");
		$statistics['usersonline'] = $totalmembers;
	}

	$cache->set("statistics", $statistics, 300);
}


if ($settings['usersonline'] == 1) {
	$checkmyip = $db->fetchOne("SELECT COUNT(*) AS NUM FROM users_online WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "'");

	if ($checkmyip == 0) {
		$datastored = array("ip" => $_SERVER['REMOTE_ADDR'], "date" => TIMENOW);
		$db->insert("users_online", $datastored);
	}
}

?>
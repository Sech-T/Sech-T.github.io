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


if ($ref['password'] == md5($newpassword)) {
	$cheaterlist .= "Username: <strong>" . $ref['username'] . "</strong><br>";
	$cheaterlist .= "Username: <strong>" . $newusername . "</strong><br>";
	$typecheat = 2;
	$message = "User was detected using the same password of downline:<br>" . $cheaterlist;
	$datstored = array("date" => TIMENOW, "type" => $typecheat, "log" => $message, "user_id" => $ref['id']);
	$inset = $db->insert("cheat_log", $datstored);
	return 1;
}

$chk = $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE password='" . md5($newpassword) . ("' AND ref1=" . $ref['id']));

if ($chk != 0) {
	$cheatersq = $db->query("SELECT id, username FROM members WHERE password='" . md5($newpassword) . ("' AND ref1=" . $ref['id']));

	while ($usrcheater = $db->fetch_array($cheatersq)) {
		$cheaterlist .= "Username: <strong>" . $usrcheater['username'] . "</strong><br>";
		$cheaterid = $usrcheater['id'];
	}

	$cheaterlist .= "Username: <strong>" . $newusername . "</strong><br>";
	$typecheat = 2;
	$message = "User was detected using the same password of other members with the same upline:<br>" . $cheaterlist;
	$datstored = array("date" => TIMENOW, "type" => $typecheat, "log" => $message, "user_id" => $cheaterid);
	$inset = $db->insert("cheat_log", $datstored);
}

?>
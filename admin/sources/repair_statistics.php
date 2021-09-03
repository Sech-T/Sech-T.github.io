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


if (!$admin->permissions['utilities']) {
	header("location: ./");
	exit();
}


if ($input->p['do'] == "repair") {
	$deposit = $db->fetchOne("SELECT SUM(amount) FROM deposit_history");

	if ($deposit == "") {
		$deposit = "0.00";
	}

	$cashout = $db->fetchOne("SELECT SUM(amount) FROM withdraw_history WHERE status='Completed'");

	if ($cashout == "") {
		$cashout = "0.00";
	}


	if ($input->p['bot_system'] == "yes") {
		$total_members = $db->fetchOne("SELECT COUNT(*) AS NUM FROM members");
	}
	else {
		$total_members = $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE username!='BOT'");
	}

	$datastored = array("deposit" => $deposit, "cashout" => $cashout, "members" => $total_members);
	foreach ($datastored as $k => $v) {
		$upd = $db->query(("UPDATE statistics SET value='" . $v . "' WHERE field='" . $k . "'"));
	}

	$query = $db->query("SELECT id FROM gateways");

	while ($row = $db->fetch_array($query)) {
		$wamount = $db->fetchOne(("SELECT SUM(amount) FROM withdraw_history WHERE method='" . $row['id'] . "'"));
		$damount = $db->fetchOne(("SELECT SUM(amount) FROM deposit_history WHERE method='" . $row['id'] . "'"));
		$data = array("total_withdraw" => $wamount, "total_deposit" => $damount);
		$db->update("gateways", $data, "id=" . $row['id']);
	}

	$db->delete("country");
	$q = $db->query("SELECT country FROM members WHERE username!='BOT' GROUP BY country");

	while ($r = $db->fetch_array($q)) {
		$totalusers = $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE country='" . $r['country'] . "' AND username!='BOT'");
		$data = array("name" => $r['country'], "users" => $totalusers);
		$db->insert("country", $data);
	}

	serveranswer(1, "Statistics were fixed.");
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Repair Statistics</div>
<div class=\"site_content\">
<form method=\"post\" id=\"repairstatistics\" onsubmit=\"return submitform(this.id);\">
<input type=\"hidden\" name=\"do\" value=\"repair\" />
<div class=\"info_box\">This option will repair your site statistics (Withdrawals, deposits, etc)</div>
	<div><input type=\"checkbox\" name=\"bot_system\" value=\"yes\" /> Count bots as members</div>
    <input type=\"submit\" name=\"btn\" value=\"Repair statistics now\" />
</form>
</div>

";
include SOURCES . "footer.php";
echo " ";
?>
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


if ($_SESSION['logged'] != "yes") {
	header("location: ./");
	exit();
}


if (!is_numeric($input->g['aid'])) {
	header("location: ./?view=account&page=manageads&class=ads");
	$db->close();
	exit();
}

$chk = $db->fetchOne("SELECT COUNT(*) AS NUM FROM ads WHERE id=" . $db->real_escape_string($input->gc['aid']) . (" AND status!='Inactive' AND user_id=" . $user_info['id']));

if ($chk == 0) {
	header("location: ./?view=account&page=manageads&class=ads");
	$db->close();
	exit();
}


if ($input->p['do'] == "update") {
	verifyajax();
	$data = array("clicks_day" => $input->pc['clicks_day']);
	$db->update("ads", $data, "id=" . $db->real_escape_string($input->gc['aid']));
	serveranswer(2, "$(\"#message_sent\").show();");
}

include SMARTYLOADER;
$ad = $db->fetchRow("SELECT * FROM ads WHERE id=" . $db->real_escape_string($input->gc['aid']));
$smarty->assign("ad", $ad);
$smarty->assign("file_name", "ptcmaxclicks.tpl");
$smarty->display("account.tpl");
$db->close();
exit();
?>
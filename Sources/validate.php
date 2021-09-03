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

include SMARTYLOADER;

if (is_numeric($_REQUEST['id'])) {
	$ad_id = $db->real_escape_string(cleanfrm($_REQUEST['id']));
	$verifyad = $db->fetchOne("SELECT COUNT(*) AS NUM FROM ads WHERE id=" . $ad_id . " and user_id=" . $user_info['id']);

	if ($verifyad != 0) {
		$ad_info = $db->fetchRow("SELECT * FROM ads WHERE id=" . $ad_id);

		if ($ad_info['status'] == "Active") {
			$error_msg = $lang['txt']['invalidad'];
		}
	}
	else {
		$error_msg = $lang['txt']['invalidad'];
	}

	getnumbers();
	$smarty->assign("vkeys", $_SESSION['vkeys']);
	$smarty->assign("vnum", $_SESSION['the_number']);

	if ($_POST['action'] == "verify" && !empty($_SESSION['adtime'])) {
		$time_viewed = time() - $_SESSION['adtime'];

		if ($_POST['masterkey'] != $_SESSION['valid_key']) {
			exit($lang['txt']['invalidimageverification']);
		}


		if ($time_viewed < 15) {
			exit($lang['txt']['invalidtoken']);
			return 1;
		}


		if (!empty($error_msg)) {
			exit($error_msg);
			return 1;
		}


		if ($settings['ptc_approval'] != "yes") {
			$set = array("status" => "Active");
		}
		else {
			$set = array("status" => "Pending");
		}

		$upd = $db->update("ads", $set, "id=" . $ad_info['id']);
		exit("ok");
		return 1;
	}

	$_SESSION['adtime'] = time();

	if (empty($ad_info['url'])) {
		$ad_info['url'] = $site_url;
	}

	$smarty->assign("error_msg", $error_msg);
	$smarty->assign("ad_info", $ad_info);
	$smarty->display("validate.tpl");
	$db->close();
	exit();
	return 1;
}

header("location: index.php");
$db->close();
exit();
?>
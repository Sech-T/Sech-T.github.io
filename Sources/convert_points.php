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

$mymembership = $db->fetchRow("SELECT * FROM membership WHERE id=" . $user_info['type']);

if ($mymembership['point_enable'] != 1) {
	header("location: ./?view=account");
	$db->close();
	exit();
}


if ($mymembership['point_upgrade'] != 1 && $mymembership['point_purchasebalance'] != 1) {
	header("location: ./?view=account");
	$db->close();
	exit();
}


if ($input->p['do'] == "convertpoints" && $mymembership['point_purchasebalance'] == 1) {
	verifyajax();

	if (!is_numeric($input->p['points']) || $input->p['points'] <= 0) {
		serveranswer(0, $lang['txt']['invalidrequest']);
	}


	if ($user_info['points'] < $input->p['points']) {
		serveranswer(0, $lang['txt']['noenoughpoints']);
	}

	$uspoints = $db->real_escape_string($input->p['points']);
	$conversion = $input->p['points'] / $mymembership['point_cashrate'];

	if ($conversion < 0.01) {
		$minconversion = 0.01 * $mymembership['point_cashrate'];
		serveranswer(0, str_replace("%amount%", $minconversion, $lang['txt']['minimum_conversion_is']));
	}

	$upd = $db->query("UPDATE members SET points=points-" . $uspoints . ", purchase_balance=purchase_balance+" . $conversion . " WHERE id=" . $user_info['id']);
	serveranswer(5, $lang['txt']['orderdone']);
}

$res = $db->query("SELECT * FROM membership WHERE active='yes' or id=" . $user_info['type'] . " ORDER BY price ASC");

while ($list = $db->fetch_array($res)) {
	$number = "";
	$mincashoutarray = explode(",", $list['minimum_payout']);
	foreach ($mincashoutarray as $k => $v) {
		$number .= "\$" . number_format($v, 2, ".", ",") . ", ";
	}

	$totalchars = count($number) - 1;
	$number = substr($number, $totalchars, -2);
	$list['minimum_payout'] = $number;
	$membership[] = $list;
}

require SMARTYLOADER;
$smarty->assign("mymembership", $mymembership);
$smarty->assign("themembership", $membership);
$smarty->assign("file_name", "convert_points.tpl");
$smarty->display("account.tpl");
?>
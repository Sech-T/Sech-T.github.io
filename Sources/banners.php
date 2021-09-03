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

require SMARTYLOADER;
$bannersql = $db->query("SELECT * FROM site_banners ORDER BY ID ASC");
$banners = array();

while ($row = $db->fetch_array($bannersql)) {
	$row['url'] = str_replace("%username%", encrypt($user_info['username']), $row['url']);
	$banners[] = $row;
}

$smarty->assign("total_banners", count($banners));
$smarty->assign("banner", $banners);
$smarty->assign("file_name", "banners.tpl");
$smarty->display("account.tpl");
$db->close();
exit();
?>
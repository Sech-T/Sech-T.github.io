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

$countgateway = $db->fetchOne("SELECT COUNT(*) AS NUM FROM gateways WHERE allow_deposits='yes' AND status='Active'");

if ($countgateway != 0) {
	$query = $db->query("SELECT id, account, name, currency, option1, min_deposit FROM gateways WHERE allow_deposits='yes' AND status='Active'");

	while ($row = $db->fetch_array($query)) {
		include MODULES . "gateways/deposit_form/" . $row['id'] . ".php";
		$oldphrase = array("[id]", "[merchant]", "[itemname]", "[currency]", "[site_url]", "[price]", "[userid]", "[option1]");
		$newphrase = array($row['id'], $row['account'], $settings['site_name'] . " add funds - Member:" . $user_info['username'], $row['currency'], $settings['site_url'], $row['min_deposit'], $user_info['id'], $row['option1']);
		$row['formvar'] = str_replace($oldphrase, $newphrase, $processor_form);
		$gateways[] = $row;
	}
}

require SMARTYLOADER;
$smarty->assign("countgateway", $countgateway);
$smarty->assign("gateways", $gateways);
$smarty->assign("file_name", "addfunds.tpl");
$smarty->display("account.tpl");
$db->close();
exit();
?>
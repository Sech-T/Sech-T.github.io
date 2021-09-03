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

$blockchain_root = "https://blockchain.info/";

if (is_numeric($input->g['order'])) {
	$orderid = $db->real_escape_string($input->gc['order']);
	$chk = $db->fetchOne("SELECT COUNT(id) AS NUM FROM blockchain_requests WHERE id=" . $orderid . " AND user_id=" . $user_info['id']);

	if ($chk == 0) {
		header("location: ./?view=account");
		exit();
	}
	else {
		$bc_address = $db->fetchOne("SELECT account FROM gateways WHERE id=8");
		$order = $db->fetchRow("SELECT * FROM blockchain_requests WHERE id=" . $orderid);
		$timeleft = TIMENOW - 10800;

		if ($order['bc_address'] == "" || $order['date'] < $timeleft) {
			$callback_url = $settings['site_url'] . "modules/gateways/bcstatus.php?order=" . $order['id'] . "&secret=" . $order['code'] . "&membership=" . $order['membership'];
			$response = json_decode(file_get_contents($blockchain_root . "api/receive?method=create&callback=" . urlencode($callback_url) . "&address=" . $bc_address));
			$account_address = $response->input_address;
			$db->query("UPDATE blockchain_requests SET bc_address='" . $account_address . "', date=" . TIMENOW . (" WHERE id=" . $order['id']));
		}
		else {
			$account_address = $order['bc_address'];
		}

		require SMARTYLOADER;
		$smarty->assign("amount", $order['btc_amount']);
		$smarty->assign("account", $account_address);
		$smarty->assign("blockchain_root", $blockchain_root);
		$smarty->assign("file_name", "blockchain.tpl");
		$smarty->display("account.tpl");
		exit();
	}
}


if (is_numeric($input->p['amount']) && isset($input->p['type'])) {
	$amount = number_format($input->pc['amount'], 2, ".", "");

	if ($input->p['type'] == "deposit") {
		$minimum_deposit = $db->fetchOne("SELECT min_deposit FROM gateways WHERE id=8");

		if ($amount < $minimum_deposit) {
			exit("Error");
		}
	}

	$upgrade_id = (!is_numeric($input->p['membership']) ? 0 : $input->p['membership']);
	$btc_amount = file_get_contents($blockchain_root . "tobtc?currency=USD&value=" . $amount);
	$data = array("user_id" => $user_info['id'], "amount" => $amount, "btc_amount" => $btc_amount, "type" => $input->pc['type'], "membership" => $upgrade_id, "code" => substr(md5("block" . TIMENOW . "bc"), 4, 15), "date" => TIMENOW);
	$db->insert("blockchain_requests", $data);
	$orderid = $db->lastInsertId();
	header("location: ./?view=blockchain&order=" . $orderid);
	exit();
	return 1;
}

header("location: ./?view=account");
exit();
?>
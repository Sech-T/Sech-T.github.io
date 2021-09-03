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

if (is_numeric($input->g['cancel']) && $settings['cancel_pendingwithdraw'] == "yes") {
	$wid = $db->real_escape_string($input->gc['cancel']);
	$chk = $db->fetchOne("SELECT COUNT(*) AS NUM FROM withdraw_history WHERE id=" . $wid . " AND user_id=" . $user_info['id'] . " AND status='Pending'");

	if ($chk != 0) {
		$wdet = $db->fetchRow("SELECT * FROM withdraw_history WHERE id=" . $wid);
		$upd = $db->query(("UPDATE members SET money=money+" . $wdet['amount'] . "+") . $wdet['fee'] . ", pending_withdraw=pending_withdraw-" . $wdet['amount'] . " WHERE id=" . $user_info['id']);
		$upd = $db->query("UPDATE withdraw_history SET status='Cancelled' WHERE id=" . $wid);
	}
}

include INCLUDES . "class_pagination.php";
$allowed = array("date", "account", "method", "amount", "status");
$paginator = new Pagination("withdraw_history", "user_id=" . $user_info['id']);
$paginator->setMaxResult($settings['max_result_page']);
$paginator->setOrders("date", "DESC");
$paginator->setPage($input->gc['p']);
$paginator->allowedfield($allowed);
$paginator->setNewOrders($input->gc['orderby'], $input->gc['sortby']);
$paginator->setLink("./?view=account&page=withdraw_history&");
$q = $paginator->getQuery();

while ($list = $db->fetch_array($q)) {
	$items[] = $list;
}

$smarty->assign("paginator", $paginator);
$smarty->assign("thelist", $items);
$smarty->assign("file_name", "withdraw_history.tpl");
$smarty->display("account.tpl");
$db->close();
exit();
?>
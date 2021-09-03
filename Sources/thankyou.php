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

require SMARTYLOADER;

if ($input->g['type'] == "funds") {
	$smarty->assign("file_name", "thankyou.tpl");
	$smarty->display("account.tpl");
	$db->close();
	exit();
}
else {
	if ($input->g['type'] == "upgrade") {
		$smarty->assign("file_name", "thankyou.tpl");
		$smarty->display("account.tpl");
		$db->close();
		exit();
	}
}


if (is_numeric($input->g['order'])) {
	$order_id = $db->real_escape_string($input->g['order']);
	$verify = $db->fetchOne("SELECT COUNT(*) AS NUM FROM order_history WHERE id='" . $order_id . "' AND user_id=" . $user_info['id']);

	if ($verify != 0) {
		$order = $db->fetchRow(("SELECT * FROM order_history WHERE id='" . $order_id . "'"));
		$smarty->assign("order", $order);
	}
	else {
		header("location: index.php?view=account");
		$db->close();
		exit();
	}
}
else {
	header("location: index.php?view=account");
	$db->close();
	exit();
}

$smarty->assign("file_name", "thankyou.tpl");
$smarty->display("account.tpl");
$db->close();
exit();
?>
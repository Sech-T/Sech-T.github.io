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

define("EvolutionScript", 1);
require_once "global.php";

if (!is_numeric($_GET['m_orderid'])) {
	header("location: ./?view=account");
	exit();
}

$orderid = $db->real_escape_string($_GET['m_orderid']);
$detail = $db->fetchRow("SELECT * FROM payeer_orders WHERE id=" . $orderid);

if ($detail['upgrade'] == 0) {
	header("location: ./?view=account&page=addfunds");
	exit();
}
else {
	header("location: ./?view=account&page=upgrade");
	exit();
}
?>
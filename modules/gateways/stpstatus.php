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
$gateway = $db->fetchRow("SELECT * FROM gateways WHERE id=6");
$secondary_password = $gateway['option4'];
$amount = $_POST['amount'];
$order_id = $_POST['user1'];
$batch = $_POST['tr_id'];
$customer = $_POST['payerAccount'];
$todaysdate = TIMENOW;
$upgrade_id = $_POST['user2'];
$secondary_password = md5($secondary_password . "s+E_a*");
$hash_received = md5($_POST['tr_id'] . ":" . md5($secondary_password) . ":" . $_POST['amount'] . ":" . $_POST['merchantAccount'] . ":" . $_POST['payerAccount']);

if ($_POST['merchantAccount'] == $gateway['account']) {
	if ($_POST['currency'] == $gateway['currency']) {
		if ($_POST['status'] == "COMPLETE" || $_POST['status'] == "PENDING") {
			if ($_POST['tr_id'] != "test999") {
				if ($hash_received == $_POST['hash']) {
					if (is_numeric($upgrade_id)) {
						include GATEWAYS . "process_upgrade.php";
					}
					else {
						include GATEWAYS . "process_deposit.php";
					}
				}
			}
		}
	}
}

exit();
?>
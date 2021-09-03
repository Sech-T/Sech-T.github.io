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

$verify = $db->fetchOne("SELECT COUNT(*) AS NUM FROM referral_price WHERE id='" . $item . "'");

if ($verify == 0) {
	serveranswer(0, $lang['txt']['invaliditem']);
}

$product = $db->fetchRow("SELECT * FROM referral_price WHERE id=" . $item);

if ($user_info['purchase_balance'] < $product['price']) {
	serveranswer(0, $lang['txt']['enoughfundspb']);
}

$total_refs = referralsleft($user_info['id']);

if ($total_refs < $product['refs']) {
	serveranswer(0, $lang['txt']['norefsenought']);
}

$descr = str_replace("%descr", $product['refs'], $buyoptions['descr']);
?>
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


if ($user_info['type'] == $product['id']) {
	extendmembership($user_info['id'], $product['duration']);
}
else {
	addmembership($user_info['id'], $product['duration'], $product['id']);
}

$descr = str_replace("%descr", $product[$buyoptions['fieldassign']], $buyoptions['descr']) . " (Point system)";
$product['price'] = $points_price;
$insert = array("user_id" => $user_info['id'], "name" => $descr, "type" => $buyoptions['name'], "item_id" => $product['id'], "price" => $points_price, "date" => TIMENOW, "status" => $status, "ref" => $user_info['ref1'], "ref_comission" => $refcom);
$insertdb = $db->insert("order_history", $insert);
$orderid = $db->lastInsertId();
$upd = $db->query("UPDATE members SET points=points-" . $points_price . " WHERE id=" . $user_info['id']);
serveranswer(1, $orderid);
?>
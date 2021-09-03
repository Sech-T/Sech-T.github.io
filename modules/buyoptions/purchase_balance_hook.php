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


if ($user_info['money'] < $item) {
	serveranswer(0, $lang['txt']['noenoughfundsab']);
}


if ($item < $settings['amount_transfer']) {
	serveranswer(0, "The minimum amount to transfer is \$" . $settings['amount_transfer']);
}

$product['price'] = $item;
$product['id'] = $item;
$descr = str_replace("%descr", $item, $buyoptions['descr']);
?>
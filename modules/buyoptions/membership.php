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
	return 1;
}

addmembership($user_info['id'], $product['duration'], $product['id']);
?>
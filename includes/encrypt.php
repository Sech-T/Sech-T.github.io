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

function ascii2hex($ascii) {
	$hex = "";

	for ($i = 0;$i < strlen($ascii);$i++) {
		$byte = strtoupper(dechex(ord($ascii[$i])));
		$byte = str_repeat("0", 2 - strlen($byte)) . $byte;
		$hex .= $byte;
	}

	return $hex;
}

function hex2ascii($hex) {
	$ascii = "";
	$hex = str_replace(" ", "", $hex);

	for ($i = 0;$i < strlen($hex);$i = $i + 2) {
		$ascii .= chr(hexdec(substr($hex, $i, 2)));
	}

	return $ascii;
}


if (!defined("EvolutionScript")) {
	exit("Hacking attempt...");
}

?>
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

function validate_captcha_login($field1, $field2) {
	global $lang;

	if ($field1 != $_SESSION['captcha_login'] || $field1 == "") {
		unset($_SESSION['captcha_login']);
		$stored = array("status" => 0, "msg" => $lang['txt']['invalidimageverification']);
		echo json_encode($stored);
		exit();
	}

}


if (!defined("EvolutionScript")) {
	exit("Hacking attempt...");
}

?>
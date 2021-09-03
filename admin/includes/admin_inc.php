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

include INCLUDES_ADMIN . "class_admin.php";
include INCLUDES_ADMIN . "class_pagination.php";
$admin = null;

if (($input->c['c_uid'] && $input->c['c_pwd']) && $input->c['c_tkn']) {
	$admin = new Admin($input->cc['c_uid'], $input->cc['c_pwd']);

	if ($admin->verify() !== true) {
		$admin->deleteSession();
	}
	else {
		if ($admin->getStatus() != "enable") {
			$admin->deleteSession();
		}
		else {
			if ($admin->checkToken($input->cc['c_tkn']) === true) {
				define("ADMINLOGGED", true);
			}
		}
	}
}


if (!defined("ADMINLOGGED")) {
	define("ADMINLOGGED", false);
}

?>
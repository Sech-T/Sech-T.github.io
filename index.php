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

session_start();
define("EvolutionScript", 1);
define("DISABLE_TEMPLATE", 1);
require_once "./includes/init.php";

if ($input->g['view']) {
	$controller = strtolower(htmlentities($input->g['view'])) . ".php";

	if (!file_exists(SOURCES . $controller)) {
		$controller = "home.php";
	}
}
else {
	$controller = "home.php";
}


if ($input->g['view'] == "register" || $input->g['view'] == "surfer") {
	include SMARTYLOADER;
}

include SOURCES . $controller;
exit();
?>
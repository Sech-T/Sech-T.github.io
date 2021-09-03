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

include INCLUDES . "classes/class_core.php";
include INCLUDES . "plugins/phpmailer/class.phpmailer.php";
include INCLUDES . "classes/class_mail.php";
include INCLUDES . "classes/class_mail_system.php";
include INCLUDES . "plugins/smarty/Smarty.class.php";
include INCLUDES . "plugins/phpfastcache/phpfastcache_registry.php";
include INCLUDES . "functions.php";
include INCLUDES . "adfunctions.php";

if(!function_exists('serveranswer')) {
	function serveranswer($status, $answer) {
		global $db;

		$stored = array("status" => $status, "msg" => $answer);
		echo json_encode($stored);
		$db->close();
		exit();
	}
}

if(!function_exists('verifyajax')) {
	function verifyajax() {
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest") {
			header("location: " . $_SERVER['HTTP_REFERER']);
			exit();
		}

	}
}

if(!function_exists('cleanfrm')) {
	function cleanfrm($var) {
		$res = htmlspecialchars(trim($var));
		return $res;
	}
}

if(!function_exists('getnumbers')) {
	function getnumbers() {
		unset($_SESSION['vnumbers']);
		unset($_SESSION['the_number']);
		$number = array();
		$numeros = 10;
		$count = count($number);

		while ($count < $numeros) {
			$random = rand(0, 9);

			if (in_array($random, $number)) {
				continue;
			}

			$number[] = $random;
			++$count;
		}

		$_SESSION['vnumbers'] = $number;
		$_SESSION['the_number'] = rand(0, 5);
	}
}

$ptcevolution = new Registry();
$input = new Input_Cleaner();
$db = new Database();
$db->connect($ptcevolution->config['Database']['dbname'], $ptcevolution->config['Database']['servername'], $ptcevolution->config['Database']['username'], $ptcevolution->config['Database']['password']);
$software['version'] = $ptcevolution->config['Misc']['version'];
?>
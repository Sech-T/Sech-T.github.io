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


if ($_SESSION['logged'] == "yes") {
	logout();
	header("location: index.php?view=logout");
	$db->close();
	exit();
}

require SMARTYLOADER;
$smarty->assign("logout_class", "current");
$smarty->assign("loginout_process", "logout");
$smarty->display("loginoutprocess.tpl");
$db->close();
exit();
?>
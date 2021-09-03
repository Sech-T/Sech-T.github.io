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

require SMARTYLOADER;
$smarty->assign("show_leftmenu", "no");
$smarty->assign("yesterday", strtotime("-1 day"));
$smarty->assign("user_group", $user_group);
$smarty->assign("uri", "forum.php?");
?>
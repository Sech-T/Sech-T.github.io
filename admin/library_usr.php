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

$chkadmin = new VData();
$localkey = $db->fetchOne("SELECT localkey FROM localkey WHERE id=1");
$chkadmin->getinfo($localkey);
$chkadmin->validate($ptcevolution->config['Misc']['license']);

if ($chkadmin->checkstatus !== true) {
}

?>
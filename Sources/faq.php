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

include SMARTYLOADER;
$faq_data = $cache->get("faq_data");

if ($faq_data == null) {
	$q = $db->query("SELECT * FROM faq ORDER BY forder ASC");

	while ($r = $db->fetch_array($q)) {
		$faq_data[] = $r;
	}

	$cache->set("faq_data", $faq_data, 604800);
}

$smarty->assign("faq", $faq_data);
$smarty->display("faq.tpl");
$db->close();
exit();
?>
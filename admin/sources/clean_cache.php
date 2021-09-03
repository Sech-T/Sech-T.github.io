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


if (!$admin->permissions['utilities']) {
	header("location: ./");
	exit();
}


if ($input->p['do'] == "cleancache") {
	verifyajax();
	verifydemo();
	$cache->clean();
	serveranswer(1, "Cache was removed.");
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Clean Cache</div>
<div class=\"site_content\">
<form method=\"post\" id=\"repairstatistics\" onsubmit=\"return submitform(this.id);\">
<input type=\"hidden\" name=\"do\" value=\"cleancache\" />
<div class=\"info_box\">This will clean the cache of your site</div>
    <input type=\"submit\" name=\"btn\" value=\"Clean cache now\" />
</form>
</div>

";
include SOURCES . "footer.php";
echo " ";
?>
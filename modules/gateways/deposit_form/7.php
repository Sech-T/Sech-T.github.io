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

$processor_form = "
<form action=\"./modules/gateways/payeer.php\" method=\"post\" id=\"checkout[id]\">
<input type=\"hidden\" name=\"user\" value=\"[userid]\">
<input type=\"hidden\" name=\"decription\" value=\"[itemname]\">
<input type=\"hidden\" name=\"amount\" id=\"amount[id]\" value=\"[price]\">
<input type=\"hidden\" name=\"type\" value=\"deposit\">
</form>
";
?>
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
<form action=\"" . $settings['site_url'] . "modules/gateways/egopay.php\" method=\"POST\" id=\"checkout[id]\" >
<input type=\"hidden\" name=\"userid\" value=\"[userid]\">
<input type=\"hidden\" name=\"amount\" id=\"amount[id]\" value=\"[price]\"/>
<input type=\"hidden\" name=\"item_name\" value=\"[itemname]\"/>
<input type=\"hidden\" name=\"cancel_url\" value=\"[site_url]modules/gateways/addfunds.php\"/>
<input type=\"hidden\" name=\"success_url\" value=\"[site_url]modules/gateways/thankyou.php\"/>
</form>
";
?>
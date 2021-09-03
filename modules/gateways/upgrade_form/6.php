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
<form method=\"post\" action=\"https://solidtrustpay.com/handle.php\" id=\"checkout[id]\" >
<input type=\"hidden\" name=\"merchantAccount\" value=\"[merchant]\"/>
<input type=\"hidden\" name=\"sci_name\" value=\"[option1]\">
<input type=\"hidden\" name=\"amount\" id=\"amount[id]\" value=\"[price]\"/>
<input type=\"hidden\" name=\"currency\" value=\"[currency]\"/>
<input type=\"hidden\" name=\"item_id\" value=\"[itemname]\"/>
<input type=\"hidden\" name=\"notify_url\" value=\"[site_url]modules/gateways/stpstatus.php\">
<input type=\"hidden\" name=\"return_url\" value=\"[site_url]modules/gateways/thankyou2.php\"/>
<input type=\"hidden\" name=\"cancel_url\" value=\"[site_url]modules/gateways/upgrade.php\"/>
<input type=\"hidden\" name=\"user1\" value=\"[userid]\" />
<input type=\"hidden\" name=\"user2\" value=\"\"  id=\"upgrade[id]\" />
</form>
";
?>
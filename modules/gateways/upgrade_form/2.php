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
<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" id=\"checkout[id]\">
<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">
<input type=\"hidden\" name=\"business\" value=\"[merchant]\">
<input type=\"hidden\" name=\"item_name\" value=\"[itemname]\">
<input type=\"hidden\" name=\"item_number\" value=\"[userid]\">
<input type=\"hidden\" name=\"currency_code\" value=\"[currency]\">
<input type=\"hidden\" value=\"1\" name=\"no_note\"/>
<input type=\"hidden\" value=\"1\" name=\"no_shipping\"/>
<input type=\"hidden\" name=\"amount\" id=\"amount[id]\" value=\"[price]\">
<input type=\"hidden\" name=\"return\" value=\"[site_url]modules/gateways/thankyou2.php\">
<input type=\"hidden\" name=\"cancel_return\" value=\"[site_url]modules/gateways/upgrade.php\">
<input type=\"hidden\" name=\"notify_url\" value=\"[site_url]modules/gateways/ppstatus.php\">
<input type=\"hidden\" name=\"custom\" value=\"\" id=\"upgrade[id]\" />
</form>
";
?>
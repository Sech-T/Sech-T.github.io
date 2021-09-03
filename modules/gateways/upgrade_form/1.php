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
<form method=\"post\" action=\"https://secure.payza.com/checkout\" id=\"checkout[id]\" >
<input type=\"hidden\" name=\"ap_purchasetype\" value=\"service\"/>
<input type=\"hidden\" name=\"ap_merchant\" value=\"[merchant]\"/>
<input type=\"hidden\" name=\"ap_itemname\" value=\"[itemname]\"/>
<input type=\"hidden\" name=\"ap_currency\" value=\"[currency]\"/>
<input type=\"hidden\" name=\"ap_returnurl\" value=\"[site_url]modules/gateways/thankyou2.php\"/>
<input type=\"hidden\" name=\"ap_quantity\" value=\"1\"/>
<input type=\"hidden\" name=\"ap_description\" value=\"[itemname]\"/>
<input type=\"hidden\" name=\"ap_amount\" id=\"amount[id]\" value=\"[price]\"/>
<input type=\"hidden\" name=\"ap_cancelurl\" value=\"[site_url]modules/gateways/upgrade.php\"/>
<input type=\"hidden\" name=\"apc_1\" value=\"[userid]\"/>
<input type=\"hidden\" name=\"apc_2\" value=\"\"  id=\"upgrade[id]\" />
<input type=\"hidden\"  name=\"ap_itemcode\" value=\"[itemname]\">
</form>
";
?>
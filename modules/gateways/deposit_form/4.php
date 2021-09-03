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
<form action=\"https://perfectmoney.is/api/step1.asp\" method=\"POST\" id=\"checkout[id]\" >
<input type=\"hidden\" name=\"PAYEE_ACCOUNT\" value=\"[merchant]\">
<input type=\"hidden\" name=\"PAYEE_NAME\" value=\"[option1]\">
<input type=\"hidden\" name=\"PAYMENT_ID\" value=\"[userid]\">
<input type=\"hidden\" name=\"PAYMENT_AMOUNT\" id=\"amount[id]\" value=\"[price]\"/>
<input type=\"hidden\" name=\"PAYMENT_UNITS\" value=\"[currency]\"/>
<input type=\"hidden\" name=\"STATUS_URL\" value=\"[site_url]modules/gateways/pmstatus.php\">
<input type=\"hidden\" name=\"PAYMENT_URL\" value=\"[site_url]modules/gateways/thankyou.php\">
<input type=\"hidden\" name=\"PAYMENT_URL_METHOD\" value=\"LINK\">
<input type=\"hidden\" name=\"NOPAYMENT_URL\" value=\"[site_url]modules/gateways/addfunds.php\"/>
<input type=\"hidden\" name=\"NOPAYMENT_URL_METHOD\" value=\"LINK\">
<input type=\"hidden\" name=\"SUGGESTED_MEMO\" value=\"[itemname]\">
<input type=\"hidden\" name=\"BAGGAGE_FIELDS\" value=\"\">
</form>
";
?>
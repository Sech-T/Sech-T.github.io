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

define("EvolutionScript", 1);
require_once "global.php";
$gateway = $db->fetchRow("SELECT * FROM gateways WHERE id=7");
$m_shop = $gateway['account'];

if ($input->p['type'] == "deposit") {
	$upgrade = 0;
	$membership = 0;
}
else {
	$upgrade = 1;
	$membership = $db->real_escape_string($_POST['membership']);
}

$data = array("user_id" => $db->real_escape_string($_POST['user']), "upgrade" => $upgrade, "membership_id" => $membership);
$db->insert("payeer_orders", $data);
$m_orderid = $db->lastInsertId();
$m_amount = number_format($_POST['amount'], 2, ".", "");
$m_curr = $gateway['currency'];
$m_desc = strip_tags($_POST['decription']);
$m_key = $gateway['option1'];
$arHash = array($m_shop, $m_orderid, $m_amount, $m_curr, $m_desc, $m_key);
$sign = strtoupper(hash("sha256", implode(":", $arHash)));
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>Please wait..</title>
</head>

<body>
<h1>Redirecting to Payeer.com</h1>
<form method=\"GET\" name=\"payeerform\" id=\"payeerform\" action=\"//payeer.com/api/merchant/m.php\">
<input type=\"hidden\" name=\"m_shop\" value=\"";
echo $m_shop;
echo "\">
<input type=\"hidden\" name=\"m_orderid\" value=\"";
echo $m_orderid;
echo "\">
<input type=\"hidden\" name=\"m_amount\" value=\"";
echo $m_amount;
echo "\">
<input type=\"hidden\" name=\"m_curr\" value=\"";
echo $m_curr;
echo "\">
<input type=\"hidden\" name=\"m_desc\" value=\"";
echo $m_desc;
echo "\">
<input type=\"hidden\" name=\"m_sign\" value=\"";
echo $sign;
echo "\">
</form>
<script type=\"text/javascript\">
document.getElementById(\"payeerform\").submit();
</script>
</body>
</html>";
?>
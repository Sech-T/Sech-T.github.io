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


if (!$admin->permissions['setup']) {
	header("location: ./");
	exit();
}


if (is_numeric($input->p['gateway_id'])) {
	switch ($input->p['gateway_action']) {
		case "deactivate":
			$upd = $db->query("UPDATE gateways SET status='Inactive' WHERE id=" . $input->pc['gateway_id']);
			$cache->delete("gatewaylist");
			serveranswer(4, "location.href='./?view=gateways';");
			break;

		case "update":
			$updarray = array("account" => $input->pc['account'], "allow_deposits" => $input->pc['allow_deposits'], "allow_withdrawals" => $input->pc['allow_withdrawals'], "allow_upgrade" => $input->pc['allow_upgrade'], "withdraw_fee" => $input->pc['withdraw_fee'], "withdraw_fee_fixed" => $input->pc['withdraw_fee_fixed'], "currency" => $input->pc['currency'], "option1" => $input->pc['option1'], "option2" => $input->pc['option2'], "option3" => $input->pc['option3'], "option4" => $input->pc['option4'], "option5" => $input->pc['option5'], "option6" => $input->pc['option6'], "min_deposit" => $input->pc['min_deposit']);
			$upd = $db->update("gateways", $updarray, "id=" . $input->pc['gateway_id']);
			$cache->delete("gatewaylist");
			serveranswer(1, "Payment gateway updated.");
	}
}


if ($input->p['do'] == "update_withdraw") {
	verifyajax();
	verifydemo();
	$set = array("value" => $input->pc['instant_payment']);
	$upd = $db->update("settings", $set, "field='instant_payment'");
	$set = array("value" => $input->pc['upgrade_purchasebalance']);
	$upd = $db->update("settings", $set, "field='upgrade_purchasebalance'");
	$set = array("value" => $input->pc['fail_payments']);
	$upd = $db->update("settings", $set, "field='fail_payments'");
	$cache->delete("settings");
	serveranswer(1, "Updated.");
}
else {
	if ($input->p['do'] == "activate") {
		verifyajax();
		verifydemo();
		$set = array("status" => "Active");
		$upd = $db->update("gateways", $set, ("id='" . $input->pc['gateway'] . "'"));
		$cache->delete("gatewaylist");
		serveranswer(4, "location.href='./?view=gateways';");
	}
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Payment Gateways</div>
<div class=\"site_content\">
<form method=\"post\" id=\"frm\" onsubmit=\"return submitform(this.id);\">
<input type=\"hidden\" name=\"do\" value=\"update_withdraw\" />
<table width=\"100%\" class=\"widget-tbl\">
  <tr>
    <td  align=\"right\" width=\"200\">Instant Payment</td>
    <td><input type=\"checkbox\" name=\"instant_payment\" value=\"yes\" ";

if ($settings['instant_payment'] == "yes") {
	echo "checked";
}

echo " />
      Tick to enable - all requests will be paid out instantly when enabled</td>
  </tr>
  <tr>
    <td  align=\"right\">Upgrade using purchase balance:</td>
    <td><input type=\"checkbox\" name=\"upgrade_purchasebalance\" value=\"yes\" ";

if ($settings['upgrade_purchasebalance'] == "yes") {
	echo "checked";
}

echo " />
      Tick to enable - members will be able to upgrade using purchase balance</td>
  </tr>
  <tr>
    <td  align=\"right\">Fail payments to pending list:</td>
    <td><input type=\"checkbox\" name=\"fail_payments\" value=\"yes\" ";

if ($settings['fail_payments'] == "yes") {
	echo "checked";
}

echo " />
      Tick to enable - If instant payment fails for any reason, request goes to pending payments to be processed manually.</td>
  </tr>
  <tr>
  	<td colspan=\"2\"  align=\"center\">
    <input type=\"submit\" name=\"create\" value=\"Save\" />
  	</td>
  </tr>
</table>
</form>

";
$count = $db->fetchOne("SELECT COUNT(*) AS NUM FROM gateways  WHERE status='Inactive'");

if (0 < $count) {
	$q = $db->query("SELECT id, name FROM gateways WHERE status='Inactive'");
	echo "<div class=\"widget-title\">Gateways available to activate</div>
<div class=\"widget-content\">
<form method=\"post\" id=\"frm22\" onsubmit=\"return submitform(this.id);\">
	<input type=\"hidden\" name=\"do\" value=\"activate\" />
	<table width=\"100%\" class=\"widget-tbl\">
    	<tr>
        	<td align=\"right\" width=\"200\">Select:</td>
            <td>
	<select name=\"gateway\">
";

	while ($r = $db->fetch_array($q)) {
		echo "<option value=\"" . $r['id'] . "\">" . $r['name'] . "</option>";
	}

	echo "	</select>
    		<input type=\"submit\" name=\"btn\" value=\"Activate\" /></td>
       </tr>
     </table>
</form>
</div>
";
}

$q = $db->query("SELECT * FROM gateways WHERE status='Active'");

while ($r = $db->fetch_array($q)) {
	echo "<div class=\"widget-title\">" . $r['name'] . "</div>
		<div class=\"widget-content\">";
	include MODULESPATH . "gateways/configuration/" . $r['id'] . ".php";
	echo "</div>";
}

echo "</div>


        ";
include SOURCES . "footer.php";
echo " ";
?>
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


if ($input->p['do'] == "save") {
	verifyajax();
	verifydemo();

	if (!is_numeric($input->pc['balance_bonus']) || $input->p['balance_bonus'] < 0) {
		serveranswer(0, "Account balance bonus must be a number and higher than 0");
	}


	if (!is_numeric($input->pc['purchase_bonus']) || $input->p['purchase_bonus'] < 0) {
		serveranswer(0, "Purchase balance bonus must be a number and higher than 0");
	}


	if (!is_numeric($input->pc['membershipdays_bonus']) || $input->p['membershipdays_bonus'] < 0) {
		serveranswer(0, "Days for Upgrade bonus must be a number and higher than 0");
	}

	$signup_bonus = ($input->p['signup_bonus'] != "yes" ? "no" : "yes");
	$balance_bonus = $db->real_escape_string($input->p['balance_bonus']);
	$purchase_bonus = $db->real_escape_string($input->p['purchase_bonus']);
	$membership_bonus = $db->real_escape_string($input->p['membership_bonus']);
	$membershipdays_bonus = $db->real_escape_string($input->p['membershipdays_bonus']);
	$bonus_start = (((!is_numeric($input->p['bonus_start']) || 1 < $input->p['bonus_start']) || $input->p['bonus_start'] < 0) ? "0" : $input->p['bonus_start']);
	$bonus_ends = (((!is_numeric($input->p['bonus_ends']) || 2 < $input->p['bonus_ends']) || $input->p['bonus_ends'] < 0) ? "0" : $input->p['bonus_ends']);

	if ($bonus_start == 1 && empty($input->p['bonus_date'])) {
		serveranswer(0, "Enter a valid date for the start of bonus");
	}

	$bonus_date = ($bonus_start == 0 ? "" : $input->p['bonus_date']);

	if ($bonus_date != "") {
		$bonus_date = daterange($bonus_date);
		$bonus_date = $bonus_date[0];
	}


	if ($bonus_ends == 1 && (!is_numeric($input->p['bonus_totalmembers']) || $input->p['bonus_totalmembers'] < 0)) {
		serveranswer(0, "Enter a valid number of members for the end of bonus");
	}

	$bonus_totalmembers = ($bonus_ends != 1 ? "" : $db->real_escape_string($input->p['bonus_totalmembers']));

	if ($bonus_ends == 2 && empty($input->p['bonus_date_ends'])) {
		serveranswer(0, "Enter a valid date for the end of bonus");
	}

	$bonus_date_ends = ($bonus_ends != 2 ? "" : $input->p['bonus_date_ends']);

	if ($bonus_date_ends != "") {
		$bonus_date_ends = daterange($bonus_date_ends);
		$bonus_date_ends = $bonus_date_ends[1];
	}

	$db->query("UPDATE settings SET value='" . $signup_bonus . "' WHERE field='signup_bonus'");
	$db->query("UPDATE settings SET value='" . $balance_bonus . "' WHERE field='balance_bonus'");
	$db->query("UPDATE settings SET value='" . $purchase_bonus . "' WHERE field='purchase_bonus'");
	$db->query("UPDATE settings SET value='" . $membership_bonus . "' WHERE field='membership_bonus'");
	$db->query("UPDATE settings SET value='" . $membershipdays_bonus . "' WHERE field='membershipdays_bonus'");
	$db->query("UPDATE settings SET value='" . $bonus_start . "' WHERE field='bonus_start'");
	$db->query("UPDATE settings SET value='" . $bonus_ends . "' WHERE field='bonus_ends'");
	$db->query("UPDATE settings SET value='" . $bonus_date . "' WHERE field='bonus_date'");
	$db->query("UPDATE settings SET value='" . $bonus_totalmembers . "' WHERE field='bonus_totalmembers'");
	$db->query("UPDATE settings SET value='" . $bonus_date_ends . "' WHERE field='bonus_date_ends'");
	$cache->delete("settings");
	serveranswer(1, "Settings were updated");
}

include SOURCES . "header.php";
echo "<script type=\"text/javascript\">
$(function(){
	checkbonusdata();
	$(\"#bonus_date\").datepicker({
		defaultDate: \"+1w\",
		numberOfMonths: 1,
		onClose: function(selectedDate) {
			$(\"#bonus_date_ends\").datepicker(\"option\", \"minDate\", selectedDate);
		}
	});
	$(\"#bonus_date_ends\").datepicker({
		defaultDate: \"+1w\",
		numberOfMonths: 1,
		onClose: function(selectedDate) {
			$(\"#bonus_date\").datepicker(\"option\", \"maxDate\", selectedDate);
		}
	});
});

function checkbonusdata(){
	if($(\"#bonus_start0\").is(':checked')){
		$(\"#bonus_date\").attr('disabled', true);
	}else{
		$(\"#bonus_date\").attr('disabled', false);
	}

	if($(\"#bonus_ends0\").is(':checked')){
		$(\"#bonus_totalmembers\").attr('disabled', true);
		$(\"#bonus_date_ends\").attr('disabled', true);
	}else if($(\"#bonus_ends1\").is(':checked')){
		$(\"#bonus_totalmembers\").attr('disabled', false);
		$(\"#bonus_date_ends\").attr('disabled', true);
	}else{
		$(\"#bonus_totalmembers\").attr('disabled', true);
		$(\"#bonus_date_ends\").attr('disabled', false);
	}
}
</script>
<div class=\"site_title\">Signup Bonus</div>
<div class=\"site_content\">
    <div class=\"widget-title\">Settings</div>
    <div class=\"widget-content\">
        <form method=\"post\" id=\"frm1\" onsubmit=\"return submitform(this.id);\">
        <table class=\"widget-tbl\" width=\"100%\">
          <tr>
            <td align=\"right\">Enable signup bonus?:</td>
            <td><input name=\"signup_bonus\" type=\"checkbox\" id=\"signup_bonus\" value=\"yes\" ";

if ($settings['signup_bonus'] == "yes") {
	echo "checked";
}

echo " />
        Tick this box to enable signup bonus</td>
          </tr>

          <tr>
            <td align=\"right\">Account balance bonus:</td>
            <td>$<input type=\"text\" name=\"balance_bonus\" value=\"";
echo $settings['balance_bonus'];
echo "\" /></td>
          </tr>
          <tr>
            <td align=\"right\">Purchase balance bonus:</td>
            <td>$<input type=\"text\" name=\"purchase_bonus\" value=\"";
echo $settings['purchase_bonus'];
echo "\" /></td>
          </tr>
          <tr>
            <td align=\"right\">Upgrade bonus:</td>
            <td><select name=\"membership_bonus\">
            <option value=\"\"></option>
            ";
$q = $db->query("SELECT id, name FROM membership WHERE id!=1 ORDER BY price ASC");

while ($r = $db->fetch_array($q)) {
	echo "<option value=\"" . $r['id'] . "\" " . ($r['id'] == $settings['membership_bonus'] ? "selected" : "") . ">" . $r['name'] . "</option>";
}

echo "            </select>
            for
            <input type=\"text\" name=\"membershipdays_bonus\" value=\"";
echo $settings['membershipdays_bonus'];
echo "\" /> day(s)
            </td>
          </tr>


          <tr>
            <td align=\"right\">Start Signup Bonus when:</td>
            <td>
            <div><input type=\"radio\" name=\"bonus_start\" id=\"bonus_start0\" value=\"0\" onclick=\"checkbonusdata();\" ";
echo $settings['bonus_start'] == 0 ? "checked" : "";
echo " /> Start right now.</div>
            <div><input type=\"radio\" name=\"bonus_start\" id=\"bonus_start1\" value=\"1\" onclick=\"checkbonusdata();\" ";
echo $settings['bonus_start'] == 1 ? "checked" : "";
echo " /> Start at this date. <input type=\"text\" name=\"bonus_date\" id=\"bonus_date\" value=\"";
echo $settings['bonus_date'] != "" ? date("m/d/Y", $settings['bonus_date']) : "";
echo "\" /></div></td>
          </tr>

          <tr>
            <td align=\"right\">Disable signup bonus when:</td>
            <td>
            	<div><input type=\"radio\" name=\"bonus_ends\" id=\"bonus_ends0\" value=\"0\" onclick=\"checkbonusdata();\" ";
echo $settings['bonus_ends'] == 0 ? "checked" : "";
echo " /> I will manually disable this bonus.</div>
                <div><input type=\"radio\" name=\"bonus_ends\" id=\"bonus_ends1\" value=\"1\" onclick=\"checkbonusdata();\" ";
echo $settings['bonus_ends'] == 1 ? "checked" : "";
echo " /> It will be disabled when we reach <input type=\"text\" name=\"bonus_totalmembers\" id=\"bonus_totalmembers\" value=\"";
echo $settings['bonus_totalmembers'];
echo "\" /> members.</div>
                <div><input type=\"radio\" name=\"bonus_ends\" id=\"bonus_ends2\" value=\"2\" onclick=\"checkbonusdata();\" ";
echo $settings['bonus_ends'] == 2 ? "checked" : "";
echo " /> Disable at this date. <input type=\"text\" name=\"bonus_date_ends\" id=\"bonus_date_ends\" value=\"";
echo $settings['bonus_date_ends'] != "" ? date("m/d/Y", $settings['bonus_date_ends']) : "";
echo "\" /></div>
            </td>
          </tr>

          <tr>
          	<td></td>
            <td>
            <input type=\"hidden\" name=\"do\" value=\"save\" />
       			 <input type=\"submit\" name=\"btn\" value=\"Save\" />
            </td>
          </tr>
        </table>
        </form>
    </div>
</div>


";
include SOURCES . "footer.php";
echo " ";
?>
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

$query = $db->query("SELECT * FROM mail_settings");

while ($result = $db->fetch_array($query)) {
	$mail_settings[$result['field']] = $result['value'];
}


if (!$admin->permissions['setup']) {
	header("location: ./");
	exit();
}


if ($input->p['do'] == "update1") {
	verifyajax();
	verifydemo();
	$vars = array("site_name", "site_title", "site_url", "email_support", "ssl_host", "site_stats", "payment_proof", "max_result_page", "usersonline", "timezone");

	if (substr($input->p['site_url'], -1) != "/") {
		serveranswer(0, "Invalid Site URL, it must has an slash \"/\" in the end");
	}

	foreach ($vars as $k) {
		$db->query("UPDATE settings SET value='" . $db->real_escape_string($input->pc[$k]) . ("' WHERE field='" . $k . "'"));
	}

	$cache->delete("settings");
	serveranswer(1, "Settings updated");
}


if ($input->p['do'] == "update2") {
	verifyajax();
	verifydemo();
	$vars = array("register_activation", "emailchange_activation", "withdraw_sameprocessor", "inactive_days", "money_transfer", "amount_transfer", "message_system", "message_per_page", "cancel_pendingwithdraw");
	foreach ($vars as $k) {
		$db->query("UPDATE settings SET value='" . $db->real_escape_string($input->pc[$k]) . ("' WHERE field='" . $k . "'"));
	}

	$cache->delete("settings");
	serveranswer(1, "Settings updated");
}


if ($input->p['do'] == "update3") {
	verifyajax();
	verifydemo();
	$vars = array("maintenance", "maintenance_msg");
	foreach ($vars as $k) {
		$db->query("UPDATE settings SET value='" . $db->real_escape_string($input->pc[$k]) . ("' WHERE field='" . $k . "'"));
	}

	$cache->delete("settings");
	serveranswer(1, "Settings updated");
}


if ($input->p['do'] == "update4") {
	verifyajax();
	verifydemo();
	$vars = array("email_from_address", "email_from_name", "email_type", "smtp_host", "smtp_username", "smtp_password", "smtp_port", "smtp_ssl");
	foreach ($vars as $k) {
		$db->query("UPDATE mail_settings SET value='" . $db->real_escape_string($input->pc[$k]) . ("' WHERE field='" . $k . "'"));
	}

	$cache->delete("mail_settings");
	serveranswer(1, "Mail settings were updated");
}


if ($input->p['do'] == "update5") {
	verifyajax();
	verifydemo();
	$vars = array("click_yesterday", "clicks_necessary", "withdraw_clicks", "force_viewads", "autoloadad_secs");
	foreach ($vars as $k) {
		$db->query("UPDATE settings SET value='" . $db->real_escape_string($input->pc[$k]) . ("' WHERE field='" . $k . "'"));
	}

	$cache->delete("settings");
	serveranswer(1, "Settings updated");
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">General Settings</div>
<div class=\"site_content\">
<div id=\"tabs\">
	<ul>
    	<li><a href=\"#tabs-1\">Site Information</a></li>
        <li><a href=\"#tabs-2\">Members Related</a></li>
        <li><a href=\"#tabs-5\">Ad Clicks Settings</a>
        <li><a href=\"#tabs-3\">Maintenance</a></li>
        <li><a href=\"#tabs-4\">Mail</a></li>
    </ul>
    <div id=\"tabs-1\">
    <form method=\"post\" id=\"frm1\" onsubmit=\"return submitform(this.id);\">
    <input type=\"hidden\" name=\"do\" value=\"update1\" />
    <table width=\"100%\" class=\"widget-tbl\">
    	<tr>
        	<td align=\"right\" width=\"200\">Site Name:</td>
            <td><input type=\"text\" name=\"site_name\" value=\"";
echo $settings['site_name'];
echo "\" /></td>
        </tr>
        <tr>
            <td align=\"right\">Site Title:</td>
            <td><input name=\"site_title\" type=\"text\" value=\"";
echo $settings['site_title'];
echo "\" /> Windows Title</td>
        </tr>
        <tr>
            <td align=\"right\">Site URL:</td>
            <td><input name=\"site_url\" type=\"text\" value=\"";
echo $settings['site_url'];
echo "\" /> with the slash '/' in the end. Ex: http://www.ptcevolution.com/ </td>
        </tr>
        <tr>
            <td align=\"right\">E-mail Support:</td>
            <td><input name=\"email_support\" type=\"text\" value=\"";
echo $settings['email_support'];
echo "\" /> This email will be used for notifications to members</td>
        </tr>
        <tr>
            <td align=\"right\">Allow SSL?:</td>
            <td><input type=\"checkbox\" name=\"ssl_host\" value=\"yes\"  ";
echo $settings['ssl_host'] == "yes" ? "checked" : "";
echo " />
               Tick to enable - redirect to https when enabled</td>
        </tr>
        <tr>
            <td align=\"right\">Show site statistics:</td>
            <td><input type=\"checkbox\" name=\"site_stats\" value=\"yes\"  ";
echo $settings['site_stats'] == "yes" ? "checked" : "";
echo " />
            Tick to enable - show site stats on all pages when enabled</td>
        </tr>
        <tr>
            <td align=\"right\">Show users online in statistics:</td>
            <td><input type=\"checkbox\" name=\"usersonline\" value=\"1\"  ";
echo $settings['usersonline'] == "1" ? "checked" : "";
echo " />
            Tick to enable - it will show the total users online. <strong>Disable this option to save MySQL resources.</strong></td>
        </tr>
        <tr>
            <td align=\"right\">Show &quot;Proof of Payment&quot; page</td>
            <td><input type=\"checkbox\" name=\"payment_proof\" value=\"yes\" ";

if ($settings['payment_proof'] == "yes") {
	echo "checked";
}

echo " />
            Tick to enable - members and guests can see the lastest payments made on your site</td>
        </tr>
          <tr>
            <td align=\"right\">Max results per page</td>
            <td><input name=\"max_result_page\" type=\"text\" id=\"max_result_page\" value=\"";
echo $settings['max_result_page'];
echo "\" /> (Referrals, ads, etc)</td>
          </tr>
          <tr>
            <td align=\"right\">Time Zone:</td>
            <td>                            <select name=\"timezone\">
                            	<option value=\"\">-- Use System Default --</option>
                                ";
foreach ($timezone as $v) {

	if ($v == $settings['timezone']) {
		echo "<option selected>" . $v . "</option>
";
		continue;
	}

	echo "<option>" . $v . "</option>
";
}

echo "                            </select></td>
          </tr>
          <tr>
          	<td></td>
            <td><input type=\"submit\" name=\"btn\" value=\"Save\" /></td>
          </tr>
    </table>
    </form>
    </div>
    <div id=\"tabs-2\">
    <form method=\"post\" id=\"frm2\" onsubmit=\"return submitform(this.id);\">
    <input type=\"hidden\" name=\"do\" value=\"update2\" />
    <table width=\"100%\" class=\"widget-tbl\">
        <tr>
            <td align=\"right\">Require Email Verification:</td>
            <td><input type=\"checkbox\" name=\"register_activation\" value=\"yes\" ";
echo $settings['register_activation'] == "yes" ? "checked" : "";
echo " />
            Tick to enable - force users to verify their emails to activate their accounts.</td>
        </tr>
        <tr>
            <td align=\"right\">Require New Email Verification:</td>
            <td><input type=\"checkbox\" name=\"emailchange_activation\" value=\"yes\" ";
echo $settings['emailchange_activation'] == "yes" ? "checked" : "";
echo " />
            Tick to enable - force users to verify their new emails when they update their profiles</td>
        </tr>
        <tr>
        	<td align=\"right\">Allow members to withdraw with the same processors that made deposits</td>
            <td><input type=\"checkbox\" name=\"withdraw_sameprocessor\" value=\"yes\" ";
echo $settings['withdraw_sameprocessor'] == "yes" ? "checked" : "";
echo " /> This option is automatically disabled for members that did not make any deposit</td>
        </tr>
        <tr>
            <td align=\"right\">Max amount of days to set accounts as Inactive:</td>
            <td><input name=\"inactive_days\" type=\"text\" value=\"";
echo $settings['inactive_days'];
echo "\" /></td>
        </tr>
        <tr>
            <td align=\"right\">Money Tranfer:</td>
            <td><input type=\"checkbox\" name=\"money_transfer\" value=\"yes\" ";

if ($settings['money_transfer'] == "yes") {
	echo "checked";
}

echo " />
            Tick to enable - members can tranfer money from account balance to purchase balance</td>
        </tr>
        <tr>
            <td align=\"right\">Minimum amount to Tranfer:</td>
            <td>$<input type=\"text\" name=\"amount_transfer\" value=\"";
echo $settings['amount_transfer'];
echo "\" /></td>
        </tr>
        <tr>
            <td align=\"right\">Message System:</td>
            <td><input type=\"checkbox\" name=\"message_system\" value=\"yes\" ";

if ($settings['message_system'] == "yes") {
	echo "checked";
}

echo " />
            Tick to enable - members can send messages between them</td>
        </tr>
        <tr>
            <td align=\"right\">Message per Page:</td>
            <td><input type=\"text\" name=\"message_per_page\" value=\"";
echo $settings['message_per_page'];
echo "\" /></td>
        </tr>
        <tr>
            <td align=\"right\">Allow members to cancel pending withdrawal:</td>
            <td><input type=\"checkbox\" name=\"cancel_pendingwithdraw\" value=\"yes\" ";

if ($settings['cancel_pendingwithdraw'] == "yes") {
	echo "checked";
}

echo " />
            Tick to enable - members can cancel their pending withdrawal and get money back to thei main balance.</td>
        </tr>
          <tr>
          	<td></td>
            <td><input type=\"submit\" name=\"btn\" value=\"Save\" /></td>
          </tr>
    </table>
    </form>
    </div>
    <div id=\"tabs-5\">
    <form method=\"post\" id=\"frm5\" onsubmit=\"return submitform(this.id);\">
    <input type=\"hidden\" name=\"do\" value=\"update5\" />
    <table width=\"100%\" class=\"widget-tbl\">
        <tr>
            <td align=\"right\">Minimum clicks needed to cashout:</td>
            <td><input name=\"withdraw_clicks\" type=\"text\" class=\"input_text2\" value=\"";
echo $settings['withdraw_clicks'];
echo "\" />
              (0 = disabled)</td>
        </tr>
        <tr>
            <td align=\"right\">Requires make clicks today to earn tomorrow:</td>
            <td><input type=\"checkbox\" name=\"click_yesterday\" value=\"yes\" ";

if ($settings['click_yesterday'] == "yes") {
	echo "checked";
}

echo " />
            Tick to enable - force users to make clicks today to earn from referrals tomorrow</td>
        </tr>
        <tr>
            <td align=\"right\">Clicks necessary to earn from referrals tomorrow:</td>
            <td><input name=\"clicks_necessary\" type=\"text\" value=\"";
echo $settings['clicks_necessary'];
echo "\" /></td>
        </tr>
        <tr>
            <td align=\"right\">Force user to view ads:</td>
            <td><input type=\"checkbox\" name=\"force_viewads\" value=\"1\" ";
echo $settings['force_viewads'] == 1 ? "checked" : "";
echo " /> Timer will stop if user change of window</td>
        </tr>
        <tr>
            <td align=\"right\">Seconds to autorun surfbar if ad is slow:</td>
            <td><input type=\"text\" name=\"autoloadad_secs\" value=\"";
echo $settings['autoloadad_secs'];
echo "\" /> seconds (0 <= disabled)</td>
        </tr>
          <tr>
          	<td></td>
            <td><input type=\"submit\" name=\"btn\" value=\"Save\" /></td>
          </tr>
    </table>
    </form>
    </div>

    <div id=\"tabs-3\">
    <form method=\"post\" id=\"frm3\" onsubmit=\"return submitform(this.id);\">
    <input type=\"hidden\" name=\"do\" value=\"update3\" />
    <table width=\"100%\" class=\"widget-tbl\">
        <tr>
            <td align=\"right\">Maintenance Mode:</td>
            <td><input type=\"checkbox\" name=\"maintenance\" value=\"yes\" ";

if ($settings['maintenance'] == "yes") {
	echo "checked";
}

echo " />
              Tick to enable - turns site off when enabled</td>
        </tr>
        <tr>
            <td align=\"right\">Maintenance Mode Message:</td>
            <td><input name=\"maintenance_msg\" type=\"text\" value=\"";
echo $settings['maintenance_msg'];
echo "\" /></td>
        </tr>
          <tr>
          	<td></td>
            <td><input type=\"submit\" name=\"btn\" value=\"Save\" /></td>
          </tr>
    </table>
    </form>
    </div>

    <div id=\"tabs-4\">
    <script type=\"text/javascript\">
	$(function(){
		mailtypeverification();
	});

	function mailtypeverification(){
		mailtype = $(\"#email_type\").val();
		if(mailtype == 'smtp'){
			$(\"#smtp_details\").show();
		}else{
			$(\"#smtp_details\").hide();
		}
	}
	</script>
    <form id=\"mailfrmsettings\" method=\"post\" onsubmit=\"return submitform(this.id);\">
    <input type=\"hidden\" name=\"do\" value=\"update4\" />
    <table width=\"100%\" class=\"widget-tbl\">
    	<tr>
        	<td align=\"right\" width=\"200\">System Emails From Name</td>
            <td><input type=\"text\" name=\"email_from_name\" value=\"";
echo $mail_settings['email_from_name'];
echo "\" /></td>
        </tr>
    	<tr>
        	<td align=\"right\" width=\"200\">System Emails From Email</td>
            <td><input type=\"text\" name=\"email_from_address\" value=\"";
echo $mail_settings['email_from_address'];
echo "\" /></td>
        </tr>
    	<tr>
        	<td align=\"right\">Mail Type</td>
            <td><select name=\"email_type\" id=\"email_type\" onchange=\"mailtypeverification();\">
            		<option value=\"php\" ";
echo $mail_settings['email_type'] == "php" ? "selected" : "";
echo ">PHP Mail()</option>
                    <option value=\"smtp\" ";
echo $mail_settings['email_type'] == "smtp" ? "selected" : "";
echo ">SMTP</option>
            	</select>
            </td>
        </tr>
        <tbody id=\"smtp_details\" style=\"display:none\">
    	<tr>
        	<td align=\"right\">SMTP Port</td>
            <td><input type=\"text\" name=\"smtp_port\" value=\"";
echo $mail_settings['smtp_port'];
echo "\" /> The port your mail server uses</td>
        </tr>
    	<tr>
        	<td align=\"right\">SMTP Host</td>
            <td><input type=\"text\" name=\"smtp_host\" value=\"";
echo $mail_settings['smtp_host'];
echo "\" /></td>
        </tr>
    	<tr>
        	<td align=\"right\">SMTP Username</td>
            <td><input type=\"text\" name=\"smtp_username\" value=\"";
echo $mail_settings['smtp_username'];
echo "\" /></td>
        </tr>
    	<tr>
        	<td align=\"right\">SMTP Password</td>
            <td><input type=\"password\" name=\"smtp_password\" value=\"";
echo $mail_settings['smtp_password'];
echo "\" /></td>
        </tr>
    	<tr>
        	<td align=\"right\">SMTP SSL Type</td>
            <td>
            	<label><input type=\"radio\" name=\"smtp_ssl\" value=\"\" ";
echo $mail_settings['smtp_ssl'] == "" ? "checked" : "";
echo "  /> None</label>
                <label><input type=\"radio\" name=\"smtp_ssl\" value=\"ssl\" ";
echo $mail_settings['smtp_ssl'] == "ssl" ? "checked" : "";
echo " /> SSL</label>
                <label><input type=\"radio\" name=\"smtp_ssl\" value=\"tls\" ";
echo $mail_settings['smtp_ssl'] == "tls" ? "checked" : "";
echo " /> TLS</label>
             </td>
        </tr>
        </tbody>
        <tr>
        	<td></td>
            <td><input type=\"submit\" name=\"btn\" value=\"Save\" /></td>
        </tr>
    </table>
    </form>
    </div>
</div>

</div>
";
include SOURCES . "footer.php";
echo " ";
?>
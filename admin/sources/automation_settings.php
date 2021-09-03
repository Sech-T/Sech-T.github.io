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

$query = $db->query("SELECT * FROM cron_settings");

while ($result = $db->fetch_array($query)) {
	$cron[$result['field']] = $result['value'];
}


if ($input->p['do'] == "update") {
	verifyajax();
	verifydemo();
	$set = array("reset_ptc", "delete_inactive", "suspend_inactive", "delete_ptc", "delete_fads", "delete_flinks", "delete_bannerads");
	foreach ($set as $k) {
		$updarray = array("value" => $input->pc[$k]);
		$db->update("cron_settings", $updarray, ("field='" . $k . "'"));
	}

	serveranswer(1, "Settings were updated.");
}
else {
	if ($input->p['do'] == "execute") {
		verifyajax();
		verifydemo();
		$todaysdate = date("Y-m-d");
		$the_day = strftime("%Y-%m-%d", strtotime($todaysdate . " + 1 days ago"));
		$delete_logs = TIMENOW - 60 * 60 * 24 * 7;
		include ADMINPATH . "cronadmin.php";
		serveranswer(1, "Cron was successfully executed.");
	}
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Automation Settings</div>
<div class=\"site_content\">
	<div class=\"widget-title\">Status</div>
    <div class=\"widget-content\">
        <table width=\"100%\" class=\"widget-tbl\">
          <tr>
            <td width=\"150\" align=\"right\">Last time ads reset:</td>
            <td valign=\"top\"><strong>";
echo $cron['last_cron'];
echo "</strong></td>
          </tr>
          <tr>
            <td colspan=\"2\">    <div align=\"center\">Create the following Cron Job using WGET:<br />
                <input type=\"text\" style=\"width:90%\" value=\"0 0 * * * wget -O - -q -t 1 ";
echo $settings['site_url'];
echo "cron.php\" /><br />
                <input type=\"text\" style=\"width:90%\" value=\"30 9 * * * wget -O - -q -t 1 ";
echo $settings['site_url'];
echo "cron_ads.php\" /><br />
                <input type=\"text\" style=\"width:90%\" value=\"30 15 * * * wget -O - -q -t 1 ";
echo $settings['site_url'];
echo "cron_clean.php\" /><br />
        <strong>OR</strong><br />
        Create the following Cron Job using CURL:<br />
                <input type=\"text\" style=\"width:90%\" value=\"0 0 * * * curl  ";
echo $settings['site_url'];
echo "cron.php\" /><br />
                <input type=\"text\" style=\"width:90%\" value=\"30 9 * * * curl ";
echo $settings['site_url'];
echo "cron_ads.php\" /><br />
                <input type=\"text\" style=\"width:90%\" value=\"30 15 * * * curl ";
echo $settings['site_url'];
echo "cron_clean.php\" />
            </div></td>
            </tr>
        </table>
    </div>

    <div class=\"widget-title\">Automatic Module Functions</div>
    <div class=\"widget-content\">
        <form method=\"post\" id=\"frm1\" onsubmit=\"return submitform(this.id);\">
        <table class=\"widget-tbl\" width=\"100%\">
          <tr>
            <td align=\"right\">Reset PTC Ads:</td>
            <td><input name=\"reset_ptc\" type=\"checkbox\" id=\"reset_ptc\" value=\"yes\" ";

if ($cron['reset_ptc'] == "yes") {
	echo "checked";
}

echo " />
        Tick this box to enable reset ptc advertisements</td>
          </tr>

          <tr>
            <td align=\"right\">Delete Inactive Members:</td>
            <td><input name=\"delete_inactive\" type=\"checkbox\" value=\"yes\" ";

if ($cron['delete_inactive'] == "yes") {
	echo "checked";
}

echo " />
              Tick this box to enable delete inactive members</td>
          </tr>
          <tr>
            <td align=\"right\">Suspend Inactive Members:</td>
            <td><input name=\"suspend_inactive\" type=\"checkbox\" id=\"suspend_inactive\" value=\"yes\" ";

if ($cron['suspend_inactive'] == "yes") {
	echo "checked";
}

echo " />
        Tick this box to enable suspend inactive members</td>
          </tr>

          <tr>
            <td align=\"right\">Delete Inactive/Expired PTC Ads:</td>
            <td><input name=\"delete_ptc\" type=\"checkbox\" id=\"delete_ptc\" value=\"yes\" ";

if ($cron['delete_ptc'] == "yes") {
	echo "checked";
}

echo " />
        Tick this box to enable delete inactive/expired PTC Ads</td>
          </tr>
          <tr>
            <td align=\"right\">Delete Inactive/Expired Featured Ads:</td>
            <td valign=\"top\"><input name=\"delete_fads\" type=\"checkbox\" id=\"delete_fads\" value=\"yes\" ";

if ($cron['delete_fads'] == "yes") {
	echo "checked";
}

echo " />
        Tick this box to enable delete inactive/expired Featured Ads</td>
          </tr>
          <tr>
            <td align=\"right\">Delete Inactive/Expired Featured Link Ads:</td>
            <td valign=\"top\"><input name=\"delete_flinks\" type=\"checkbox\" id=\"delete_flinks\" value=\"yes\" ";

if ($cron['delete_flinks'] == "yes") {
	echo "checked";
}

echo " />
        Tick this box to enable delete inactive/expired Featured Link Ads</td>
          </tr>
          <tr>
            <td align=\"right\">Delete Inactive/Expired Banner Ads:</td>
            <td valign=\"top\"><input name=\"delete_bannerads\" type=\"checkbox\" id=\"delete_bannerads\" value=\"yes\" ";

if ($cron['delete_bannerads'] == "yes") {
	echo "checked";
}

echo " />
        Tick this box to enable delete inactive/expired Banner Ads</td>
          </tr>
          <tr>
            <td align=\"right\">Delete Inactive/Expired Login Ads:</td>
            <td><input name=\"delete_loginads\" type=\"checkbox\" id=\"delete_loginads\" value=\"yes\" ";

if ($cron['delete_loginads'] == "yes") {
	echo "checked";
}

echo " />
        Tick this box to enable delete inactive/expired Login Ads</td>
          </tr>
          <tr>
          	<td></td>
            <td>
            <input type=\"hidden\" name=\"do\" value=\"\" id=\"doaction\" />
        <input type=\"submit\" name=\"btn\" value=\"Save\" onclick=\"updfrmvars({'doaction': 'update'});\" />

        <input type=\"submit\" name=\"btn\" value=\"Execute Cron\" onclick=\"updfrmvars({'doaction': 'execute'});\" />
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
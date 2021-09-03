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


if (!$admin->permissions['utilities']) {
	header("location: ./");
	exit();
}


if ($input->p['do'] == "update") {
	verifyajax();
	verifydemo();
	$data = array("googleanalytics" => $input->pc['googleanalytics'], "googleanalyticsid" => $input->pc['googleanalyticsid']);
	foreach ($data as $field => $value) {
		$db->query(("UPDATE settings SET value='" . $value . "' WHERE field='" . $field . "'"));
	}

	$cache->delete("settings");
	serveranswer(1, "Google Analytics were updated");
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Google Analytics</div>
<div class=\"site_content\">
<div class=\"info_box\">You should enter your <strong>Account ID</strong> from google analytics. If you need a fresh copy of your code, go to your google analytics account and click the <strong>Edit</strong> link next to the appropriate profile on the <strong>Analytics Settings</strong>  page, then select <strong>Check Status</strong> at the top-right of the table.
</div>
<form method=\"post\" id=\"frm1\" onsubmit=\"return submitform(this.id);\">
<input type=\"hidden\" name=\"do\" value=\"update\" />
<table class=\"widget-tbl\" width=\"100%\">
  <tr>
    <td align=\"right\">Integrate Google Analytics</td>
    <td><input type=\"checkbox\" name=\"googleanalytics\" value=\"yes\" ";

if ($settings['googleanalytics'] == "yes") {
	echo "checked";
}

echo " />
Tick to enable - add the code to integrate Google Analytics to your site</td>
  </tr>
  <tr>
    <td align=\"right\">Account ID</td>
    <td><input type=\"text\" name=\"googleanalyticsid\" id=\"googleanalyticsid\" value=\"";
echo $settings['googleanalyticsid'];
echo "\" style=\"width:200px\" />
      Example: UA-13583232</td>
  </tr>
  <tr>
  	<td></td>
  	<td>
    <input type=\"submit\" name=\"save\" value=\"Save\" class=\"orange\" />
    </td>
  </tr>
</table>
</form>


</div>


        ";
include SOURCES . "footer.php";
echo " ";
?>
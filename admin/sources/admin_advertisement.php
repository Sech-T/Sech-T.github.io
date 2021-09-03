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
	$ad_expires = daterange($input->rc['ad_expires']);
	$ad_expires = $ad_expires[1];
	$datastored = array("ad_title" => $input->pc['ad_title'], "ad_descr" => $input->pc['ad_descr'], "ad_url" => $input->p['ad_url'], "ad_time" => $input->pc['ad_time'], "ad_expires" => $ad_expires);
	$upd = $db->update("admin_advertisement", $datastored);

	if ($input->p['forceAd'] == "yes") {
		$upd = $db->query("UPDATE members SET adminad=0");
	}

	serveranswer(1, "Admin Advertisements was updated.");
}

$admin_ad = $db->fetchRow("SELECT * FROM admin_advertisement");
include SOURCES . "header.php";
echo "<div class=\"site_title\">Admin Advertisement</div>
<div class=\"site_content\">
	<div class=\"info_box\"><strong>Note:</strong> Using this tool, members must click the &quot;admin adverisement&quot; to unlock the others. Members do not receive money for viewing this ad.<br />If you wish to deactivate it, select a &quot;Ad Expires&quot; date prior to current date</div>
<form method=\"post\" id=\"formcontent\" onsubmit=\"return submitform(this.id)\">
<input type=\"hidden\" name=\"do\" value=\"update\">
<table class=\"widget-tbl\" width=\"100%\">
  <tr>
    <td width=\"200\" align=\"right\">Ad Title:</td>
    <td><input type=\"text\" name=\"ad_title\" style=\"width:300px\" value=\"";
echo $admin_ad['ad_title'];
echo "\" /> </td>
  </tr>
  <tr>
    <td align=\"right\">Ad Description:</td>
    <td><input type=\"text\" name=\"ad_descr\" style=\"width:300px\" value=\"";
echo $admin_ad['ad_descr'];
echo "\" /> </td>
  </tr>
  <tr>
    <td align=\"right\">Ad URL:</td>
    <td><input type=\"text\" name=\"ad_url\" style=\"width:300px\" value=\"";
echo $admin_ad['ad_url'];
echo "\" /> </td>
  </tr>
  <tr>
    <td align=\"right\">Ad Seconds</td>
    <td><input type=\"text\" name=\"ad_time\" style=\"width:300px\" value=\"";
echo $admin_ad['ad_time'];
echo "\" /></td>
  </tr>
  <tr>
    <td align=\"right\">Ad Expires:</td>
    <td><input type=\"text\" name=\"ad_expires\" value=\"";
echo date("m/d/Y", $admin_ad['ad_expires']);
echo "\" class=\"datepicker\" /></td>
  </tr>

  <tr>
    <td align=\"right\">Force to view this ad right now</td>
    <td><input type=\"checkbox\" name=\"forceAd\" value=\"yes\" checked=\"checked\" /></td>
  </tr>
  <tr>
  	<td></td>
    <td><input type=\"submit\" name=\"save\" value=\"Update\" /></td>
  </tr>
</table>
</form>

</div>
        ";
include SOURCES . "footer.php";
echo " ";
?>
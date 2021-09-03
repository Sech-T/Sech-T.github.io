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
	$multi_registration = $input->pc['multi_registration'];
	$multi_login = $input->pc['multi_login'];
	$multi_country = $input->pc['multi_country'];
	$data = array("multi_registration" => $multi_registration, "multi_login" => $multi_login, "multi_country" => $multi_country);
	foreach ($data as $field => $value) {
		$db->query(("UPDATE settings SET value='" . $value . "' WHERE field='" . $field . "'"));
	}

	serveranswer(1, "Settings were updated.");
	$cache->delete("settings");
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Multiple IP Settings</div>
<div class=\"site_content\">
<form method=\"post\" id=\"formcontent\" onsubmit=\"return submitform(this.id);\">
<input type=\"hidden\" name=\"do\" value=\"update\" />
<table class=\"widget-tbl\" width=\"100%\">
  <tr>
    <td width=\"200\" align=\"right\">Deny multi-ip registration:</td>
    <td><input type=\"checkbox\" name=\"multi_registration\" value=\"yes\" ";

if ($settings['multi_registration'] == "yes") {
	echo "checked";
}

echo " />
Tick to enable - deny new registrations with same IP</td>
  </tr>
  <tr>
    <td align=\"right\">Deny login with same IP:</td>
    <td><input type=\"checkbox\" name=\"multi_login\" value=\"yes\" ";

if ($settings['multi_login'] == "yes") {
	echo "checked";
}

echo " />
Tick to enable - deny login if current IP is already used by other member</td>
  </tr>
  <tr>
    <td align=\"right\">Deny different Country:</td>
    <td><input type=\"checkbox\" name=\"multi_country\" value=\"yes\" ";

if ($settings['multi_country'] == "yes") {
	echo "checked";
}

echo " />
Tick to enable - deny login if country of registration is different to the country of login. This feature works properly if IP database is updated monthly from IP2Nation</td>
  </tr>
  <tr>
  	<td></td>
  	<td>
    <input type=\"submit\" name=\"save\" value=\"Save\" />
    </td>
  </tr>
</table>
</form>


</div>


        ";
include SOURCES . "footer.php";
echo " ";
?>
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


if ($input->p['a'] == "create") {
	verifyajax();
	verifydemo();
	$required_fields = array("title", "url", "membership", "country", "advalue", "credits");
	foreach ($required_fields as $k) {

		if (!$input->pc[$k]) {
			serveranswer(0, "One of the required field(s) is empty");
			continue;
		}
	}

	foreach ($input->p['country'] as $k => $v) {
		$countries .= $v . ",";
	}

	$memberships = ",";
	foreach ($input->p['membership'] as $k => $v) {
		$memberships .= $v . ",";
	}

	$myadvalue = $db->fetchRow(("SELECT * FROM ad_value WHERE id='" . $input->p['advalue'] . "'"));
	$data = array("token" => md5($input->pc['title'] . $input->pc['subtitle'] . time()), "title" => $input->pc['title'], "descr" => $input->pc['subtitle'], "img" => $input->pc['img'], "url" => $input->p['url'], "value" => $myadvalue['value'], "time" => $myadvalue['time'], "category" => $myadvalue['id'], "membership" => $memberships, "click_pack" => $input->pc['credits'], "clicks" => 0, "outside_clicks" => 0, "country" => $countries, "status" => "Active", "clicks_day" => $input->pc['clicks_day']);
	$insert = $db->insert("ads", $data);
	serveranswer(2, "New ptc was successfully created. <a href='?view=manageptc'>Click here to manage your ads.</a>");
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Add a New PTC Ad</div>
<div class=\"site_content\">
<form method=\"post\" id=\"ptcform\" onsubmit=\"return submitform(this.id);\">
<input type=\"hidden\" name=\"a\" value=\"create\" />
<table class=\"widget-tbl\" width=\"100%\">
  <tr>
    <td width=\"150\">Title</td>
    <td><input name=\"title\" type=\"text\" id=\"title\" /></td>
    </tr>
  <tr>
    <td>Subtitle</td>
    <td><input name=\"subtitle\" type=\"text\" id=\"subtitle\" maxlength=\"80\" /></td>
  </tr>
  <tr>
    <td>Target URL</td>
    <td><input name=\"url\" type=\"text\" id=\"url\" value=\"http://\" /></td>
  </tr>
  <tr>
    <td>Image URL (optional)</td>
    <td><input name=\"img\" type=\"text\" id=\"img\" value=\"http://\" /></td>
  </tr>
  <tr>
    <td>Target Membership</td>
    <td>
    <div class=\"widget-title\"><input type=\"checkbox\" name=\"membership_all\" value=\"all\" id=\"checkall\" />All Memberships</div>
    <div class=\"widget-content\" style=\"overflow:auto; height:75px; background:#FFFFFF\">
    	";
$memlist = $db->query("SELECT id, name FROM membership ORDER BY id ASC");

while ($row = $db->fetch_array($memlist)) {
	$vermembership = strpos($data['membership'], "," . $row['id'] . ",");
	echo "<input type=\"checkbox\" name=\"membership[]\" value=\"" . $row['id'] . "\" class=\"checkall\" /> " . $row['name'] . "<br />";
}

echo "    </div>
	</td>
  </tr>
  <tr>
    <td>Target Country</td>
    <td>
    <div class=\"widget-title\"><input type=\"checkbox\" name=\"country_all\" value=\"all\" id=\"checkall2\" />All Countries</div>
        <div class=\"widget-content\" style=\"overflow:auto; height:100px; background:#FFFFFF\">
        ";
$listcountry = $db->query("SELECT * FROM ip2nationCountries ORDER BY country ASC");

while ($country = $db->fetch_array($listcountry)) {
	echo "<input type=\"checkbox\" name=\"country[]\" value=\"" . $country['country'] . "\" class=\"checkall2\" /> " . $country['country'] . "<br />";
}

echo "        </div>   </td>
  </tr>
  <tr>
    <td>Add Value</td>
    <td><select name=\"advalue\" id=\"advalue\">
      ";
$valuelist = $db->query("SELECT * FROM ad_value ORDER BY value ASC");

while ($advalue = $db->fetch_array($valuelist)) {
	echo "<option value=\"" . $advalue['id'] . "\">\$" . $advalue['value'] . " - " . $advalue['time'] . " seconds (" . $advalue['catname'] . ")</option>";
}

echo "    </select></td>
  </tr>
  <tr>
    <td>Credits</td>
    <td><input name=\"credits\" type=\"text\" id=\"credits\" value=\"0\" /></td>
  </tr>
  <tr>
    <td>Maximum clicks per day</td>
    <td><input name=\"clicks_day\" type=\"text\" value=\"0\" /> (0 = disabled)</td>
  </tr>
  <tr>
  	<td></td>
    <td>
	<input type=\"submit\" name=\"create\" value=\"Send\" />
    </td>
  </tr>
</table>
</form>
</div>
        ";
include SOURCES . "footer.php";
echo " ";
?>
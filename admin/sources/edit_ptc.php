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

$data = $db->fetchRow("SELECT * FROM ads WHERE id=" . $input->gc['edit']);

if ($input->p['a'] == "update") {
	verifyajax();
	verifydemo();
	$required_fields = array("title", "url", "membership", "country");
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
	$set = array("token" => md5($input->pc['title'] . $input->pc['subtitle'] . TIMENOW), "title" => $input->pc['title'], "descr" => $input->pc['subtitle'], "img" => $input->pc['img'], "url" => $input->p['url'], "value" => $myadvalue['value'], "time" => $myadvalue['time'], "category" => $myadvalue['id'], "membership" => $memberships, "click_pack" => $input->pc['credits'], "country" => $countries, "clicks_day" => $input->pc['clicks_day']);
	$upd = $db->update("ads", $set, "id=" . $data['id']);
	serveranswer(3, "PTC ad was succesffully updated.");
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">PTC Ad: Edit</div>
<div class=\"site_content\">
<form method=\"post\" id=\"ptcform\" onsubmit=\"return submitform(this.id);\">
<input type=\"hidden\" name=\"a\" value=\"update\" />
<table width=\"100%\" class=\"widget-tbl\">
  <tr>
    <td width=\"150\">Title</td>
    <td><input name=\"title\" type=\"text\" id=\"title\" value=\"";
echo $data['title'];
echo "\" /></td>
    </tr>
  <tr>
    <td>Subtitle</td>
    <td><input name=\"subtitle\" type=\"text\" id=\"subtitle\" value=\"";
echo $data['descr'];
echo "\" maxlength=\"80\" /></td>
  </tr>
  <tr>
    <td>Target URL</td>
    <td><input name=\"url\" type=\"text\" id=\"url\" value=\"";
echo $data['url'];
echo "\" /></td>
  </tr>
  <tr>
    <td>Image URL (optional)</td>
    <td><input name=\"img\" type=\"text\" id=\"img\" value=\"";
echo $data['img'];
echo "\" /></td>
  </tr>
  <tr>
    <td>Target Membership</td>
    <td>
    <div class=\"widget-title\"><input type=\"checkbox\" name=\"membership_all\" value=\"all\" id=\"checkall\" />All Memberships</div>
    <div class=\"widget-content\" style=\"background:#FFFFFF; overflow:auto; height:75px;\">
    	";
$memlist = $db->query("SELECT id, name FROM membership ORDER BY id ASC");

while ($row = $db->fetch_array($memlist)) {
	$vermembership = strpos($data['membership'], "," . $row['id'] . ",");

	if ($vermembership === false) {
		echo "<input type=\"checkbox\" name=\"membership[]\" value=\"" . $row['id'] . "\" class=\"checkall\" /> " . $row['name'] . "<br />";
	}
  else {
	 echo "<input type=\"checkbox\" name=\"membership[]\" value=\"" . $row['id'] . "\" class=\"checkall\" checked /> " . $row['name'] . "<br />";
  }
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
$ad_countries = explode(",", $data['country']);

while ($country = $db->fetch_array($listcountry)) {
	if (!in_array($country['country'], $ad_countries)) {
		echo "<input type=\"checkbox\" name=\"country[]\" value=\"" . $country['country'] . "\" class=\"checkall2\" /> " . $country['country'] . "<br />";
	}
  else {
	 echo "<input type=\"checkbox\" name=\"country[]\" value=\"" . $country['country'] . "\" class=\"checkall2\" checked /> " . $country['country'] . "<br />";
  }
}

echo "        </div>   </td>
  </tr>
  <tr>
    <td>Add Value</td>
    <td><select name=\"advalue\" id=\"advalue\">
      ";
$valuelist = $db->query("SELECT * FROM ad_value ORDER BY value ASC");

while ($advalue = $db->fetch_array($valuelist)) {
	if ($advalue['value'] == $data['value'] && $advalue['time'] == $data['time']) {
		echo "<option value=\"" . $advalue['id'] . "\" selected>\$" . $advalue['value'] . " - " . $advalue['time'] . " seconds (" . $advalue['catname'] . ")</option>";
	}
  else {
	 echo "<option value=\"" . $advalue['id'] . "\">\$" . $advalue['value'] . " - " . $advalue['time'] . " seconds (" . $advalue['catname'] . ")</option>";
  }
}

echo "    </select></td>
  </tr>
  <tr>
    <td>Credits</td>
    <td><input name=\"credits\" type=\"text\" id=\"credits\" value=\"";
echo $data['click_pack'];
echo "\" /></td>
  </tr>
  <tr>
    <td>Maximum clicks per day</td>
    <td><input name=\"clicks_day\" type=\"text\" value=\"";
echo $data['clicks_day'];
echo "\" /> (0 = disabled)</td>
  </tr>
  <tr>
  	<td></td>
    <td>
	<input type=\"submit\" name=\"create\" value=\"Update\" />
    <input type=\"button\" name=\"btn\" value=\"Return\" onclick=\"history.back();\" />
    </td>
  </tr>
</table>
</form>
</div>

        ";
include SOURCES . "footer.php";
echo " ";
?>
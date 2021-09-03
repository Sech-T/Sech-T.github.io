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
	$required_fields = array("title", "url", "banner", "credits");
	foreach ($required_fields as $k) {

		if (!$input->p[$k]) {
			serveranswer(0, "One of the required field(s) is empty.");
			continue;
		}
	}

	$data = array("title" => $input->pc['title'], "url" => $input->p['url'], "img" => $input->p['banner'], "credits" => $input->pc['credits'], "status" => "Active");
	$insert = $db->insert("banner_ads", $data);
	serveranswer(2, "New banner ad was successfully created. <a href='?view=managebannerad'>Click here to manage your ads.</a>");
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Add a New Banner Ad</div>
<div class=\"site_content\">
<form method=\"post\" id=\"banneradsform\" onsubmit=\"return submitform(this.id);\">
<input type=\"hidden\" name=\"a\" value=\"create\" />
<table class=\"widget-tbl\" width=\"100%\">
  <tr>
    <td width=\"100\">Title</td>
    <td><input name=\"title\" type=\"text\" id=\"title\" /></td>
    </tr>
  <tr>
    <td>Target URL</td>
    <td><input name=\"url\" type=\"text\" id=\"url\" value=\"http://\" /></td>
  </tr>
  <tr>
    <td>Banner URL</td>
    <td><input name=\"banner\" type=\"text\" id=\"banner\" value=\"http://\" /></td>
  </tr>
  <tr>
    <td>Credits</td>
    <td><input name=\"credits\" type=\"text\" id=\"credits\" value=\"0\" /></td>
  </tr>
  <tr>
  	<td></td>
  	<td>
    <input type=\"submit\" name=\"create\" value=\"Send\" class=\"orange\" />
    </td>
  </tr>
</table>
</form>
</div>
        ";
include SOURCES . "footer.php";
echo " ";
?>
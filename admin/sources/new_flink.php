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
	$required_fields = array("title", "url", "expires");
	foreach ($required_fields as $k) {

		if (!$input->p[$k]) {
			serveranswer(0, "One of the required field(s) is empty.");
			continue;
		}
	}

	$daterange = daterange($input->pc['expires']);
	$expires = $daterange[1];
	$data = array("title" => $input->pc['title'], "url" => $input->p['url'], "expires" => $expires, "status" => "Active");
	$insert = $db->insert("featured_link", $data);
	serveranswer(2, "New featured link ad was successfully created. <a href='./?view=manageflink'>Click here to manage your ads.</a>");
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Add a New Featured Link Ad</div>
<div class=\"site_content\">
<form method=\"post\" id=\"flinksform\" onsubmit=\"return submitform(this.id);\">
<input type=\"hidden\" name=\"a\" value=\"create\" />
<table class=\"widget-tbl\" width=\"100%\">
  <tr>
    <td width=\"150\">Title</td>
    <td><input name=\"title\" type=\"text\" id=\"title\" /></td>
    </tr>
  <tr>
    <td>Target URL</td>
    <td><input name=\"url\" type=\"text\" id=\"url\" value=\"http://\" /></td>
  </tr>
  <tr>
    <td>Expiration</td>
    <td><input name=\"expires\" type=\"text\" id=\"credits\" placeholder=\"mm/dd/yyyy\" class=\"datepicker\" /></td>
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
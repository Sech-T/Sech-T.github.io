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

$data = $db->fetchRow("SELECT * FROM featured_ads WHERE id=" . $input->gc['edit']);

if ($input->p['a'] == "update") {
	verifyajax();
	verifydemo();
	$required_fields = array("title", "url", "ad", "credits");
	foreach ($required_fields as $k) {

		if (!$input->pc[$k]) {
			serveranswer(0, "One of the required field(s) is empty");
			continue;
		}
	}

	$set = array("title" => $input->pc['title'], "url" => $input->p['url'], "ad" => $input->pc['ad'], "credits" => $input->pc['credits']);
	$insert = $db->update("featured_ads", $set, "id=" . $data['id']);
	serveranswer(1, "Featured ad was succesffully updated.");
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Featured Ad: Edit</div>
<div class=\"site_content\">
<form method=\"post\" id=\"fadsform\" onsubmit=\"return submitform(this.id);\">
<input type=\"hidden\" name=\"a\" value=\"update\" />
<table width=\"100%\" class=\"widget-tbl\">
  <tr>
    <td width=\"100\">Title</td>
    <td><input name=\"title\" type=\"text\" id=\"title\" value=\"";
echo $data['title'];
echo "\" /></td>
    </tr>
  <tr>
    <td>Target URL</td>
    <td><input name=\"url\" type=\"text\" id=\"url\" value=\"";
echo $data['url'];
echo "\" /></td>
  </tr>
  <tr>
    <td>Ad</td>
    <td><textarea name=\"ad\" id=\"textarea\" cols=\"45\" rows=\"5\">";
echo $data['ad'];
echo "</textarea></td>
  </tr>
  <tr>
    <td>Credits</td>
    <td><input name=\"credits\" type=\"text\" id=\"credits\" value=\"";
echo $data['credits'];
echo "\" /></td>
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
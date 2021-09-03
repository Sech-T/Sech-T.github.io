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

$data = $db->fetchRow("SELECT * FROM featured_link WHERE id=" . $input->gc['edit']);

if ($input->p['a'] == "update") {
	verifyajax();
	verifydemo();
	$required_fields = array("title", "url", "expires");
	foreach ($required_fields as $k) {

		if (!$input->pc[$k]) {
			serveranswer(0, "One of the required field(s) is empty");
			continue;
		}
	}

	$daterange = daterange($input->pc['expires']);
	$expires = $daterange[1];

	if (TIMENOW < $expires) {
		$status = "Active";
	}
	else {
		$status = $data['status'];
	}

	$set = array("title" => $input->pc['title'], "url" => $input->p['url'], "expires" => $expires, "status" => $status);
	$insert = $db->update("featured_link", $set, "id=" . $data['id']);
	serveranswer(1, "Featured Link ad was succesffully updated.");
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Featured Link Ad: Edit</div>
<div class=\"site_content\">
	<form method=\"post\" id=\"flinksform\" onsubmit=\"return submitform(this.id);\">
    <input type=\"hidden\" name=\"a\" value=\"update\" />
    <table class=\"widget-tbl\" width=\"100%\">
      <tr>
        <td width=\"150\">Title</td>
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
        <td>Expiration</td>
        <td><input name=\"expires\" type=\"text\" id=\"credits\" value=\"";
echo date("m/d/Y", $data['expires']);
echo "\" class=\"datepicker\" /></td>
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
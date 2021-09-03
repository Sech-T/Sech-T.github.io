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

$data = $db->fetchRow("SELECT * FROM banner_ads WHERE id=" . $input->gc['edit']);

if ($input->p['a'] == "update") {
	verifyajax();
	verifydemo();
	$required_fields = array("title", "url", "banner", "credits");
	foreach ($required_fields as $k) {

		if (!$input->pc[$k]) {
			serveranswer(0, "One of the required field(s) is empty");
			continue;
		}
	}

	$set = array("title" => $input->pc['title'], "url" => $input->p['url'], "img" => $input->p['banner'], "credits" => $input->pc['credits'], "status" => "Active");
	$insert = $db->update("banner_ads", $set, "id=" . $data['id']);
	serveranswer(1, "Banner ad was succesffully updated.");
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Banner Ad: Edit</div>

<div class=\"site_content\">
    <form method=\"post\" id=\"banneradsform\" onsubmit=\"return submitform(this.id);\">
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
        <td>Banner URL</td>
        <td><input name=\"banner\" type=\"text\" id=\"banner\" value=\"";
echo $data['img'];
echo "\" /></td>
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
        <input type=\"submit\" name=\"create\" value=\"Send\" />

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
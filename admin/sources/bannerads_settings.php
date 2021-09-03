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


if (!$admin->permissions['bannerads']) {
	header("location: ./");
	exit();
}

$bannerads_autoassign = $db->fetchOne("SELECT autoassign FROM buyoptions WHERE name='bannerad_credits'");

if ($input->p['a'] == "update") {
	verifyajax();
	verifydemo();

	if (!is_numeric($input->p['bannerad_chars_title'])) {
		serveranswer(0, "Invalid Maximum characters for ad title");
	}


	if (200 < $input->p['bannerad_chars_title']) {
		serveranswer(0, "You can set up to 200 to maximum characters for ad title");
	}

	$bannerad_chars_title = round($input->p['bannerad_chars_title']);
	$db->query("ALTER TABLE `banner_ads` CHANGE `title` `title` VARCHAR(" . $bannerad_chars_title . ") CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ");
	$db->query("UPDATE settings SET value='" . $bannerad_chars_title . "' WHERE field='bannerad_chars_title'");
	$upd = $db->query("UPDATE buyoptions SET autoassign='" . $input->pc['bannerads_autoassign'] . "' WHERE name='bannerad_credits'");
	$upd = $db->query("UPDATE settings SET value='" . $input->pc['bannerads_available'] . "' WHERE field='bannerads_available'");
	$upd = $db->query("UPDATE settings SET value='" . $input->pc['bannerads_approval'] . "' WHERE field='bannerads_approval'");
	$cache->delete("settings");
	serveranswer(1, "Settings were updated.");
}
else {
	if ($input->p['a'] == "newpack") {
		if ($settings['demo'] == "yes") {
			$error_newpack = "This is not possible in this demo version.";
		}
		else {
			$credits = $input->pc['credits'];
			$price = $input->pc['price'];

			if (!is_numeric($credits) || !is_numeric($price)) {
				$error_newpack = "Some fields are incorrect.";
			}
			else {
				$set = array("credits" => $credits, "price" => $price);
				$db->insert("banner_price", $set);
				$success_newpack = 1;
			}
		}
	}
	else {
		if ($input->p['a'] == "updatepack") {
			verifyajax();
			verifydemo();
			$credits = $input->p['credits'][$input->pc['packid']];
			$price = $input->p['price'][$input->pc['packid']];

			if (!is_numeric($credits) || !is_numeric($price)) {
				serveranswer(0, "Some fields are incorrect.");
			}

			$set = array("credits" => $credits, "price" => $price);
			$db->update("banner_price", $set, "id=" . $input->pc['packid']);
			serveranswer(1, "Pack was updated.");
		}
		else {
			if ($input->p['a'] == "deletepack") {
				verifyajax();
				verifydemo();
				$db->delete("banner_price", "id=" . $input->pc['packid']);
				serveranswer(6, "$(\"#pack" . $input->pc['packid'] . "\").remove();");
			}
		}
	}
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Banner Ads Settings</div>
<div class=\"site_content\">
<div id=\"tabs\">
    <ul>
        <li><a href=\"#tabs-1\">General Settings</a></li>
        <li><a href=\"#tabs-2\">Packages</a></li>
    </ul>
    <div id=\"tabs-1\">
        <form method=\"post\" id=\"frm1\" onsubmit=\"return submitform(this.id);\">
        <input type=\"hidden\" name=\"a\" value=\"update\" />
        <table class=\"widget-tbl\" width=\"100%\">
          <tr>
            <td align=\"right\" width=\"300\">Banner ads Enable? </td>
            <td><input type=\"checkbox\" name=\"bannerads_available\" id=\"bannerads_available\" value=\"yes\" ";
echo $settings['bannerads_available'] == "yes" ? "checked" : "";
echo " /></td>
          </tr>
          <tr>
            <td align=\"right\">Require Admin Approval? </td>
            <td><input type=\"checkbox\" name=\"bannerads_approval\" id=\"bannerads_approval\" value=\"yes\" ";
echo $settings['bannerads_approval'] == "yes" ? "checked" : "";
echo " /></td>
          </tr>
          <tr>
            <td align=\"right\">Auto-assign credits after member purchases</td>
            <td><input type=\"checkbox\" name=\"bannerads_autoassign\" id=\"bannerads_autoassign\" value=\"yes\" ";
echo $bannerads_autoassign == "yes" ? "checked" : "";
echo " /></td>
          </tr>
          <tr>
            <td align=\"right\">Maximum characters for ad title:</td>
            <td><input type=\"text\" name=\"bannerad_chars_title\" value=\"";
echo $settings['bannerad_chars_title'];
echo "\" /> (200 max)</td>
          </tr>
          <tr>
            <td></td>
            <td>
        <input type=\"submit\" name=\"btn\" value=\"Save\" />
            </td>
          </tr>
        </table>
        </form>
    </div>
    <div id=\"tabs-2\">
        <div class=\"widget-title\">Add New Package</div>
        ";

if ($error_newpack) {
	echo "<div class=\"error_box\">" . $error_newpack . "</div>";
}


if ($success_newpack) {
	echo "<div class=\"success_box\">New package was added.</div>";
}

echo "        <div class=\"widget-content\">
            <form method=\"post\" action=\"./?view=bannerads_settings#tabs-2\">
                <input type=\"hidden\" name=\"a\" value=\"newpack\" />
                <table class=\"widget-tbl\" width=\"100%\">
                <tr>
                <td align=\"right\">
                    Credits:
                </td>
                <td>
                    <input type=\"text\" name=\"credits\" value=\"0\" />
                </td>
                <td align=\"right\">
                    Price:
                </td>
                <td>
                    <input type=\"text\" name=\"price\" value=\"0.00\" />
                    <input type=\"submit\" name=\"btn\" value=\"Add\" />
                </td>
                </tr>
                </table>
            </form>
        </div>
        <div class=\"widget-title\">Manage Packages</div>
        <form method=\"post\" id=\"frm4\" onsubmit=\"return submitform(this.id);\">
            <input type=\"hidden\" name=\"packid\" id=\"packid\" value=\"0\" />
            <input type=\"hidden\" name=\"a\" id=\"packaction\" value=\"\" />
            <table width=\"100%\" class=\"widget-tbl\">
                <tr class=\"titles\">
                    <td>Credits</td>
                    <td>Price</td>
                    <td>Action</td>
                </tr>
                ";
$query = $db->query("SELECT * FROM banner_price ORDER BY price ASC");

while ($r = $db->fetch_array($query)) {
	$tr = ($tr == "tr1" ? "tr2" : "tr1");
	echo "
                <tr id=\"pack";
	echo $r['id'];
	echo "\" class=\"";
	echo $tr;
	echo "\">
                    <td><input type=\"text\" name=\"credits[";
	echo $r['id'];
	echo "]\" value=\"";
	echo $r['credits'];
	echo "\" /></td>
                    <td><input type=\"text\" name=\"price[";
	echo $r['id'];
	echo "]\" value=\"";
	echo $r['price'];
	echo "\" /></td>
                    <td>
                        <input type=\"submit\" name=\"btn\" value=\"Save\" onclick=\"updfrmvars({'packid': '";
	echo $r['id'];
	echo "', 'packaction': 'updatepack'});\" />
                        <input type=\"submit\" name=\"packaction\" value=\"Delete\" class=\"cancel\" onclick=\"updfrmvars({'packid': '";
	echo $r['id'];
	echo "', 'packaction': 'deletepack'});\" />
                        </td>
                </tr>
                ";
}

echo "
            </table>
          </form>
    </div>
</div>


</div>
        ";
include SOURCES . "footer.php";
echo " ";
?>
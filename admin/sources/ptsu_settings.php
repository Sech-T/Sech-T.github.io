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


if (!$admin->permissions['ptsuoffers']) {
	header("location: ./");
	exit();
}

$ptsu_autoassign = $db->fetchOne("SELECT autoassign FROM buyoptions WHERE name='ptsu_credits'");

if ($input->p['a'] == "update") {
	verifyajax();
	verifydemo();

	if (!is_numeric($input->p['ptsu_exclusion'])) {
		serveranswer(0, "Enter a valid Maximum denials to exclude a member");
	}


	if (!is_numeric($input->p['ptsu_chars_title'])) {
		serveranswer(0, "Invalid Maximum characters for ad title");
	}


	if (200 < $input->p['ptsu_chars_title']) {
		serveranswer(0, "You can set up to 200 to maximum characters for ad title");
	}

	$ptsu_chars_title = round($input->p['ptsu_chars_title']);

	if (!is_numeric($input->p['ptsu_chars_descr'])) {
		serveranswer(0, "Invalid Maximum characters for ad decription");
	}


	if (200 < $input->p['ptsu_chars_descr']) {
		serveranswer(0, "You can set up to 200 to maximum characters for ad description");
	}

	$ptsu_chars_descr = round($input->p['ptsu_chars_descr']);
	$db->query("ALTER TABLE `ptsu_offers` CHANGE `title` `title` VARCHAR(" . $ptsu_chars_title . ") CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ");
	$db->query("ALTER TABLE `ptsu_offers` CHANGE `descr` `descr` VARCHAR(" . $ptsu_chars_descr . ") CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ");
	$db->query("UPDATE settings SET value='" . $ptsu_chars_title . "' WHERE field='ptsu_chars_title'");
	$db->query("UPDATE settings SET value='" . $ptsu_chars_descr . "' WHERE field='ptsu_chars_descr'");
	$upd = $db->query("UPDATE buyoptions SET autoassign='" . $input->pc['ptsu_autoassign'] . "' WHERE name='ptsu_credits'");
	$upd = $db->query("UPDATE settings SET value='" . $input->pc['ptsu_available'] . "' WHERE field='ptsu_available'");
	$upd = $db->query("UPDATE settings SET value='" . $input->pc['ptsu_approval'] . "' WHERE field='ptsu_approval'");
	$upd = $db->query("UPDATE settings SET value='" . $input->pc['ptsu_exclusion'] . "' WHERE field='ptsu_exclusion'");
	$upd = $db->query("UPDATE settings SET value='" . $input->pc['ptsu_autoapprovedays'] . "' WHERE field='ptsu_autoapprovedays'");
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
				$error_newpack = "Some fields are incorrect";
			}
			else {
				$set = array("credits" => $credits, "price" => $price);
				$db->insert("ptsu_price", $set);
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
				serveranswer(0, "Some fields are incorrect");
			}

			$set = array("credits" => $credits, "price" => $price);
			$db->update("ptsu_price", $set, "id=" . $input->pc['packid']);
			serveranswer(1, "PTSU Pack was updated.");
		}
		else {
			if ($input->p['a'] == "deletepack") {
				verifyajax();
				verifydemo();
				$db->delete("ptsu_price", "id=" . $input->pc['packid']);
				serveranswer(6, "$(\"#pack" . $input->pc['packid'] . "\").remove();");
			}
			else {
				if ($input->p['a'] == "newvalue") {
					if ($settings['demo'] == "yes") {
						$error_value = "This is not possible in this demo version.";
					}
					else {
						$value = $input->pc['value'];
						$credits = $input->pc['credits'];
						$set = array("value" => $value, "credits" => $credits);
						$db->insert("ptsu_value", $set);
						$success_value = 1;
					}
				}
				else {
					if ($input->p['a'] == "updatevalue") {
						verifyajax();
						verifydemo();
						$value = $input->p['value'][$input->pc['valueid']];
						$credits = $input->p['credits'][$input->pc['valueid']];
						$set = array("value" => $value, "credits" => $credits);
						$db->update("ptsu_value", $set, "id=" . $input->pc['valueid']);
						serveranswer(1, "PTSU Value was updated.");
					}
					else {
						if ($input->p['a'] == "deletevalue") {
							verifyajax();
							verifydemo();
							$db->delete("ptsu_value", "id=" . $input->pc['valueid']);
							serveranswer(6, "$(\"#value" . $input->pc['valueid'] . "\").remove();");
						}
					}
				}
			}
		}
	}
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">PTSU Settings</div>
<div class=\"site_content\">
<div id=\"tabs\">
    <ul>
        <li><a href=\"#tabs-1\">General Settings</a></li>
        <li><a href=\"#tabs-2\">Packages</a></li>
        <li><a href=\"#tabs-3\">Values</a></li>
    </ul>
    <div id=\"tabs-1\">
        <form method=\"post\" id=\"frm1\" onsubmit=\"return submitform(this.id);\">
        <input type=\"hidden\" name=\"a\" value=\"update\" />
        <table class=\"widget-tbl\" width=\"100%\">
          <tr>
            <td valign=\"top\" align=\"right\" width=\"300\">PTSU Enable?</td>
            <td valign=\"top\"><input type=\"checkbox\" name=\"ptsu_available\" id=\"ptsu_available\" value=\"yes\" ";
echo $settings['ptsu_available'] == "yes" ? "checked" : "";
echo " /></td>
          </tr>
          <tr>
            <td valign=\"top\" align=\"right\">Require Admin Approval?</td>
            <td valign=\"top\"><input type=\"checkbox\" name=\"ptsu_approval\" id=\"ptsu_approval\" value=\"yes\" ";
echo $settings['ptsu_approval'] == "yes" ? "checked" : "";
echo " /></td>
          </tr>
          <tr>
            <td valign=\"top\" align=\"right\">Auto-assign credits after member purchases</td>
            <td valign=\"top\"><input type=\"checkbox\" name=\"ptsu_autoassign\" id=\"ptsu_autoassign\" value=\"yes\" ";
echo $ptsu_autoassign == "yes" ? "checked" : "";
echo " /></td>
          </tr>

          <tr>
            <td valign=\"top\" align=\"right\">Maximum denials to exclude a member</td>
            <td valign=\"top\"><input type=\"text\" name=\"ptsu_exclusion\" value=\"";
echo $settings['ptsu_exclusion'];
echo "\" /> <br />
<span style=\"font-size:11px\">If a user has more than this amount of declined submissions, he won't be able to
complete any more PTSU offers</span></td>
          </tr>
          <tr>
            <td valign=\"top\" align=\"right\">Time frame for auto-approving PTSU pending applications</td>
            <td valign=\"top\"><input type=\"text\" name=\"ptsu_autoapprovedays\" value=\"";
echo $settings['ptsu_autoapprovedays'];
echo "\" /> days <br />
<span style=\"font-size:11px\">If a advertiser does not make a review of an application, it will be auto-approved after the scheduled days in the box above</span></td>
          </tr>
          <tr>
            <td align=\"right\">Maximum characters for ad title:</td>
            <td><input type=\"text\" name=\"ptsu_chars_title\" value=\"";
echo $settings['ptsu_chars_title'];
echo "\" /> (200 max)</td>
          </tr>
          <tr>
            <td align=\"right\">Maximum characters for ad description:</td>
            <td><input type=\"text\" name=\"ptsu_chars_descr\" value=\"";
echo $settings['ptsu_chars_descr'];
echo "\" /> (200 max)</td>
          </tr>
          <tr>
            <td></td>
            <td>
            <input type=\"submit\" name=\"btn\" value=\"Save\" /></td>
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
            <form method=\"post\" action=\"./?view=ptsu_settings#tabs-2\">
            <input type=\"hidden\" name=\"a\" value=\"newpack\" />
            <table width=\"100%\" class=\"widget-tbl\">
                <tr>
                    <td align=\"right\">
            Credits:
                    </td>
                    <td>
            <input type=\"text\" name=\"credits\" value=\"0\">
                    </td>
                    <td align=\"right\">
            Price:
                    </td>
                    <td>
            <input type=\"text\" name=\"price\" value=\"0.00\">
            <input type=\"submit\" name=\"btn\" value=\"Add New\">
                    </td>
                </tr>
            </table>
            </form>
        </div>
        <div class=\"widget-title\">Manage Packages</div>
        <form method=\"post\" id=\"frm3\" onsubmit=\"return submitform(this.id);\">
            <input type=\"hidden\" name=\"packid\" id=\"packid\" value=\"0\" />
            <input type=\"hidden\" name=\"a\" id=\"packaction\" value=\"\" />
            <table width=\"100%\" class=\"widget-tbl\">
                <tr class=\"titles\">
                    <td>Credits</td>
                    <td>Price</td>
                    <td>Action</td>
                </tr>
                ";
$query = $db->query("SELECT * FROM ptsu_price ORDER BY price ASC");

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

echo "            </table>
        </form>
    </div>
    <div id=\"tabs-3\">
        <div class=\"widget-title\">Add New Value</div>

        <div class=\"widget-content\">
           <div class=\"info_box corner-all\">
            This option allows to administrator set how many credits is necessary to get a commission (Ex 1 credits = $0.10)
            </div>
			";

if ($error_value) {
	echo "<div class=\"error_box\">" . $error_newpack . "</div>";
}


if ($success_value) {
	echo "<div class=\"success_box\">New value was added.</div>";
}

echo "            <form method=\"post\" action=\"./?view=ptsu_settings#tabs-3\">
            <input type=\"hidden\" name=\"a\" value=\"newvalue\" />
            <table class=\"widget-tbl\" width=\"100%\">
            <tr>
            <td align=\"right\">
            Value
            </td>
            <td>
            <input type=\"text\" name=\"value\" value=\"0.00\" />
            </td>
            <td align=\"right\">
            Credits
            </td>
            <td>
            <input type=\"text\" name=\"credits\" value=\"0\" />
            <input type=\"submit\" name=\"btn\" value=\"Add\" />
            </td>
            </tr>
            </table>
            </form>
        </div>
        <div class=\"widget-title\">Manage Values</div>
        <form method=\"post\" id=\"frm5\" onsubmit=\"return submitform(this.id);\">
            <input type=\"hidden\" name=\"valueid\" id=\"valueid\" value=\"0\" />
            <input type=\"hidden\" name=\"a\" id=\"valueaction\" value=\"\" />
            <table width=\"100%\" class=\"widget-tbl\">
                <tr class=\"titles\">
                    <td>Value</td>
                    <td>Credits</td>
                    <td>Action</td>
                </tr>
                ";
$query = $db->query("SELECT * FROM ptsu_value ORDER BY value ASC");

while ($r = $db->fetch_array($query)) {
	$tr = ($tr == "tr1" ? "tr2" : "tr1");
	echo "
                <tr id=\"value";
	echo $r['id'];
	echo "\" class=\"";
	echo $tr;
	echo "\">
                    <td><input type=\"text\" name=\"value[";
	echo $r['id'];
	echo "]\" value=\"";
	echo $r['value'];
	echo "\" /></td>
                    <td><input type=\"text\" name=\"credits[";
	echo $r['id'];
	echo "]\" value=\"";
	echo $r['credits'];
	echo "\" /></td>
                    <td>
                        <input type=\"submit\" name=\"btn\" value=\"Save\" onclick=\"updfrmvars({'valueid': '";
	echo $r['id'];
	echo "', 'valueaction': 'updatevalue'});\" />
                        <input type=\"submit\" name=\"packaction\" value=\"Delete\" class=\"cancel\" onclick=\"updfrmvars({'valueid': '";
	echo $r['id'];
	echo "', 'valueaction': 'deletevalue'});\" />
                        </td>
                </tr>
                ";
}

echo "            </table>
        </form>
    </div>
</div>
</div>
 ";
include SOURCES . "footer.php";
echo " ";
?>
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


if (!$admin->permissions['ptcads']) {
	header("location: ./");
	exit();
}

$advalue = $db->fetchRow("SHOW COLUMNS FROM ad_value WHERE field='value'");
$ad_decimal = str_replace("decimal(11,", "", $advalue['Type']);
$ad_decimal = str_replace(")", "", $ad_decimal);
$ptc_autoassign = $db->fetchOne("SELECT autoassign FROM buyoptions WHERE name='ptc_credits'");

if ($input->p['a'] == "update") {
	verifyajax();
	verifydemo();

	if (!is_numeric($input->p['decimal_points']) || $input->p['decimal_points'] < 3) {
		serveranswer(0, "Minimum decimal points for ads is 3");
	}


	if (!is_numeric($input->p['ptc_chars_title'])) {
		serveranswer(0, "Invalid Maximum characters for ad title");
	}


	if (200 < $input->p['ptc_chars_title']) {
		serveranswer(0, "You can set up to 200 to maximum characters for ad title");
	}

	$ptc_chars_title = round($input->p['ptc_chars_title']);

	if (!is_numeric($input->p['ptc_chars_descr'])) {
		serveranswer(0, "Invalid Maximum characters for ad decription");
	}


	if (200 < $input->p['ptc_chars_descr']) {
		serveranswer(0, "You can set up to 200 to maximum characters for ad description");
	}

	$ptc_chars_descr = round($input->p['ptc_chars_descr']);
	$db->query("ALTER TABLE `ads` CHANGE `title` `title` VARCHAR(" . $ptc_chars_title . ") CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL");
	$db->query("ALTER TABLE `ads` CHANGE `descr` `descr` VARCHAR(" . $ptc_chars_descr . ") CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ");
	$db->query("UPDATE settings SET value='" . $ptc_chars_title . "' WHERE field='ptc_chars_title'");
	$db->query("UPDATE settings SET value='" . $ptc_chars_descr . "' WHERE field='ptc_chars_descr'");
	$db->query("UPDATE settings SET value='" . $db->real_escape_string($input->pc['unique_ip']) . "' WHERE field='unique_ip'");
	$upd = $db->query("UPDATE buyoptions SET autoassign='" . $input->pc['ptc_autoassign'] . "' WHERE name='ptc_credits'");
	$upd = $db->query("UPDATE settings SET value='" . $input->pc['ptc_approval'] . "' WHERE field='ptc_approval'");
	$depoint = $input->pc['decimal_points'];

	if ($ad_decimal != $depoint) {
		$db->query("ALTER TABLE `ads` CHANGE `value` `value` DECIMAL(11, " . $depoint . ") NOT NULL DEFAULT '0'");
		$db->query("ALTER TABLE `ad_value` CHANGE `value` `value` DECIMAL(11, " . $depoint . ") NOT NULL DEFAULT '0'");

		if (2 < $depoint) {
			$dep_plus = $depoint + 1;
			$dep_plus2 = $depoint + 2;
			$db->query("ALTER TABLE members CHANGE purchase_balance purchase_balance DECIMAL(11, " . $dep_plus2 . ") NOT NULL;");
			$db->query("ALTER TABLE members CHANGE money money DECIMAL(11, " . $dep_plus . ") NOT NULL;");
			$db->query("ALTER TABLE members CHANGE for_refearned for_refearned DECIMAL(11, " . $dep_plus . ") NOT NULL;");
			$db->query("ALTER TABLE members CHANGE refearnings refearnings DECIMAL(11, " . $dep_plus . ") NOT NULL;");
			$db->query("ALTER TABLE members CHANGE rented_earned rented_earned DECIMAL(11, " . $dep_plus . ") NOT NULL;");
			$db->query("ALTER TABLE members CHANGE ap1 ap1 DECIMAL(11, " . $dep_plus . ") NOT NULL;");
			$db->query("ALTER TABLE members CHANGE ap2 ap2 DECIMAL(11, " . $dep_plus . ") NOT NULL;");
			$db->query("ALTER TABLE members CHANGE ap3 ap3 DECIMAL(11, " . $dep_plus . ") NOT NULL;");
			$db->query("ALTER TABLE members CHANGE ap4 ap4 DECIMAL(11, " . $dep_plus . ") NOT NULL;");
			$db->query("ALTER TABLE members CHANGE ap5 ap5 DECIMAL(11, " . $dep_plus . ") NOT NULL;");
			$db->query("ALTER TABLE members CHANGE ap6 ap6 DECIMAL(11, " . $dep_plus . ") NOT NULL;");
			$db->query("ALTER TABLE members CHANGE ap7 ap7 DECIMAL(11, " . $dep_plus . ") NOT NULL;");
			$db->query("ALTER TABLE members CHANGE withdraw withdraw DECIMAL(11, " . $dep_plus . ") NOT NULL;");
			$db->query("ALTER TABLE members CHANGE pending_withdraw pending_withdraw DECIMAL(11, " . $dep_plus . ") NOT NULL");
		}
	}

	$cache->delete("settings");
	serveranswer(1, "Settings were updated.");
}
else {
	if ($input->p['a'] == "newpack") {
		if ($settings['demo'] == "yes") {
			$error_newpack = "This is not possible in this demo version";
		}
		else {
			if ($input->p['sesion_id'] != $_SESSION['sesion_id']) {
				$error_newpack = "Invalid token try again please";
			}
			else {
				if (!is_numeric($input->pc['credits']) || !is_numeric($input->pc['price'])) {
					$error_newpack = "Some fields are incorrect";
				}
				else {
					$set = array("credits" => $input->pc['credits'], "price" => $input->pc['price']);
					$db->insert("ads_price", $set);
					$success_newpack = 1;
				}
			}
		}
	}
	else {
		if ($input->p['a'] == "deletepack") {
			verifyajax();
			verifydemo();
			$db->delete("ads_price", "id=" . $input->pc['packid']);
			serveranswer(6, "$(\"#pack" . $input->pc['packid'] . "\").remove();");
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
				$db->update("ads_price", $set, "id=" . $input->pc['packid']);
				serveranswer(1, "PTC Package updated.");
			}
			else {
				if ($input->p['a'] == "newcat") {
					if ($settings['demo'] == "yes") {
						$error_newcat = "This is not possible in this demo version";
					}
					else {
						if (!$input->p['catname']) {
							$error_newcat = "Please enter a category name";
						}
						else {
							$data = array("catname" => $input->pc['catname'], "value" => $input->pc['value'], "credits" => $input->pc['credits'], "time" => $input->pc['time'], "earn_ref" => $input->pc['earn_ref'], "hide_descr" => $input->pc['hide_descr']);
							$db->insert("ad_value", $data);
							$success_newcat = 1;
						}
					}
				}
				else {
					if ($input->p['a'] == "deletecat") {
						verifyajax();
						verifydemo();
						$ad_value = $db->fetchRow("SELECT value, time FROM ad_value WHERE id=" . $db->real_escape_string($input->p['catid']));
						$chk = $db->fetchOne(("SELECT COUNT(id) AS NUM FROM ads WHERE value='" . $ad_value['value'] . "' AND time='" . $ad_value['time'] . "'"));

						if ($chk != 0) {
							serveranswer(0, "It's not possible to delete this category because there are advertisements using this category.");
						}
						else {
							$db->delete("ad_value", "id=" . $input->pc['catid']);
							serveranswer(6, "$(\"#cat" . $input->pc['catid'] . "\").remove();");
						}
					}
					else {
						if ($input->p['a'] == "updatecat") {
							verifyajax();
							verifydemo();

							if (is_numeric($input->pc['catid'])) {
								$catid = $db->fetchRow("SELECT id, value, time FROM ad_value WHERE id=" . $input->pc['catid']);
								$catname = $input->p['catname'][$input->pc['catid']];
								$value = $input->p['value'][$input->pc['catid']];
								$credits = $input->p['credits'][$input->pc['catid']];
								$time = $input->p['time'][$input->pc['catid']];
								$earn_ref = $input->p['earn_ref'][$input->pc['catid']];
								$hide_descr = $input->p['hide_descr'][$input->pc['catid']];
								$setdata = array("value" => $value, "time" => $time);
								$db->update("ads", $setdata, "category=" . $catid['id']);
								$set = array("catname" => $catname, "value" => $value, "credits" => $credits, "time" => $time, "earn_ref" => $earn_ref, "hide_descr" => $hide_descr);
								$db->update("ad_value", $set, "id=" . $input->pc['catid']);
							}

							serveranswer(1, "PTC Category updated");
						}
					}
				}
			}
		}
	}
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">PTC Ads Settings</div>
<div class=\"site_content\">
  <div id=\"tabs\">
	<ul>
		<li><a href=\"#tabs-1\">General Settings</a></li>
		<li><a href=\"#tabs-2\">Packages</a></li>
        <li><a href=\"#tabs-3\">Categories</a></li>
	</ul>
	<div id=\"tabs-1\">
        <form method=\"post\" onsubmit=\"return submitform(this.id);\" id=\"frm1\">
        <input type=\"hidden\" name=\"a\" value=\"update\" />
        <table width=\"100%\" class=\"widget-tbl\">
          <tr>
            <td align=\"right\" width=\"300\">Require Admin Approval? </td>
            <td><input type=\"checkbox\" name=\"ptc_approval\" id=\"ptc_approval\" value=\"yes\" ";

if ($settings['ptc_approval'] == "yes") {
	echo "checked";
}

echo " /></td>
          </tr>
          <tr>
            <td align=\"right\">Auto-assign credits after member purchases</td>
            <td><input type=\"checkbox\" name=\"ptc_autoassign\" id=\"ptc_autoassign\" value=\"yes\" ";

if ($ptc_autoassign == "yes") {
	echo "checked";
}

echo " /></td>
          </tr>
          <tr>
            <td align=\"right\">Maximum characters for ad title:</td>
            <td><input type=\"text\" name=\"ptc_chars_title\" value=\"";
echo $settings['ptc_chars_title'];
echo "\" /> (200 max)</td>
          </tr>
          <tr>
            <td align=\"right\">Maximum characters for ad description:</td>
            <td><input type=\"text\" name=\"ptc_chars_descr\" value=\"";
echo $settings['ptc_chars_descr'];
echo "\" /> (200 max)</td>
          </tr>
          <tr>
            <td align=\"right\">One click per IP every 24 hours? (For each ad):</td>
            <td><input type=\"checkbox\" name=\"unique_ip\" value=\"yes\" ";
echo $settings['unique_ip'] == "yes" ? "checked" : "";
echo " /> Tick to enable</td>
          </tr>
            <tr>
                <td align=\"right\">Decimal points for ads</td>
                <td><input type=\"text\" value=\"";
echo $ad_decimal;
echo "\" name=\"decimal_points\" /> <span style=\"color:#990000\">If decrease this number and there are ads using ";
echo $ad_decimal;
echo " decimal points, they will changed to zero</span></td>
            </tr>
          <tr>
            <td></td>
            <td>
            <input type=\"submit\" name=\"create\" value=\"Save\" />
            </td>
          </tr>
        </table>
        </form>
    </div>
    <div id=\"tabs-2\">
    	<div class=\"widget-title\">Add New Package</div>
		<div class=\"widget-content\">
    <form method=\"post\" action=\"./?view=ptcads_settings#tabs-2\" id=\"frm2\">
    <input type=\"hidden\" name=\"a\" value=\"newpack\" />
    <input type=\"hidden\" name=\"sesion_id\" value=\"";
echo sesion_id();
echo "\" />
    		";

if ($error_newpack) {
	echo "<div class=\"error_box\">" . $error_newpack . "</div>";
}


if ($success_newpack) {
	echo "<div class=\"success_box\">New packaged was added.</div>";
}

echo "            <table width=\"100%\" class=\"widget-tbl\">
                <tr>
                    <td align=\"right\">
                        Credits:
                    </td>
                    <td>
                        <input type=\"text\" name=\"credits\" value=\"0\" />
                    </td>
                    <td align=\"right\">
                        &nbsp;
                        Price:
                    </td>
                    <td>
                        <input type=\"text\" name=\"price\" value=\"0.00\" />
                        <input type=\"submit\" name=\"packages\" value=\"Add New\" />
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
$query = $db->query("SELECT * FROM ads_price ORDER BY price ASC");

while ($r = $db->fetch_array($query)) {
	$tr = ($tr == "tr1" ? "tr2" : "tr1");
	echo "            <tr class=\"";
	echo $tr;
	echo "\" id=\"pack";
	echo $r['id'];
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
                <td><input type=\"submit\" name=\"btn\" value=\"Save\" onclick=\"updfrmvars({'packid': '";
	echo $r['id'];
	echo "', 'packaction': 'updatepack'});\" /> <input type=\"submit\" name=\"btn\" value=\"Delete\" class=\"cancel\"onclick=\"updfrmvars({'packid': '";
	echo $r['id'];
	echo "', 'packaction': 'deletepack'});\"  /></td>
            </tr>
            ";
}

echo "        </table>
        </form>
    </div>
    <div id=\"tabs-3\">
        <div class=\"widget-title\">Add New Category</div>
        <div class=\"info_box corner-all\">
        This option allows to administrator set how many credits (<strong>credits</strong>), the advertisers have to use to display their ads for a while (<strong>time</strong>),<br /> and how much users can earn per click (<strong>value</strong>).
        </div>
    <form method=\"post\" action=\"./?view=ptcads_settings#tabs-3\">
    <input type=\"hidden\" name=\"a\" value=\"newcat\" />

    		";

if ($error_newcat) {
	echo "<div class=\"error_box\">" . $error_newcat . "</div>";
}


if ($success_newcat) {
	echo "<div class=\"success_box\">New category was added.</div>";
}

echo "                    <table cellpadding=\"4\" width=\"100%\" class=\"widget-tbl\">
                    <tr>
                        <td>Category Name:</td>
                        <td><input type=\"text\" name=\"catname\" value=\"\" /></td>
                        <td>PTC Value:</td>
                        <td><input type=\"text\" name=\"value\" value=\"0.00\" /></td>
                    </tr>
                    <tr>
                        <td>Credits:</td>
                        <td><input type=\"text\" name=\"credits\" value=\"0\" /></td>
                        <td>Time</td>
                        <td><input type=\"text\" name=\"time\" value=\"0\" /></td>
                    </tr>
                    <tr>
                        <td>Allow ref earning:</td>
                        <td>
                <select name=\"earn_ref\" class=\"default\">
                	<option value=\"1\" selected=\"selected\">Yes</option>
                    <option value=\"0\">No</option>
                </select> <span style=\"font-size:11px\">(Member will earn per referral click in this category)</span>
                        </td>
                        <td>Hide ad descr.</td>
                        <td>
				<select name=\"hide_descr\" class=\"default\">
                	<option value=\"1\">Yes</option>
                    <option value=\"0\" selected=\"selected\">No</option>
                </select>
                        </td>
                    </tr>
                    <tr>
                    <td colspan=\"4\" align=\"center\">
                        <input type=\"submit\" name=\"create_value\" value=\"Add New\" />
                     </td>
                     </tr>
                     </table>

        </form>
        <div class=\"widget-title\" style=\"margin-top:5px\">Manage Categories</div>
        <div class=\"widget-content\">
<form method=\"post\" id=\"frm5\" onsubmit=\"return submitform(this.id);\">
        <input type=\"hidden\" name=\"catid\" id=\"catid\" value=\"0\" />
        <input type=\"hidden\" name=\"a\" id=\"cataction\" value=\"\" />

        <table width=\"100%\" class=\"widget-tbl\">
        	<tr class=\"titles\">
            	<td>Category</td>
                <td>Value</td>
                <td>Credits</td>
                <td>Time (seconds)</td>
                <td>Allow ref earning</td>
                <td>Hide ad descr.</td>
                <td>Action</td>
            </tr>
            ";
$query = $db->query("SELECT * FROM ad_value ORDER BY value ASC");

while ($r = $db->fetch_array($query)) {
	$tr = ($tr == "tr1" ? "tr2" : "tr1");
	echo "            <tr id=\"cat";
	echo $r['id'];
	echo "\" class=\"";
	echo $tr;
	echo "\">
            	<td><input type=\"text\" name=\"catname[";
	echo $r['id'];
	echo "]\" value=\"";
	echo $r['catname'];
	echo "\" /></td>
                <td><input type=\"text\" name=\"value[";
	echo $r['id'];
	echo "]\" value=\"";
	echo $r['value'];
	echo "\" class=\"default\" size=\"10\" /></td>
                <td><input type=\"text\" name=\"credits[";
	echo $r['id'];
	echo "]\" value=\"";
	echo $r['credits'];
	echo "\" class=\"default\" size=\"10\" /></td>
                <td><input type=\"text\" name=\"time[";
	echo $r['id'];
	echo "]\" value=\"";
	echo $r['time'];
	echo "\" class=\"default\" size=\"10\" /></td>
                <td>
                <select name=\"earn_ref[";
	echo $r['id'];
	echo "]\" class=\"default\">
                	<option value=\"1\" ";
	echo $r['earn_ref'] == 1 ? "selected" : "";
	echo ">Yes</option>
                    <option value=\"0\" ";
	echo $r['earn_ref'] != 1 ? "selected" : "";
	echo ">No</option>
                </select>
                </td>
                <td>
                <select name=\"hide_descr[";
	echo $r['id'];
	echo "]\" class=\"default\">
                	<option value=\"1\" ";
	echo $r['hide_descr'] == 1 ? "selected" : "";
	echo ">Yes</option>
                    <option value=\"0\" ";
	echo $r['hide_descr'] != 1 ? "selected" : "";
	echo ">No</option>
                </select>
                </td>
                <td><input type=\"submit\" name=\"btn\" value=\"Save\" onclick=\"updfrmvars({'catid': '";
	echo $r['id'];
	echo "', 'cataction': 'updatecat'});\" /> <input type=\"submit\" name=\"btn\" value=\"Delete\" class=\"cancel\"onclick=\"updfrmvars({'catid': '";
	echo $r['id'];
	echo "', 'cataction': 'deletecat'});\"  /></td>
            </tr>
            ";
}

echo "        </table>
        </form>
        </div>
    </div>
  </div>




</div>






        ";
include SOURCES . "footer.php";
echo " ";
?>
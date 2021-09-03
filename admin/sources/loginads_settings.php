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


if (!$admin->permissions['loginads']) {
	header("location: ./");
	exit();
}

$loginads_autoassign = $db->fetchOne("SELECT autoassign FROM buyoptions WHERE name='loginads_credits'");

if ($input->p['a'] == "update") {
	verifyajax();
	verifydemo();

	if (4 < $input->pc['loginads_max']) {
		serveranswer(0, "Maximum ads to display is 4");
	}


	if (!is_numeric($input->p['loginad_chars_title'])) {
		serveranswer(0, "Invalid Maximum characters for ad title");
	}


	if (200 < $input->p['loginad_chars_title']) {
		serveranswer(0, "You can set up to 200 to maximum characters for ad title");
	}

	$loginad_chars_title = round($input->p['loginad_chars_title']);
	$db->query("ALTER TABLE `login_ads` CHANGE `title` `title` VARCHAR(" . $loginad_chars_title . ") CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ");
	$db->query("UPDATE settings SET value='" . $loginad_chars_title . "' WHERE field='loginad_chars_title'");
	$upd = $db->query("UPDATE buyoptions SET autoassign='" . $input->pc['loginads_autoassign'] . "' WHERE name='loginads_credits'");
	$upd = $db->query("UPDATE settings SET value='" . $input->pc['loginads_available'] . "' WHERE field='loginads_available'");
	$upd = $db->query("UPDATE settings SET value='" . $input->pc['loginads_approval'] . "' WHERE field='loginads_approval'");
	$upd = $db->query("UPDATE settings SET value='" . $input->pc['loginads_max'] . "' WHERE field='loginads_max'");
	$cache->delete("settings");
	serveranswer(1, "Settings were updated.");
}
else {
	if ($input->p['a'] == "newpack") {
		if ($settings['demo'] == "yes") {
			$error_newpack = "This is not possible in this demo version.";
		}
		else {
			if (!is_numeric($input->pc['days']) || !is_numeric($input->pc['price'])) {
				$error_newpack = "Some fields are incorrect";
			}
			else {
				$set = array("days" => $input->pc['days'], "price" => $input->pc['price']);
				$db->insert("loginads_price", $set);
				$success_newpack = 1;
			}
		}
	}
	else {
		if ($input->p['a'] == "updatepack") {
			verifyajax();
			verifydemo();
			$days = $input->p['days'][$input->pc['packid']];
			$price = $input->p['price'][$input->pc['packid']];

			if (!is_numeric($days) || !is_numeric($price)) {
				serveranswer(0, "Some fields are incorrect.");
			}

			$set = array("days" => $days, "price" => $price);
			$db->update("loginads_price", $set, "id=" . $input->pc['packid']);
			serveranswer(1, "Pack was updated.");
		}
		else {
			if ($input->p['a'] == "deletepack") {
				verifyajax();
				verifydemo();
				$db->delete("loginads_price", "id=" . $input->pc['packid']);
				serveranswer(6, "$(\"#pack" . $input->pc['packid'] . "\").remove();");
			}
		}
	}
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Login Ads Settings</div>
<div class=\"site_content\">

<div class=\"info_box\">Login ads works like banner ads based in days and these are displayed in the first login of the days for each member.</div>
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
                <td align=\"right\" width=\"300\">Login Ads Enable? </td>
                <td><input type=\"checkbox\" name=\"loginads_available\" id=\"loginads_available\" value=\"yes\" ";
echo $settings['loginads_available'] == "yes" ? "checked" : "";
echo " /></td>
              </tr>
              <tr>
                <td align=\"right\">Require Admin Approval? </td>
                <td><input type=\"checkbox\" name=\"loginads_approval\" id=\"loginads_approval\" value=\"yes\" ";
echo $settings['loginads_approval'] == "yes" ? "checked" : "";
echo " /></td>
              </tr>
              <tr>
                <td align=\"right\">Auto-assign credits after member purchases</td>
                <td><input type=\"checkbox\" name=\"loginads_autoassign\" id=\"loginads_autoassign\" value=\"yes\" ";
echo $loginads_autoassign == "yes" ? "checked" : "";
echo " /></td>
              </tr>

              <tr>
                <td align=\"right\">Number of ads to display</td>
                <td><select name=\"loginads_max\">
                ";
$i = 1;

while ($i <= 4) {
	echo "<option value='" . $i . "' " . ($i == $settings['loginads_max'] ? "selected" : "") . ((">") . $i . "</optioon>");
	++$i;
}

echo "                </select>
                </td>
              </tr>

          <tr>
            <td align=\"right\">Maximum characters for ad title:</td>
            <td><input type=\"text\" name=\"loginad_chars_title\" value=\"";
echo $settings['loginad_chars_title'];
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

echo "            <div class=\"widget-content\">
            <form method=\"post\" action=\"./?view=loginads_settings#tabs-2\">
                <input type=\"hidden\" name=\"a\" value=\"newpack\" />
                <table class=\"widget-tbl\" width=\"100%\">
                    <tr>
                    <td align=\"right\">

                Days:
                	</td>
                    <td>
                <input type=\"text\" name=\"days\" value=\"0\" />
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
            	<form method=\"post\" id=\"frm3\" onsubmit=\"return submitform(this.id);\">
                <input type=\"hidden\" name=\"packid\" id=\"packid\" value=\"0\" />
                <input type=\"hidden\" name=\"a\" id=\"packaction\" value=\"\" />
            	<table width=\"100%\" class=\"widget-tbl\">
                	<tr class=\"titles\">
                    	<td>Days</td>
                        <td>Price</td>
                        <td>Action</td>
                    </tr>
					";
$query = $db->query("SELECT * FROM loginads_price ORDER BY price ASC");

while ($r = $db->fetch_array($query)) {
	$tr = ($tr == "tr1" ? "tr2" : "tr1");
	echo "
                    <tr id=\"pack";
	echo $r['id'];
	echo "\" class=\"";
	echo $tr;
	echo "\">
                    	<td><input type=\"text\" name=\"days[";
	echo $r['id'];
	echo "]\" value=\"";
	echo $r['days'];
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
                        <input type=\"submit\" name=\"btn\" value=\"Delete\" class=\"cancel\" onclick=\"updfrmvars({'packid': '";
	echo $r['id'];
	echo "', 'packaction': 'deletepack'});\" />
                        </td>
                    </tr>
                    ";
}

echo "                </table>
                </form>
        </div>
	</div>
</div>
";
include SOURCES . "footer.php";
echo " ";
?>
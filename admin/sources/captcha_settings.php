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


if (!$admin->permissions['setup']) {
	header("location: ./");
	exit();
}


if ($input->p['do'] == "update1") {
	verifyajax();
	verifydemo();
	$set = array("captcha_type", "captcha_contact", "captcha_login", "captcha_register", "captcha_surfbar");
	foreach ($set as $k) {
		$updarray = array("value" => $input->pc[$k]);
		$db->update("settings", $updarray, ("field='" . $k . "'"));
	}

	$cache->delete("settings");
	serveranswer(1, "Settings were updated.");
}
else {
	if ($input->p['do'] == "update2") {
		verifyajax();
		verifydemo();
		$set = array("recaptcha_publickey", "recaptcha_privatekey", "recaptcha_theme", "captcha_surfbar");
		foreach ($set as $k) {
			$updarray = array("value" => $input->pc[$k]);
			$db->update("settings", $updarray, ("field='" . $k . "'"));
		}

		$cache->delete("settings");
		serveranswer(1, "Settings were updated.");
	}
	else {
		if ($input->p['do'] == "update3") {
			verifyajax();
			verifydemo();
			$set = array("solvemedia_ckey", "solvemedia_vkey", "solvemedia_hkey");
			foreach ($set as $k) {
				$updarray = array("value" => $input->pc[$k]);
				$db->update("settings", $updarray, ("field='" . $k . "'"));
			}

			$cache->delete("settings");
			serveranswer(1, "Settings were updated.");
		}
	}
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Captcha Settings</div>
<div class=\"site_content\">

    <div class=\"info_box\">
    <strong><a href=\"http://www.google.com/recaptcha\" target=\"_blank\">reCAPTCHA&trade;</a> Verification</strong><br />
      An image containing two words will be shown to the user.<br /> This verification supports audio, allowing blind users to register.
      </div>
<div id=\"tabs\">
	<ul>
    	<li><a href=\"#tabs-1\">Global</a></li>
        <li><a href=\"#tabs-2\">reCAPTCHA&trade; Settings</a></li>
        <li><a href=\"#tabs-3\">Solve Media Captcha Settings</a></li>
    </ul>
    <div id=\"tabs-1\">
        <form method=\"post\" id=\"frm1\" onsubmit=\"return submitform(this.id);\">
        <input type=\"hidden\" name=\"do\" value=\"update1\" />
        <table class=\"widget-tbl\" width=\"100%\">
          <tr>
            <td width=\"300\"><strong>Image Verification</strong><br />
            <span style=\"font-weight:normal\">
              An image consisting of letters in varying fonts/shapes/sizes will be shown to the user. <br />The appearance of this image is dictated by several options that you may control.
              </span>
              </td>
            <td valign=\"top\">
            ";
$captcha = array(0 => "Disabled", 1 => "Image", 2 => "reCAPTCHA&trade;", 3 => "Solve Media Captcha");
foreach ($captcha as $id => $value) {

	if ($id == $settings['captcha_type']) {
		echo "<input type=\"radio\" name=\"captcha_type\" id=\"" . $value . "\" value=\"" . $id . "\" checked />";
		echo "<label for=\"" . $value . "\">" . $value . "</label><br>";
		continue;
	}

	echo "<input type=\"radio\" name=\"captcha_type\" id=\"" . $value . "\" value=\"" . $id . "\" />";
	echo "<label for=\"" . $value . "\">" . $value . "</label><br>";
}

echo "      </td>
            </tr>
          <tr>
            <td align=\"right\">Use captcha on..</td>
            <td valign=\"top\">
            ";
$captchaon = array("captcha_contact" => "Contact page", "captcha_login" => "Login page", "captcha_register" => "Registration page");
foreach ($captchaon as $field => $value) {

	if ($settings[$field] == "yes") {
		echo "<input type=\"checkbox\" name=\"" . $field . "\" id=\"" . $field . "\" value=\"yes\" checked />";
		echo "<label for=\"" . $value . "\">" . $value . "</label><br>";
		continue;
	}

	echo "<input type=\"checkbox\" name=\"" . $field . "\" id=\"" . $field . "\" value=\"yes\" />";
	echo "<label for=\"" . $value . "\">" . $value . "</label><br>";
}

echo "    </td>
          </tr>
          <tr>
          	<td></td>
            <td><input type=\"submit\" name=\"create\" value=\"Save\" /></td>
          </tr>
        </table>
        </form>

    </div>
    <div id=\"tabs-2\">
    	<form id=\"frm2\" onsubmit=\"return submitform(this.id);\">
        <input type=\"hidden\" name=\"do\" value=\"update2\" />
        <table class=\"widget-tbl\" width=\"100%\">
          <tr>
            <td>reCAPTCHA&trade; public key</td>
            <td valign=\"top\"><input type=\"text\" name=\"recaptcha_publickey\" value=\"";
echo $settings['recaptcha_publickey'];
echo "\" class=\"input_text2\" /></td>
          </tr>
          <tr>
            <td>reCAPTCHA&trade; private key</td>
            <td valign=\"top\">
              <input type=\"text\" name=\"recaptcha_privatekey\" value=\"";
echo $settings['recaptcha_privatekey'];
echo "\" class=\"input_text2\" /></td>
          </tr>
          <tr>
            <td valign=\"top\">reCAPTCHA&trade; Theme</td>
            <td valign=\"top\">
            ";
$recaptchatheme = array("red" => "Red", "white" => "White", "blackglass" => "Black Glass", "clean" => "Clean");
foreach ($recaptchatheme as $theme => $value) {

	if ($settings['recaptcha_theme'] == $theme) {
		echo "<input type=\"radio\" name=\"recaptcha_theme\" value=\"" . $theme . "\" id=\"" . $value . "\" checked />";
		echo "<label for=\"" . $value . "\">" . $value . "</label><br>";
		continue;
	}

	echo "<input type=\"radio\" name=\"recaptcha_theme\" value=\"" . $theme . "\" id=\"" . $value . "\" />";
	echo "<label for=\"" . $value . "\">" . $value . "</label><br>";
}

echo "            </td>
          </tr>
          <tr>
          	<td></td>
            <td><input type=\"submit\" name=\"create\" value=\"Save\" /></td>
          </tr>
        </table>
        </form>
    </div>
    <div id=\"tabs-3\">
    	<form id=\"frm3\" onsubmit=\"return submitform(this.id);\">
        <input type=\"hidden\" name=\"do\" value=\"update3\" />
        <table class=\"widget-tbl\" width=\"100%\">
          <tr>
            <td>Challenge Key (C-key)</td>
            <td valign=\"top\"><input type=\"text\" name=\"solvemedia_ckey\" value=\"";
echo $settings['solvemedia_ckey'];
echo "\" class=\"input_text2\" /></td>
          </tr>
          <tr>
            <td>Verification Key (V-key)</td>
            <td valign=\"top\">
              <input type=\"text\" name=\"solvemedia_vkey\" value=\"";
echo $settings['solvemedia_vkey'];
echo "\" class=\"input_text2\" /></td>
          </tr>
          <tr>
            <td>Authentication Hash Key (H-key)</td>
            <td valign=\"top\">
              <input type=\"text\" name=\"solvemedia_hkey\" value=\"";
echo $settings['solvemedia_hkey'];
echo "\" class=\"input_text2\" /></td>
          </tr>

          <tr>
          	<td></td>
            <td><input type=\"submit\" name=\"create\" value=\"Save\" /></td>
          </tr>
        </table>
        </form>
    </div>
</div>

</div>
        ";
include SOURCES . "footer.php";
echo " ";
?>
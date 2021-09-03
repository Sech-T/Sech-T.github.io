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


if ($input->p['a'] == "profile") {
	verifyajax();
	verifydemo();
	$notes = $input->pc['notes'];
	$email = $input->pc['email'];
	$protection = ($input->p['protection'] == "yes" ? "1" : "0");
	$signature = $input->pc['signature'];

	if (validateEmail($email) !== true) {
		serveranswer(0, "Invalid email address.");
	}

	$data = array("email" => $email, "notes" => $notes, "signature" => $signature, "protection" => $protection);
	$db->update("admin", $data, "id=" . $admin->getId());
	serveranswer(1, "Profile was updated." . $restrict);
}


if ($input->p['a'] == "password") {
	verifyajax();
	verifydemo();

	if (md5($input->pc['password']) != $admin->getPassword()) {
		serveranswer(0, "Invalid current password.");
	}


	if (strlen($input->pc['new_password']) < 6) {
		serveranswer(0, "Your password must has 6 characters as minimum.");
	}


	if ($input->p['new_password'] != $input->p['new_password2']) {
		serveranswer(0, "New password does not match");
	}

	$data = array("password" => md5($input->pc['new_password']));
	$db->update("admin", $data, "id=" . $admin->getId());
	setcookie("c_pwd", md5($input->pc['new_password']));
	serveranswer(2, "Password was updated.");
}


if ($input->p['a'] == "pincode") {
	verifyajax();
	verifydemo();

	if (md5($input->p['pin_code']) != $admin->getPin()) {
		serveranswer(0, "Invalid current PIN code.");
	}


	if (strlen($input->p['newpin_code']) != 6 || !is_numeric($input->p['newpin_code'])) {
		serveranswer(0, "New PIN code must be a number of 6 digits");
	}


	if ($input->p['newpin_code'] != $input->p['newpin_code2']) {
		serveranswer(0, "New PIN code does not match");
	}

	$data = array("pin" => md5($input->p['newpin_code']));
	$db->update("admin", $data, "id=" . $admin->getId());
	serveranswer(4, "$(\"#\"+id).l2success(\"Pin code was updated... now you will be logged out.\"); setTimeout(\"location.href=location.href;\", 1000);");
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Update Account</div>
<div class=\"site_content\">
  <div id=\"tabs\">
        <ul>
            <li><a href=\"#tabs-1\">Profile</a></li>
            <li><a href=\"#tabs-2\">Change Password</a></li>
            <li><a href=\"#tabs-3\">Change PIN Code</a></li>
        </ul>
        <div id=\"tabs-1\">
        <form method=\"post\" id=\"frm\" onsubmit=\"return submitform(this.id);\">
            <input type=\"hidden\" name=\"a\" value=\"profile\" />
            <table width=\"100%\" class=\"widget-tbl\">
              <tr>
                <td align=\"right\">Email:</td>
                <td><input name=\"email\" type=\"text\" size=\"30\" value=\"";
echo $admin->getEmail();
echo "\" /></td>
              </tr>
              <tr>
                <td align=\"right\">Account protection:</td>
                <td><input type=\"checkbox\" name=\"protection\" value=\"yes\" ";
echo $admin->getProtection() == 1 ? "checked" : "";
echo " />  Tick to enable - A verification code will be sent via email if IP is different to the last IP of login</td>
              </tr>
              <tr>
                <td width=\"200\" align=\"right\">Personal Notes:</td>
                <td><textarea name=\"notes\" id=\"mynotes2\" cols=\"45\" rows=\"5\">";
echo $admin->getNotes();
echo "</textarea></td>
              </tr>
              <tr>
                <td width=\"200\" align=\"right\">Support signature:</td>
                <td><textarea name=\"signature\"  cols=\"45\" rows=\"5\">";
echo $admin->getSignature();
echo "</textarea></td>
              </tr>
              <tr>
                <td></td>
                <td>
                <input type=\"submit\" name=\"send\" value=\"Send\" />
                </td>
              </tr>
            </table>
        </form>
        </div>
        <div id=\"tabs-2\">
        <form method=\"post\" id=\"frm2\" onsubmit=\"return submitform(this.id);\">
            <input type=\"hidden\" name=\"a\" value=\"password\" />
            <table width=\"100%\" class=\"widget-tbl\">
              <tr>
                <td width=\"200\" align=\"right\">Current Password:</td>
                <td><input name=\"password\" type=\"password\" size=\"30\" /></td>
              </tr>
              <tr>
                <td align=\"right\">New Password:</td>
                <td><input name=\"new_password\" type=\"password\" size=\"30\" /></td>
              </tr>
              <tr>
                <td align=\"right\">Confirm New Password:</td>
                <td><input name=\"new_password2\" type=\"password\" size=\"30\" /></td>
              </tr>
              <tr>
                <td></td>
                <td>
                <input type=\"submit\" name=\"send\" value=\"Send\" />
                </td>
              </tr>
            </table>
        </form>


        </div>
		<div id=\"tabs-3\">
        <div class=\"info_box\">PIN Code must be a number of 6 digits</div>
        <form method=\"post\" id=\"frm3\" onsubmit=\"return submitform(this.id);\">
            <input type=\"hidden\" name=\"a\" value=\"pincode\" />
            <table width=\"100%\" class=\"widget-tbl\">
              <tr>
                <td width=\"200\" align=\"right\">Current PIN Code:</td>
                <td><input name=\"pin_code\" type=\"password\" size=\"30\" /></td>
              </tr>
              <tr>
                <td align=\"right\">New PIN Code:</td>
                <td><input name=\"newpin_code\" type=\"password\" size=\"30\" /></td>
              </tr>
              <tr>
                <td align=\"right\">Confirm New PIN Code:</td>
                <td><input name=\"newpin_code2\" type=\"password\" size=\"30\" /></td>
              </tr>
              <tr>
                <td></td>
                <td>
                <input type=\"submit\" name=\"send\" value=\"Send\" />
                </td>
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
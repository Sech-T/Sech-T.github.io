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


if ($input->p['do'] == "create_admin") {
	verifyajax();
	verifydemo();

	if (!$input->p['username']) {
		serveranswer(0, "Enter a username");
	}


	if (!$input->p['password']) {
		serveranswer(0, "Enter a password");
	}


	if (!$input->p['email']) {
		serveranswer(0, "Enter an email");
	}


	if (strlen($input->pc['password']) < 6) {
		serveranswer(0, "Password must has 6 characters as minimum.");
	}


	if (!is_numeric($input->p['pin']) || strlen($input->p['pin']) != 6) {
		serveranswer(0, "PIN code must be a number of 6 digits");
	}


	if (validateEmail($input->p['email']) !== true) {
		serveranswer(0, "Invalid email address.");
	}

	$chk = $db->fetchOne(("SELECT COUNT(*) AS NUM FROM admin WHERE username='" . $input->p['username'] . "'"));

	if ($chk != 0) {
		serveranswer(0, "Username is being used by other administrator.");
	}

	$chk = $db->fetchOne(("SELECT COUNT(*) AS NUM FROM admin WHERE email='" . $input->p['email'] . "'"));

	if ($chk != 0) {
		serveranswer(0, "E-mail is being used by other administrator.");
	}

	$perms = array();
	foreach ($admin_permissions as $k => $descr) {
		$perms[$k] = ($input->p['perm'][$k] ? $input->p['perm'][$k] : 0);
	}

	$perms = serialize($perms);
	$set = array("username" => $input->pc['username'], "password" => md5($input->pc['password']), "email" => $input->pc['email'], "pin" => md5($input->p['pin']), "permissions" => $perms);
	$db->insert("admin", $set);
	serveranswer(5, "New admin account was created, <a href='#' onclick='history.back();'>click here to return.</a>");
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Create a new administrator</div>
<div class=\"site_content\">
<form method=\"post\" id=\"frm1\" onsubmit=\"return submitform(this.id);\">
<input type=\"hidden\" name=\"do\" value=\"create_admin\" />
<div id=\"tabs\">
	<ul>
    	<li><a href=\"#tab-1\">General</a></li>
        <li><a href=\"#tab-2\">Permissions</a></li>
    </ul>
    <div id=\"tab-1\">
    <table class=\"widget-tbl\" width=\"100%\">
      <tr>
        <td width=\"300\" align=\"right\">Username:</td>
        <td><input name=\"username\" type=\"text\" /></td>
        </tr>
      <tr>
        <td align=\"right\">Password</td>
        <td><input name=\"password\" type=\"password\" /> (6 characters minimum)</td>
      </tr>
      <tr>
        <td align=\"right\">PIN Code</td>
        <td><input name=\"pin\" type=\"password\" /> (Number of 6 digits)</td>
      </tr>
      <tr>
        <td align=\"right\">E-mail</td>
        <td><input name=\"email\" type=\"text\" /></td>
      </tr>
      <tr>
      	        <td></td>
        <td>
        <input type=\"submit\" name=\"create\" value=\"Create\" />
         <input type=\"button\" name=\"btn\" value=\"Return\" onclick=\"history.back();\" />
        </td>
      </tr>
    </table>
	</div>
    <div id=\"tab-2\">
    <table class=\"widget-tbl\" width=\"100%\">
      ";
foreach ($admin_permissions as $k => $descr) {
	echo "      <tr>
        <td align=\"right\" width=\"300\">";
	echo $descr;
	echo "</td>
        <td><input type=\"checkbox\" name=\"perm[";
	echo $k;
	echo "]\" value=\"1\" checked=\"checked\" /></td>
      </tr>
      ";
}

echo "      <tr>
      	        <td></td>
        <td>
        <input type=\"submit\" name=\"create\" value=\"Create\" />
         <input type=\"button\" name=\"btn\" value=\"Return\" onclick=\"history.back();\" />
        </td>
      </tr>
    </table>
	</div>
</div>
    </form>

    </div>
        ";
include SOURCES . "footer.php";
echo " ";
?>
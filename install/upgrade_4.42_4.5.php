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

function show_header($error = null) {
	global $software_version;

	$html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>PTCEvolution v" . $software_version . " - Installation Wizard</title>
<style>
body{
background:#efefef;
font-family:Arial, Helvetica, sans-serif;
color:#999999;
font-size:12px;
}
input[type=\"text\"], input[type=\"password\"], select, textarea{
color:#2a2a2a;
font-family:'lucida grande',tahoma,verdana,arial,sans-serif;
font-size:11px;
padding:4px;
border: 1px solid #bec5c9;
background: #ffffff;
border-radius: 5px;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;
min-width:150px;
}
input[type=\"button\"], input[type=\"submit\"]{
padding: 5px 9px;
color: #444444;
border: solid 1px #e0e0e0;
background: #f8f8f8;
cursor: pointer;
font-size:12px;
font-family:'lucida grande',tahoma,verdana,arial,sans-serif;
border-radius: 5px;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;

}
input[type=\"button\"]:hover, input[type=\"submit\"]:hover{
padding: 5px 9px;
color: #ffffff;
border: solid 1px #7aa743;
background: #89bd53;
background:#f1f1f1;
background: -webkit-gradient(linear, left top, left bottom, from(#a3cc79), to(#80b647));
background: -moz-linear-gradient(top, #a3cc79, #80b647);
filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#a3cc79', endColorstr='#80b647');
text-shadow:#5f833a 0.1em 0.1em 0.1em;
cursor: pointer;
font-size:12px;
font-family:'lucida grande',tahoma,verdana,arial,sans-serif;
border-radius: 5px;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;
}

.content {
    background: none repeat scroll 0 0 #F6F6F6;
    border: 1px solid #D7D7D7;
    margin: 10px 0;
    padding: 20px;
}
h1 {
    color: #56595E;
    font-family: arial,helvetica,sans-serif;
    font-size: 24px;
    font-weight: normal;
    margin: 0;
    padding-bottom: 5px;
	margin-bottom:20px;
}
h2{
	font-weight:normal;
	font-size: 18px;
	color:#6d7278;
	font-family: arial,helvetica,sans-serif;
}
.error_box{
border:1px solid #dddddd;
background:#f1f1f1;
color: #e595a8;
padding:10px;
font-size:12px;
margin-bottom:5px;
}
.enabled{
font-weight:bold;
color:green;
}
.disabled{
font-weight:bold;
color:red;
}
</style>
</head>
<body>
	<div style=\"width:600px; margin:0 auto\">
    	<div class=\"content\">
		<h1>PTCEvolution " . $software_version . "</h1>
		" . ($error ? "<div class=\"error_box\">" . $error . "</div>" : "");
	echo $html;
}

function show_footer() {
	$html = "       </div>
        <div style=\"color:#999999; font-size:12px\">Copyright &copy; 2010 - 2012 PTCEvolution.com</div>
    </div>
</body>
</html>
";
	echo $html;
}

define("EvolutionScript", 1);
session_start();
define("REALPATH", str_replace("install", "", dirname(__FILE__)));
require_once "../includes/global.php";

if ($_SESSION['license_pass'] !== true) {
	$chkadmin = new VData();
	$chkadmin->details($ptcevolution->config['Misc']['license']);
	$chkadmin->getinfo();
	$chkadmin->validate($ptcevolution->config['Misc']['license']);

	if ($chkadmin->checkstatus !== true) {
		define("ALLOWED", "no");
	}
	else {
		if ($chkadmin->info['support'] < time()) {
			define("ALLOWED", "no");
		}
		else {
			define("ALLOWED", "yes");
			$_SESSION['license_pass'] = true;
		}
	}
}
else {
	define("ALLOWED", "yes");
}

$software_version = "4.5";
define("terms", $input->r['terms']);
define("install_path", $input->r['install_path']);
define("url", $input->r['url']);
define("servername", $input->r['servername']);
define("dbname", $input->r['dbname']);
define("dbusername", $input->r['dbusername']);
define("dbpassword", $input->r['dbpassword']);
define("licensekey", $input->r['licensekey']);
define("creating_table", $input->r['creating_table']);
$datasql[] = "UPDATE `language` SET `version` = '" . $software_version . "' WHERE `language`.`id` =1 LIMIT 1 ;";
$datasql[] = "UPDATE `templates` SET `version` = '" . $software_version . "' WHERE `templates`.`id` =1 LIMIT 1 ;";
$datasql[] = "INSERT INTO `statistics` (`field` ,`value`)VALUES ('members', '0');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('usersonline', '0');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('copyright', '0');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('timezone', '');";
$datasql[] = "UPDATE buyoptions SET hook_verify='yes' WHERE name = 'referrals'";
$datasql[] = "ALTER TABLE `admin` ADD `pin` VARCHAR(200) NULL DEFAULT NULL AFTER `password` ,ADD `last_ip` VARCHAR(200) NULL DEFAULT NULL AFTER `pin`;";
$datasql[] = "ALTER TABLE `admin` ADD `protection` INT(2) NOT NULL DEFAULT '0' AFTER `signature` ,ADD `check_code` VARCHAR(200) NULL DEFAULT NULL AFTER `protection`";
$datasql[] = "UPDATE admin SET pin='e10adc3949ba59abbe56e057f20f883e'";

if ($input->g['do'] == "finish" && $_SESSION['upgrade_done']) {
	show_header();
	echo "<h2>Upgrade complete</h2>";
	echo "<div style=\"padding-bottom:5px\">Congratulations! Your PTCEvolution upgrade is now complete!<br>Pin code of administrators is: 123456</div>";
	show_footer();
	exit();
}

switch ($input->r['step']) {
	case "3":
		if (terms && ALLOWED == "yes") {
			if ($input->p['username'] && $input->p['password']) {
				$chk = $db->fetchOne("SELECT COUNT(*) AS NUM FROM admin WHERE username='" . $input->pc['username'] . "' AND password='" . md5($input->pc['password']) . "'");

				if ($chk != 0) {
					$myFile = REALPATH . "/includes/config.php";
					$fh = @fopen($myFile, "w");

					if ($fh) {
						$configtxt = "<?php
";
						$configtxt .= "$config['Database']['servername'] = '" . $ptcevolution->config['Database']['servername'] . "';
";
						$configtxt .= "$config['Database']['dbname'] = '" . $ptcevolution->config['Database']['dbname'] . "';
";
						$configtxt .= "$config['Database']['username'] = '" . $ptcevolution->config['Database']['username'] . "';
";
						$configtxt .= "$config['Database']['password'] = '" . $ptcevolution->config['Database']['password'] . "';
";
						$configtxt .= "$config['Misc']['license'] = '" . $ptcevolution->config['Misc']['license'] . "';
";
						$configtxt .= "$config['Misc']['version'] = '" . $software_version . "';
";
						$configtxt .= "?>";
						fwrite($fh, $configtxt);
						fclose($fh);
						$_SESSION['upgrade_done'] = 1;
						show_header();
						echo "<h2>Inserting data</h2>";
						foreach ($datasql as $query) {
							$db->query($query);
							echo " . ";
							flush();
							ob_flush();
						}

						$sql_statements = file_get_contents("ip2nation.sql");
						$arr_sql = preg_split("/;[\n\r]+/", $sql_statements);
						reset($arr_sql);
						$arr_success = array();
						$arr_failure = array();

						while (list($k,$v) = each($arr_sql)) {
							if (trim($v) != "") {
								$db->query($v);
								echo " . ";
								ob_flush();
								flush();
							}
						}

						echo "done. <div style=\"text-align:right; padding-top:20px;\"><input type=\"button\" name=\"btn\" value=\"Next &raquo;\" onclick=\"location.href='?do=finish';\" /></div>
							<script>setTimeout(\"location.href='?do=finish';\", 5000);</script>";
						show_footer();
					} else $show_error = "Can't open config.php";
				} else $show_error = "Invalid username or password.";
			} else$show_error = "Enter your username and password.";
		}
		break;

	case "2":
		if ($input->r['terms'] && ALLOWED == "yes") {
			show_header($show_error);
			echo "<form method=\"post\"><input type=\"hidden\" name=\"step\" value=\"3\">
				<input type=\"hidden\" name=\"terms\" value=\"" . terms . "\">
				<h2>Verification Required</h2>
				<table width=100%>
					<tr>
						<td width=150><strong>Admin username:</strong></td>
						<td><input type=\"text\" name=\"username\" style=\"width:300px\"></td>
					</tr>
					<tr>
						<td width=150><strong>Admin password:</strong></td>
						<td><input type=\"password\" name=\"password\" value=\"\" style=\"width:300px\"></td>
					</tr>
				</table>
				<div style=\"text-align:right; padding-top:20px;\"><input type=\"submit\" name=\"btn\" value=\"Next &raquo;\" /></div>
				</form>";
			show_footer();
		} else {
			$show_error = "You must accept the license agreement to continue";
			show_header($show_error);
		}
		break;

	case "1":
		if (ALLOWED == "yes" && $input->r['php_req']) {
			show_header($show_error);
			echo "<form method=\"post\">
				<input type=\"hidden\" name=\"step\" value=\"2\">
				<input type=\"hidden\" name=\"php_req\" value=\"1\">
				<input type=\"hidden\" name=\"file_req\" value=\"1\">
				<div>Please read and agree the End User License Agreement before continuing.</div>
				<div style=\"padding-top:10px\"><textarea style=\"width:100%; height:200px;\">PTCEvolution Software License Agreement

	Please read this End-User License Agreement (the \"EULA\")

	IMPORTANT --- READ CAREFULLY. By installing, copying, or otherwise using the Software, you are agreeing to be bound by the terms of this EULA, including the WARRANTY DISCLAIMERS, LIMITATIONS OF LIABILITY, and TERMINATION PROVISIONS. If you do not agree to the terms of this EULA do not install or use the Software.

	LICENSE TERMS

	1. The Software is supplied by PTCEvolution and is licensed, not sold, under the terms of this EULA and PTCEvolution reserves all rights not expressly granted to you. PTCEvolution retains the ownership of the Software.

	2. Software License:

	a. PTCEvolution grants you a license to use one copy of the Software. You may not modify or disable any licensing or control features of the Software.

	b. This Software is licensed to operate on only one domain.

	c. Only one company may use the Software for its intended purpose on the domain. This company may not sell the products or services of other companies in the capacity of an on-line mall or buyer service. If more than one company wishes to use the Software they must purchase a separate license.

	3. License Restrictions:

	a. By accepting this EULA you are agreeing not to reverse engineer, decompile, or disassemble the Software Application, except and only to the extent that such activity is expressly permitted by applicable law notwithstanding this limitation.

	b. You are the exclusive licensee of the Software and sharing any source code of the Software with any individual or entity is a violation of copyright laws and international treaties and cause for license termination.

	c. Modifying any portion of the Software source code or asking any individual or entity to modify the Software source code other than PTCEvolution is a violation of copyright laws and international treaties and cause for license termination.

	d. If you upgrade the Software to a higher version of the Software, this EULA is terminated and your rights shall be limited to the EULA associated with the higher version.

	4. Proprietary Rights: All title and copyrights in and to the Software (including, without limitation, any images, photographs, animations, video, audio, music, text, and \"applets\" incorporated into the Software Application), the accompanying media and printed materials, and any copies of the Software are owned by PTCEvolution. The Software is protected by copyright laws and international treaty provisions. Therefore, you must treat the Software like any other copyrighted material, subject to the provisions of this EULA.

	5. Termination Rights: Without prejudice to any other rights, PTCEvolution may terminate this EULA if you fail to comply with the terms and conditions of this EULA. In such event, you must destroy all copies of the Software and all of its component parts, and PTCEvolution may suspend or deactivate your use of the Software with or without notice.

	6. Export Control: You may not export or re-export the Software or any copy or adaptation of the Software in violation of any applicable laws or regulations.

	7. PTCEvolution does not warrant that the operation of PTCEvolution Software will be uninterrupted or error free. PTCEvolution Software may contain third-party functions or may have been subject to incidental use.

	8. PTCEvolution is not responsible for problems resulting from improper or inadequate maintenance or configuration; software or interface routines or functions NOT developed by PTCEvolution; unauthorized specifications for the Software; improper site preparation or maintenance; Beta Software; encryption mechanisms or routines.

	Good data processing procedure dictates that any program be thoroughly tested with non-critical data before relying on it. The user must assume the entire risk of using the Software. IN NO EVENT WILL PTCEvolution OR ITS SUPPLIERS BE LIABLE FOR DIRECT, SPECIAL, INCIDENTAL, CONSEQUENTIAL (INCLUDING LOST PROFIT OR LOST SAVINGS) OR OTHER DAMAGE WHETHER BASED IN CONTRACT, TORT, OR OTHERWISE EVEN IF A PTCEvolution REPRESENTATIVE HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES, OR FOR ANY CLAIM BY ANY THIRD PARTY. Some states or provinces do not allow the exclusion or limitation of incidental or consequential damages, so the above limitation or exclusion may not apply to you.

	9. Submissions: Should you decide to transmit to PTCEvolution by any means or by any media any information (including, without limitation, ideas, concepts, or techniques for new or improved services and products), whether as information, feedback, data, questions, comments, suggestions, or the like, you agree such submissions are unrestricted and shall be deemed non-confidential and you automatically grant PTCEvolution and its assigns a non-exclusive, royalty-free, worldwide, perpetual, irrevocable license, with the right to sublicense, to use, copy, transmit, distribute, create derivative works of, display, and perform the same.

	10. Distribution and Backups

	a. DISTRIBUTION OF THE REGISTERED VERSION OF THE Software IS STRICTLY PROHIBITED and is a violation of United States copyright laws and international treaties punishable by severe criminal and civil penalties.

	b. You may make copies of the Registered Version of the Software for backup purposes only. All backup copies must be an exact copy of the original Software.

	11. Refunds Policy: Refunds are only issued for software failure. Refunds are not issued for server failure/issues, lack of features or if your server does not meet the Software Requirements. Refunds are determined on individual circumstances and only issued once our technical staff determine that PTCEvolution has a fault causing it to not run on your server. Installation charges are not refundable under any circumstances. Refunds are not available after 5 days from purchase date.</textarea></div>
				<div><label><input type=\"checkbox\" name=\"terms\" > I agree to the license agreement</label></div>
				<div style=\"text-align:right; padding-top:20px;\"><input type=\"submit\" name=\"btn\" value=\"Next &raquo;\" /></div>
				</form>";
			show_footer();
		}
		break;

	default:
		show_header();
		$pass = true;
		echo "<form method=\"post\">
					<input type=\"hidden\" name=\"step\" value=\"1\">
		    	    <div>Welcome to the upgrade routine for PTCEvolution. This wizard will guide you through the upgrade process.</div>
					<h2>Checking requirements</h2>
					";

		if (ALLOWED == "no") {
			echo "<strong>Support overview:</strong> <span class=\"disabled\">EXPIRED (" . date("dS M, Y", $chkadmin->info['support']) . ")</span><br>";
			$pass = false;
		}
		else {
			echo "<strong>Support overview:</strong> <span class=\"enabled\">Passed</span><br>";
		}


		if (is_writable(REALPATH . "/includes/config.php")) {
			if (is_writable(REALPATH . "/templates_c/ModernBlue/")) {
				if (is_writable(REALPATH . "/upload/")) {
					echo "<strong>Required files:</strong> <span class=\"enabled\">Passed</span><br>";
					echo "<input type=\"hidden\" name=\"file_req\" value=\"1\">";
				}
				else {
					echo "<strong>/upload/:</strong> <span class=\"disabled\">is not writable</span><br>";
					$pass = false;
				}
			}
			else {
				echo "<strong>/templates_c/ModernBlue/:</strong> <span class=\"disabled\">is not writable</span><br>";
				$pass = false;
			}
		}
		else {
			echo "<strong>/includes/config.php:</strong> <span class=\"disabled\">is not writable</span><br>";
			$pass = false;
		}


		if ($ptcevolution->config['Misc']['version'] < $software_version) {
			echo "<strong>Current software version:</strong> <span class=\"enabled\">Passed</span><br>";
		}
		else {
			echo "<strong>Current software version:</strong> <span class=\"disabled\">Your site can not be upgraded</span><br>";
			$pass = false;
		}


		if (in_array("curl", get_loaded_extensions())) {
			echo "<strong>PHP Extensions Overview:</strong> <span class=\"enabled\">Passed</span><br>";
			echo "<input type=\"hidden\" name=\"php_req\" value=\"1\">";
		}
		else {
			echo "CURL: <span class=\"disabled\">Disable</span><br>";
			$pass = false;
		}


		if ($pass === true) {
			echo "
		        	<div style=\"text-align:right; padding-top:20px;\"><input type=\"submit\" name=\"btn\" value=\"Next &raquo;\" /></div>";
		}

		echo "
					</form>";
		show_footer();
		break;
}
?>
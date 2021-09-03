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
<title>EvolutionScript v" . $software_version . " - Installation Wizard</title>
<style>
body{
background:#ededed;
font-family:Arial, Helvetica, sans-serif;
color:#3f3f3b;
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
padding: 7px 12px;
color: #ffffff;
border:0px;
background: #4c4c4c;
cursor: pointer;
font-size:14px;
font-family:\"Open Sans\", \"HelveticaNeue\", \"Helvetica Neue\", Helvetica, Arial, sans-serif;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
 transition-property: background;
transition-duration: 0.2s;
transition-timing-function: linear;
}
input[type=\"button\"]:hover, input[type=\"submit\"]:hover{
background: #c62020;
}

.content {
    background: none repeat scroll 0 0 #FFF;
    border: 1px solid #D7D7D7;
    margin: 10px 0;
    padding: 20px;
}
h1 {
    color: #3f3f3b;
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
	color:#3f3f3b;
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
		<div style=\"padding-bottom:20px;\"><a href=\"http://www.evolutionscript.com\" target=\"_blank\"><img src=\"logo.png\" border=\"0\"></a></div>
		" . ($error ? "<div class=\"error_box\">" . $error . "</div>" : "");
	echo $html;
}

function show_footer() {
	$html = "       </div>
        <div style=\"color:#999999; font-size:12px\">Copyright &copy; 2010 - 2014 EvolutionScript.com</div>
    </div>
</body>
</html>
";
	echo $html;
}

define("EvolutionScript", 1);
session_start();
define("REALPATH", dirname(dirname(__FILE__)));
require_once "../includes/global.php";
$todayclick = $db->fetchOne("SELECT value FROM settings WHERE field='todayclick'");
$datasql[] = "UPDATE members SET chart_num='" . $todayclick . "';";

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

$software_version = "5.0";
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
$datasql[] = "CREATE TABLE IF NOT EXISTS `mail_settings` (
  `field` varchar(200) NOT NULL,
  `value` varchar(200) DEFAULT NULL,
  UNIQUE KEY `field` (`field`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$datasql[] = "CREATE TABLE IF NOT EXISTS `email_template` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(100) NOT NULL,
  `type` enum('plain','html') NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject` varchar(250) DEFAULT NULL,
  `message_plain` text,
  `message_html` text,
  PRIMARY KEY (`oid`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
$datasql[] = "CREATE TABLE IF NOT EXISTS `payeer_orders` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `upgrade` int(2) NOT NULL default '0',
  `membership_id` int(11) default '0',
  `batch` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
$datasql[] = "INSERT INTO `mail_settings` (`field`, `value`) VALUES
('email_from_address', 'noreply@evolutionscript.com'),
('email_from_name', 'EvolutionScript Staff'),
('email_type', 'php'),
('smtp_host', ''),
('smtp_password', ''),
('smtp_port', '25'),
('smtp_ssl', ''),
('smtp_username', '');";
$datasql[] = "INSERT INTO `email_template` (`oid`, `id`, `type`, `name`, `subject`, `message_plain`, `message_html`) VALUES
(1, 'registration_activation', 'plain', 'Registration Activation Notification', 'Action Required to Activate Membership for %site_name%', 'Dear %fullname%,

Thank you for registering at the %site_name%. Before we can activate your account one last step must be taken to complete your registration.

Please note: you must complete this last step to become a registered member. You will only need to visit this URL once to activate your account.

To complete your registration, please visit this URL:

%activation_url_code%

**** Does The Above URL Not Work? ****

If the above URL does not work, please use your Web browser to go to:

%activation_url%

Your Username is: %username%
Your Activation ID is: %activation_code%

If you are still having problems signing up please contact a member of our support staff.

All the best,
%site_name% Team.', '<p>Dear %fullname%,<br /><br />Thank you for registering at the %site_name%. Before we can activate your account one last step must be taken to complete your registration.<br /><br />Please note: you must complete this last step to become a registered member. You will only need to visit this URL once to activate your account.<br /><br />To complete your registration, please visit this URL:<br /><br />%activation_url_code%<br /><br />**** Does The Above URL Not Work? ****<br /><br />If the above URL does not work, please use your Web browser to go to:<br /><br />%activation_url%<br /><br />Your Username is: %username%<br />Your Activation ID is: %activation_code%<br /><br />If you are still having problems signing up please contact a member of our support staff.<br /><br />All the best,<br />%site_name% Team.</p>'),
(2, 'registration_complete', 'plain', 'Registration Completion Notification', 'Welcome to %site_name%!', 'Dear %fullname%,

Thanks for registering at %site_name%! We are glad you have chosen to be a part of our community and we hope you enjoy your stay.

All the best,
%site_name% Team.', '<p>Dear %fullname%,</p>
<p>Thanks for registering at %site_name%!</p>
<p>We are glad you have chosen to be a part of our community and we hope you enjoy your stay.</p>
<p>&nbsp;</p>
<p>All the best, <br />%site_name% Team.</p>'),
(3, 'forgot_password', 'plain', 'Password Reset Notification', 'New Password Required for %site_name%', 'Dear %fullname%

Your request for a new password was sucessfully processed.

New password: %newpassword%

All the best,
%site_name% Team.', '<p>Dear %fullname%<br /><br />Your request for a new password was sucessfully processed.<br /><br />New password: %newpassword%<br /><br />All the best,<br />%site_name% Team.</p>'),
(4, 'newmail_verification', 'plain', 'New Email Verification', 'Action Required to Change Email for %site_name%', 'Dear %fullname%

You have been update your %site_name% account, but before we can change your email one last step must be taken to complete this operation.

Go to your personal settings and enter the next activation id.

Your Activation ID is: %activation_code%

All the best,
%site_name% Team.', '<p>Dear %fullname%<br /><br />You have been update your %site_name% account, but before we can change your email one last step must be taken to complete this operation.<br /><br />Go to your personal settings and enter the next activation id.<br /><br />Your Activation ID is: %activation_code%<br /><br />All the best,<br />%site_name% Team.</p>'),
(5, 'support_ticket_creation', 'plain', 'Support Ticket Creation', '[%ticket_id%] Support Request', '*************************************
%site_name% Support
*************************************

You have submitted a support ticket to %site_name%

Your ticket number is %ticket_id%

You will receive a response within 48 hours.

Best regards,
%site_name% Team.', '<p>*************************************<br />%site_name% Support<br />*************************************<br /><br />You have submitted a support ticket to %site_name%<br /><br />Your ticket number is %ticket_id%<br /><br />You will receive a response within 48 hours.<br /><br />Best regards,<br />%site_name% Team.</p>'),
(6, 'support_ticket_answer', 'plain', 'Support Ticket Answer', '[%ticket_id%] Ticket Reply', '*************************************
%site_name% Support
*************************************

Your support ticket submitted to %site_name% was replied by our staff.

Your ticket number is %ticket_id%

Best regards,
%site_name% team.', '<p>*************************************<br />%site_name% Support<br />*************************************<br /><br />Your support ticket submitted to %site_name% was replied by our staff.<br /><br />Your ticket number is %ticket_id%<br /><br />Best regards,<br />%site_name% team.</p>');";
$datasql[] = "ALTER TABLE `settings` ADD PRIMARY KEY(`field`);";
$datasql[] = "ALTER TABLE `members` ADD `last_cron` DATE NULL DEFAULT NULL ;";
$datasql[] = "ALTER TABLE `site_content` CHANGE `name` `id` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ;";
$datasql[] = "ALTER TABLE `site_content` ADD INDEX (`id`) ;";
$datasql[] = "ALTER TABLE `cron_settings` ADD PRIMARY KEY(`field`);";
$datasql[] = "ALTER TABLE `statistics` ADD PRIMARY KEY(`field`);";
$datasql[] = "ALTER TABLE `members` ADD `chart_num` INT(11) NOT NULL DEFAULT '0';";
$datasql[] = "INSERT INTO `gateways` (`id`, `name`, `account`, `allow_deposits`, `allow_withdrawals`, `allow_upgrade`, `withdraw_fee`, `withdraw_fee_fixed`, `currency`, `option1`, `option2`, `option3`, `option4`, `option5`, `min_deposit`, `total_withdraw`, `total_deposit`, `status`) VALUES
(7, 'Payeer', '123456', 'yes', 'yes', 'yes', '0', 0.000, 'USD', 'Shop Key', 'P123456', '123456', 'API Key', 'Payment From %sitename% to member %username%', 0.00, 0.00, 4.00, 'Active');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('force_viewads', '1');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('autoloadad_secs', '7');";
$datasql[] = "ALTER TABLE `gateways` ADD `option6` VARCHAR(255) NULL DEFAULT NULL AFTER `option5` ;";
$todayclick = $db->fetchOne("SELECT value FROM settings WHERE field='todayclick'");
$lastcron = date("Y-m-d");
$datasql[] = "UPDATE members SET chart_num='" . $todayclick . "';";
$datasql[] = "UPDATE members SET last_cron='" . $lastcron . "';";
$datasql[] = "ALTER TABLE `addon` ADD PRIMARY KEY (`name`) ;";
$datasql[] = "ALTER TABLE `addon` ENGINE = InnoDB;";
$datasql[] = "ALTER TABLE `membership` ENGINE = InnoDB;";

if ($input->g['do'] == "finish" && $_SESSION['upgrade_done']) {
	show_header();
	echo "<h2>Upgrade complete</h2>";
	echo "<div style=\"padding-bottom:5px\">Congratulations! Your EvolutionScript upgrade is now complete!</div>";
	show_footer();
	exit();
}

switch ($input->r['step']) {
	case "3":
		if (terms && ALLOWED == "yes") {
			if ($input->p['username'] && $input->p['password']) {
				$chk = $db->fetchOne("SELECT COUNT(*) AS NUM FROM admin WHERE username='" . $db->real_escape_string($input->pc['username']) . "' AND password='" . md5($input->pc['password']) . "'");

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

						echo "done. <div style=\"text-align:right; padding-top:20px;\"><input type=\"button\" name=\"btn\" value=\"Next &raquo;\" onclick=\"location.href='?do=finish';\" /></div>
							<script>setTimeout(\"location.href='?do=finish';\", 5000);</script>";
						show_footer();
					} else $show_error = "Can't open config.php";
				} else $show_error = "Invalid username or password.";
			} else $show_error = "Enter your username and password.";
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
				<div style=\"padding-top:10px\"><textarea style=\"width:100%; height:200px;\">EvolutionScript Software License Agreement

	Please read this End-User License Agreement (the \"EULA\")

	IMPORTANT --- READ CAREFULLY. By installing, copying, or otherwise using the Software, you are agreeing to be bound by the terms of this EULA, including the WARRANTY DISCLAIMERS, LIMITATIONS OF LIABILITY, and TERMINATION PROVISIONS. If you do not agree to the terms of this EULA do not install or use the Software.

	LICENSE TERMS

	1. The Software is supplied by EvolutionScript and is licensed, not sold, under the terms of this EULA and EvolutionScript reserves all rights not expressly granted to you. EvolutionScript retains the ownership of the Software.

	2. Software License:

	a. EvolutionScript grants you a license to use one copy of the Software. You may not modify or disable any licensing or control features of the Software.

	b. This Software is licensed to operate on only one domain.

	c. Only one company may use the Software for its intended purpose on the domain. This company may not sell the products or services of other companies in the capacity of an on-line mall or buyer service. If more than one company wishes to use the Software they must purchase a separate license.

	3. License Restrictions:

	a. By accepting this EULA you are agreeing not to reverse engineer, decompile, or disassemble the Software Application, except and only to the extent that such activity is expressly permitted by applicable law notwithstanding this limitation.

	b. You are the exclusive licensee of the Software and sharing any source code of the Software with any individual or entity is a violation of copyright laws and international treaties and cause for license termination.

	c. Modifying any portion of the Software source code or asking any individual or entity to modify the Software source code other than EvolutionScript is a violation of copyright laws and international treaties and cause for license termination.

	d. If you upgrade the Software to a higher version of the Software, this EULA is terminated and your rights shall be limited to the EULA associated with the higher version.

	4. Proprietary Rights: All title and copyrights in and to the Software (including, without limitation, any images, photographs, animations, video, audio, music, text, and \"applets\" incorporated into the Software Application), the accompanying media and printed materials, and any copies of the Software are owned by EvolutionScript. The Software is protected by copyright laws and international treaty provisions. Therefore, you must treat the Software like any other copyrighted material, subject to the provisions of this EULA.

	5. Termination Rights: Without prejudice to any other rights, EvolutionScript may terminate this EULA if you fail to comply with the terms and conditions of this EULA. In such event, you must destroy all copies of the Software and all of its component parts, and EvolutionScript may suspend or deactivate your use of the Software with or without notice.

	6. Export Control: You may not export or re-export the Software or any copy or adaptation of the Software in violation of any applicable laws or regulations.

	7. EvolutionScript does not warrant that the operation of EvolutionScript Software will be uninterrupted or error free. EvolutionScript Software may contain third-party functions or may have been subject to incidental use.

	8. EvolutionScript is not responsible for problems resulting from improper or inadequate maintenance or configuration; software or interface routines or functions NOT developed by EvolutionScript; unauthorized specifications for the Software; improper site preparation or maintenance; Beta Software; encryption mechanisms or routines.

	Good data processing procedure dictates that any program be thoroughly tested with non-critical data before relying on it. The user must assume the entire risk of using the Software. IN NO EVENT WILL EvolutionScript OR ITS SUPPLIERS BE LIABLE FOR DIRECT, SPECIAL, INCIDENTAL, CONSEQUENTIAL (INCLUDING LOST PROFIT OR LOST SAVINGS) OR OTHER DAMAGE WHETHER BASED IN CONTRACT, TORT, OR OTHERWISE EVEN IF A EvolutionScript REPRESENTATIVE HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES, OR FOR ANY CLAIM BY ANY THIRD PARTY. Some states or provinces do not allow the exclusion or limitation of incidental or consequential damages, so the above limitation or exclusion may not apply to you.

	9. Submissions: Should you decide to transmit to EvolutionScript by any means or by any media any information (including, without limitation, ideas, concepts, or techniques for new or improved services and products), whether as information, feedback, data, questions, comments, suggestions, or the like, you agree such submissions are unrestricted and shall be deemed non-confidential and you automatically grant EvolutionScript and its assigns a non-exclusive, royalty-free, worldwide, perpetual, irrevocable license, with the right to sublicense, to use, copy, transmit, distribute, create derivative works of, display, and perform the same.

	10. Distribution and Backups

	a. DISTRIBUTION OF THE REGISTERED VERSION OF THE Software IS STRICTLY PROHIBITED and is a violation of United States copyright laws and international treaties punishable by severe criminal and civil penalties.

	b. You may make copies of the Registered Version of the Software for backup purposes only. All backup copies must be an exact copy of the original Software.

	11. Refunds Policy: Refunds are only issued for software failure. Refunds are not issued for server failure/issues, lack of features or if your server does not meet the Software Requirements. Refunds are determined on individual circumstances and only issued once our technical staff determine that EvolutionScript has a fault causing it to not run on your server. Installation charges are not refundable under any circumstances. Refunds are not available after 5 days from purchase date.</textarea></div>
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
		    	    <div>Welcome to the upgrade routine for EvolutionScript. This wizard will guide you through the upgrade process.</div>
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
			if (is_writable(REALPATH . "/includes/cache/")) {
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
				echo "<strong>/includes/cache/:</strong> <span class=\"disabled\">is not writable</span><br>";
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
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
    background: none repeat scroll 0 0 #FFFFFF;
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

error_reporting(0);
session_start();
define("REALPATH", dirname(dirname(__FILE__)));
define("EvolutionScript", 1);
define("INCLUDES", REALPATH . "/includes/");
define("GLOBALPATH", REALPATH . "/includes/");
include INCLUDES . "classes/class_core.php";
$input = new Input_Cleaner();
$software_version = "5.1";
define("terms", $input->r['terms']);
define("install_path", $input->r['install_path']);
define("url", $input->r['url']);
define("servername", $input->r['servername']);
define("dbname", $input->r['dbname']);
define("dbusername", $input->r['dbusername']);
define("dbpassword", $input->r['dbpassword']);
define("licensekey", "FULL DECODED & NULLED BY MTimer");
define("creating_table", $input->r['creating_table']);

if (creating_table == 1) {
  require_once INCLUDES . "config.php";
  $ptcevolution = new Registry();
  $db = new Database();
  $db->connect($ptcevolution->config['Database']['dbname'], $ptcevolution->config['Database']['servername'], $ptcevolution->config['Database']['username'], $ptcevolution->config['Database']['password']);
}

$sql[] = "CREATE TABLE `rent_discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `days` int(11) NOT NULL DEFAULT '0',
  `discount` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `mail_settings` (
  `field` varchar(200) NOT NULL,
  `value` varchar(200) DEFAULT NULL,
  UNIQUE KEY `field` (`field`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `email_template` (
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
$sql[] = "CREATE TABLE IF NOT EXISTS `payeer_orders` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `upgrade` int(2) NOT NULL default '0',
  `membership_id` int(11) default '0',
  `batch` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE `loginads_price` (
`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`days` INT(11) NOT NULL DEFAULT '0',
`price` DECIMAL(11, 2) NOT NULL DEFAULT '0'
) ENGINE = InnoDB;";
$sql[] = "CREATE TABLE `login_ads` (
`id` INT(11) NULL AUTO_INCREMENT PRIMARY KEY ,
`user_id` INT(11) NOT NULL DEFAULT '0',
`title` VARCHAR(30) NOT NULL ,
`image` VARCHAR(200) NOT NULL ,
`url` VARCHAR(200) NOT NULL ,
`expires` INT(11) NOT NULL DEFAULT '0',
`views` INT(11) NOT NULL DEFAULT '0',
`clicks` INT(11) NOT NULL DEFAULT '0',
`status` VARCHAR(50) NOT NULL DEFAULT 'Active'
) ENGINE = InnoDB;";
$sql[] = "CREATE TABLE IF NOT EXISTS `ptcevo_news` (
  `id` int(11) NOT NULL auto_increment,
  `date` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `important` int(2) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `addon` (
  `name` varchar(200) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `pin` varchar(200) DEFAULT NULL,
  `last_ip` varchar(200) DEFAULT NULL,
  `notes` mediumtext NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `login` int(11) NOT NULL DEFAULT '0',
  `last_login` int(11) NOT NULL DEFAULT '0',
  `status` enum('enable','disable') NOT NULL DEFAULT 'enable',
  `permissions` text,
  `signature` text,
  `protection` int(2) NOT NULL DEFAULT '0',
  `check_code` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `admin_advertisement` (
  `ad_title` varchar(200) default NULL,
  `ad_descr` varchar(200) default NULL,
  `ad_url` varchar(200) default NULL,
  `ad_time` int(11) NOT NULL default '0',
  `ad_expires` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `admin_loginlog` (
  `date` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `agent` varchar(255) NOT NULL,
  `fail` int(2) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `ads` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `token` varchar(200) NOT NULL,
  `title` varchar(100) NOT NULL,
  `descr` varchar(200) default NULL,
  `img` varchar(100) default NULL,
  `url` varchar(200) NOT NULL,
  `value` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `time` int(3) NOT NULL,
  `category` int(11) NOT NULL DEFAULT '0',
  `membership` mediumtext NOT NULL,
  `click_pack` int(11) NOT NULL,
  `clicks` int(11) NOT NULL,
  `clicks_today` int(11) NOT NULL default '0',
  `clicks_day` int(11) NOT NULL default '0',
  `outside_clicks` int(11) NOT NULL,
  `country` text NOT NULL,
  `status` varchar(100) NOT NULL default 'Inactive',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `ads_price` (
  `id` int(11) NOT NULL auto_increment,
  `credits` int(11) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `ad_value` (
  `id` int(11) NOT NULL auto_increment,
  `catname` varchar(200) default NULL,
  `value` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `credits` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `earn_ref` int(2) NOT NULL default '1',
  `hide_descr` int(2) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `banner_ads` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `title` varchar(200) NOT NULL,
  `img` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL,
  `credits` int(11) default '0',
  `views` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `status` varchar(50) NOT NULL default 'Active',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `banner_price` (
  `id` int(11) NOT NULL auto_increment,
  `credits` int(11) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `blacklist` (
  `id` int(11) NOT NULL auto_increment,
  `date` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `criteria` varchar(255) default NULL,
  `note` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `buyoptions` (
  `name` varchar(200) NOT NULL,
  `tblname` varchar(200) NOT NULL,
  `fieldassign` varchar(200) default NULL,
  `comtype` varchar(200) default NULL,
  `autoassign` varchar(10) default 'yes',
  `descr` varchar(200) default NULL,
  `hook_verify` varchar(10) default NULL,
  `enable` varchar(10) default 'yes'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `cheat_log` (
  `id` int(11) NOT NULL auto_increment,
  `date` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `log` mediumtext NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `country` (
  `name` varchar(200) NOT NULL,
  `users` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `cron_settings` (
  `field` varchar(100) NOT NULL,
  `value` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `deposit_history` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `method` int(11) NOT NULL,
  `fromacc` varchar(100) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `batch` varchar(200) default NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `fads_price` (
  `id` int(11) NOT NULL auto_increment,
  `credits` int(11) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(11) NOT NULL auto_increment,
  `forder` int(11) NOT NULL default '1',
  `question` varchar(200) NOT NULL,
  `answer` mediumtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `featured_ads` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `title` varchar(30) NOT NULL,
  `url` varchar(200) NOT NULL,
  `ad` varchar(50) NOT NULL,
  `credits` int(11) NOT NULL default '0',
  `views` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `status` varchar(50) NOT NULL default 'Active',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `featured_link` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `title` varchar(30) NOT NULL,
  `url` varchar(200) NOT NULL,
  `expires` int(11) NOT NULL default '0',
  `views` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `status` varchar(50) NOT NULL default 'Active',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `flinks_price` (
  `id` int(11) NOT NULL auto_increment,
  `month` int(11) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `forum_boards` (
  `id` int(11) NOT NULL auto_increment,
  `cat_id` int(11) NOT NULL default '0',
  `name` varchar(200) default NULL,
  `descr` varchar(200) default NULL,
  `topics` int(11) NOT NULL default '0',
  `posts` int(11) NOT NULL default '0',
  `position` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `forum_categories` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(200) default NULL,
  `position` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `forum_groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(200) NOT NULL,
  `canviewforum` varchar(5) NOT NULL default 'yes',
  `canviewtopic` varchar(5) NOT NULL default 'yes',
  `canposttopic` varchar(5) NOT NULL default 'yes',
  `caneditownpost` varchar(5) NOT NULL default 'yes',
  `caneditotherspost` varchar(5) NOT NULL default 'no',
  `candeleteownpost` varchar(5) NOT NULL default 'no',
  `candeleteotherspost` varchar(5) NOT NULL default 'no',
  `canopencloseowntopics` varchar(5) NOT NULL default 'no',
  `canopenclosetopics` varchar(5) NOT NULL default 'no',
  `canmoveowntopics` varchar(5) NOT NULL default 'no',
  `canmoveotherstopic` varchar(5) NOT NULL default 'no',
  `canbanmembers` varchar(5) default 'no',
  `cansuspendmember` varchar(5) default 'no',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `forum_log_boards` (
  `id_member` int(11) NOT NULL,
  `id_board` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `forum_posts` (
  `id` int(11) NOT NULL auto_increment,
  `bid` int(11) NOT NULL default '0',
  `topic_rel` int(11) NOT NULL default '0',
  `title` varchar(200) NOT NULL,
  `descr` varchar(200) default '............',
  `message` text NOT NULL,
  `date` int(11) NOT NULL,
  `date_updated` int(11) NOT NULL default '0',
  `edit_date` int(11) NOT NULL default '0',
  `author` varchar(200) NOT NULL,
  `topic` varchar(5) NOT NULL default 'no',
  `replies` int(11) NOT NULL default '0',
  `views` int(11) NOT NULL default '0',
  `sticky` int(1) NOT NULL default '0',
  `locked` int(1) NOT NULL default '0',
  `edited` int(1) NOT NULL default '0',
  `edited_author` varchar(200) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `gateways` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(200) NOT NULL,
  `account` varchar(200) NOT NULL,
  `allow_deposits` varchar(10) default 'yes',
  `allow_withdrawals` varchar(10) default 'yes',
  `allow_upgrade` varchar(10) default 'yes',
  `withdraw_fee` varchar(11) NOT NULL default '0',
  `withdraw_fee_fixed` decimal(11,3) NOT NULL default '0.000',
  `currency` varchar(10) NOT NULL default 'USD',
  `option1` varchar(200) default NULL,
  `option2` varchar(200) default NULL,
  `option3` varchar(200) default NULL,
  `option4` varchar(200) default NULL,
  `option5` varchar(200) default NULL,
  `min_deposit` decimal(11,2) NOT NULL default '0.00',
  `total_withdraw` decimal(11,2) NOT NULL default '0.00',
  `total_deposit` decimal(11,2) NOT NULL default '0.00',
  `status` varchar(100) NOT NULL default 'Active',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `helpdesk_department` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `helpdesk_replies` (
  `id` int(11) NOT NULL auto_increment,
  `ticket_id` int(11) NOT NULL,
  `user_reply` int(2) NOT NULL,
  `message` mediumtext NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `helpdesk_settings` (
  `field` varchar(200) NOT NULL,
  `value` varchar(200) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `helpdesk_ticket` (
  `id` int(11) NOT NULL auto_increment,
  `ticket` varchar(200) NOT NULL,
  `department` int(11) default NULL,
  `user_id` int(11) default NULL,
  `name` varchar(200) default NULL,
  `email` varchar(200) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` mediumtext NOT NULL,
  `status` int(11) NOT NULL default '1',
  `date` int(11) NOT NULL,
  `last_update` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `version` varchar(50) NOT NULL,
  `filename` varchar(50) NOT NULL,
  `default_lang` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `linktracker` (
  `id` int(11) NOT NULL auto_increment,
  `date` int(11) NOT NULL default '0',
  `name` varchar(200) NOT NULL,
  `descr` varchar(255) default NULL,
  `hits` int(11) NOT NULL default '0',
  `uniquehits` int(11) NOT NULL default '0',
  `signups` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `linktracker_log` (
  `id` int(11) NOT NULL auto_increment,
  `track_id` int(11) NOT NULL,
  `ip` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `localkey` (
  `id` int(1) NOT NULL default '1',
  `localkey` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `login_history` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL default 'Successful',
  `password` varchar(100) default NULL,
  `date` int(11) NOT NULL,
  `agent` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL auto_increment,
  `type` int(2) NOT NULL default '1',
  `fullname` varchar(200) default NULL,
  `comes_from` varchar(250) NOT NULL DEFAULT '-',
  `username` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `new_email` varchar(200) default NULL,
  `ref1` varchar(200) NOT NULL default '0',
  `referrals` int(11) NOT NULL,
  `rented_referrals` int(11) NOT NULL,
  `purchase_balance` decimal(11,2) NOT NULL default '0.00',
  `money` decimal(11,4) NOT NULL,
  `points` decimal(11,2) NOT NULL default '0.00',
  `withdraw` decimal(11,4) NOT NULL,
  `pending_withdraw` decimal(11,4) NOT NULL,
  `cashout_times` int(11) NOT NULL default '0',
  `ad_credits` int(11) NOT NULL default '0',
  `ptsu_credits` int(11) NOT NULL default '0',
  `banner_credits` int(11) NOT NULL,
  `fads_credits` int(11) NOT NULL,
  `flink_credits` int(11) NOT NULL,
  `adminad` int(1) NOT NULL default '0',
  `advisto` mediumtext,
  `clicks` int(11) NOT NULL,
  `for_refclicks` int(11) NOT NULL default '0',
  `for_refearned` decimal(11,4) NOT NULL default '0.0000',
  `for_reflastclick` int(11) NOT NULL default '0',
  `signup` int(11) NOT NULL,
  `country` varchar(100) default NULL,
  `autopay` varchar(5) NOT NULL default 'no',
  `last_rent` int(11) NOT NULL default '0',
  `last_cashout` int(11) NOT NULL default '0',
  `upgrade_ends` int(11) NOT NULL,
  `signup_ip` varchar(100) NOT NULL,
  `last_ip` varchar(100) NOT NULL default '-',
  `last_login` int(11) NOT NULL,
  `rented` int(11) NOT NULL default '0',
  `rented_time` int(11) NOT NULL default '0',
  `rented_expires` int(11) NOT NULL default '0',
  `rented_clicks` int(11) NOT NULL default '0',
  `rented_lastclick` int(11) NOT NULL default '0',
  `rented_earned` decimal(11,3) NOT NULL default '0.000',
  `rented_autopay` int(11) NOT NULL default '0',
  `status` varchar(100) NOT NULL default 'Un-verified',
  `myrefs1` int(11) NOT NULL,
  `refearnings` decimal(11,4) NOT NULL,
  `refclicks` int(11) NOT NULL,
  `mc1` int(11) NOT NULL default '0',
  `mc2` int(11) NOT NULL default '0',
  `mc3` int(11) NOT NULL default '0',
  `mc4` int(11) NOT NULL default '0',
  `mc5` int(11) NOT NULL default '0',
  `mc6` int(11) NOT NULL default '0',
  `mc7` int(11) NOT NULL default '0',
  `r1` int(11) NOT NULL default '0',
  `r2` int(11) NOT NULL default '0',
  `r3` int(11) NOT NULL default '0',
  `r4` int(11) NOT NULL default '0',
  `r5` int(11) NOT NULL default '0',
  `r6` int(11) NOT NULL default '0',
  `r7` int(11) NOT NULL default '0',
  `rr1` int(11) NOT NULL default '0',
  `rr2` int(11) NOT NULL default '0',
  `rr3` int(11) NOT NULL default '0',
  `rr4` int(11) NOT NULL default '0',
  `rr5` int(11) NOT NULL default '0',
  `rr6` int(11) NOT NULL default '0',
  `rr7` int(11) NOT NULL default '0',
  `ap1` decimal(11,4) NOT NULL default '0.0000',
  `ap2` decimal(11,4) NOT NULL default '0.0000',
  `ap3` decimal(11,4) NOT NULL default '0.0000',
  `ap4` decimal(11,4) NOT NULL default '0.0000',
  `ap5` decimal(11,4) NOT NULL default '0.0000',
  `ap6` decimal(11,4) NOT NULL default '0.0000',
  `ap7` decimal(11,4) NOT NULL default '0.0000',
  `acceptmails` varchar(10) NOT NULL default 'yes',
  `cookie_id` varchar(100) default NULL,
  `computer_stored` varchar(5) NOT NULL default 'no',
  `computer_id` varchar(100) default NULL,
  `verifycode` varchar(200) default NULL,
  `forum_posts` int(11) NOT NULL default '0',
  `forum_avatar` varchar(200) default NULL,
  `forum_status` varchar(100) NOT NULL default 'Active',
  `forum_role` int(2) NOT NULL default '3',
  `forum_stats` varchar(5) default 'no',
  `forum_signature` text,
  `personal_msg` varchar(5) NOT NULL default 'no',
  `adminnotes` mediumtext,
  `gateways` mediumtext,
  `ptsu_denied` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `membership` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(200) NOT NULL,
  `duration` int(11) NOT NULL default '30',
  `price` decimal(11,2) NOT NULL,
  `click` int(11) NOT NULL default '100',
  `ref_click` int(11) NOT NULL,
  `minimum_payout` varchar(100) NOT NULL,
  `ref_upgrade` decimal(11,2) NOT NULL,
  `ref_purchase` int(11) NOT NULL,
  `directref_limit` int(11) NOT NULL default '10',
  `rent_pack` varchar(100) NOT NULL default '0',
  `rentedref_limit` int(11) NOT NULL default '300',
  `recycle_cost` decimal(11,3) NOT NULL,
  `rent_time` int(11) NOT NULL default '0',
  `cashout_time` int(11) NOT NULL default '0',
  `referral_deletion` decimal(11,3) NOT NULL default '0.000',
  `active` varchar(4) default 'yes',
  `instant_withdrawal` varchar(4) default 'yes',
  `max_clicks` int(11) NOT NULL default '0',
  `rentprice` decimal(11,2) NOT NULL default '0.00',
  `cashoutamount` decimal(11,2) NOT NULL default '100.00',
  `max_withdraw` decimal(11,2) NOT NULL default '0.00',
  `rent250` varchar(11) NOT NULL default '0.32',
  `rent500` varchar(11) NOT NULL default '0.32',
  `rent750` varchar(11) NOT NULL default '0.32',
  `rent1000` varchar(11) NOT NULL default '0.32',
  `rent1250` varchar(11) NOT NULL default '0.32',
  `rent1500` varchar(11) NOT NULL default '0.32',
  `rent1750` varchar(11) NOT NULL default '0.32',
  `rentover` varchar(11) NOT NULL default '0.32',
  `autopay250` varchar(11) NOT NULL default '0.0067',
  `autopay500` varchar(11) NOT NULL default '0.0067',
  `autopay750` varchar(11) NOT NULL default '0.0067',
  `autopay1000` varchar(11) NOT NULL default '0.0067',
  `autopay1250` varchar(11) NOT NULL default '0.0067',
  `autopay1500` varchar(11) NOT NULL default '0.0067',
  `autopay1750` varchar(11) NOT NULL default '0.0067',
  `autopayover` varchar(11) NOT NULL default '0.0067',
  `point_enable` int(2) NOT NULL default '0',
  `point_ref` decimal(11,2) NOT NULL default '0.00',
  `point_ptc` decimal(11,2) NOT NULL default '0.00',
  `point_post` decimal(11,2) NOT NULL default '0.00',
  `point_ptsu` decimal(11,2) NOT NULL default '0.00',
  `point_deposit` decimal(11,2) NOT NULL default '0.00',
  `point_upgrade` int(2) NOT NULL default '0',
  `point_upgraderate` decimal(11,2) NOT NULL default '20.00',
  `point_purchasebalance` int(2) NOT NULL default '0',
  `point_cashrate` decimal(11,2) NOT NULL default '10.00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL auto_increment,
  `user_from` int(11) NOT NULL,
  `user_to` int(11) NOT NULL,
  `subject` mediumtext NOT NULL,
  `message` text NOT NULL,
  `date` int(11) NOT NULL,
  `user_read` varchar(5) NOT NULL default 'no',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(200) NOT NULL,
  `message` mediumtext NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `order_history` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL,
  `item_id` int(11) NOT NULL,
  `price` decimal(11,2) default NULL,
  `date` int(11) NOT NULL,
  `status` varchar(100) NOT NULL default 'Pending',
  `ref` int(11) NOT NULL,
  `ref_comission` decimal(11,2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `ptsu_offers` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `descr` varchar(200) NOT NULL,
  `instructions` mediumtext NOT NULL,
  `url` varchar(100) NOT NULL,
  `value` decimal(11,2) NOT NULL,
  `credits` int(11) NOT NULL default '0',
  `approved` int(11) NOT NULL default '0',
  `pending` int(11) NOT NULL default '0',
  `claims` int(11) NOT NULL default '0',
  `country` text,
  `status` varchar(100) NOT NULL default 'Inactive',
  `membership` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `ptsu_price` (
  `id` int(11) NOT NULL auto_increment,
  `credits` int(11) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `ptsu_requests` (
  `id` int(11) NOT NULL auto_increment,
  `ptsu_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL,
  `username` varchar(100) default NULL,
  `message` mediumtext,
  `title` varchar(200) NOT NULL,
  `value` decimal(11,2) NOT NULL,
  `url` varchar(200) NOT NULL,
  `date` int(11) NOT NULL,
  `status` varchar(50) NOT NULL default 'Pending',
  `advertiser_notes` mediumtext,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `ptsu_value` (
  `id` int(11) NOT NULL auto_increment,
  `value` decimal(11,2) NOT NULL,
  `credits` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `referral_price` (
  `id` int(11) NOT NULL auto_increment,
  `refs` int(11) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `settings` (
  `field` varchar(100) NOT NULL,
  `value` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `site_banners` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(200) NOT NULL,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `site_content` (
  `name` varchar(100) NOT NULL,
  `content` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `specialpacks` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(200) NOT NULL,
  `date` int(11) NOT NULL,
  `buys` int(11) NOT NULL default '0',
  `price` decimal(11,2) NOT NULL default '0.00',
  `enable` varchar(5) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `specialpacks_list` (
  `id` int(11) NOT NULL auto_increment,
  `specialpack` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL,
  `amount` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `statistics` (
  `field` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `version` varchar(50) NOT NULL,
  `folder` varchar(100) NOT NULL,
  `default_tpl` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `topdomains` (
  `id` int(11) NOT NULL auto_increment,
  `domain` varchar(200) NOT NULL,
  `hits` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `users_online` (
  `ip` varchar(200) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `withdraw_history` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` varchar(200) NOT NULL,
  `method` int(11) NOT NULL,
  `account` varchar(200) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `fee` double NOT NULL DEFAULT '0',
  `date` varchar(11) NOT NULL,
  `status` varchar(100) NOT NULL default 'Pending',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `ip_ptc` (
  `ip` varchar(200) DEFAULT NULL,
  `ad_id` int(11) NOT NULL DEFAULT '0',
  KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$sql[] = "CREATE TABLE IF NOT EXISTS `blockchain_requests` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `amount` decimal(11,2) NOT NULL default '0.00',
  `btc_amount` varchar(50) NOT NULL default '0',
  `type` int(1) NOT NULL default '1',
  `membership` int(2) NOT NULL default '0',
  `code` varchar(100) NOT NULL,
  `bc_address` varchar(150) default NULL,
  `status` int(1) NOT NULL default '0',
  `date` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
$datasql[] = "INSERT INTO `admin` (`id`, `username`, `password`, `pin`, `last_ip`, `notes`, `email`, `login`, `last_login`, `status`, `permissions`, `signature`, `protection`, `check_code`) VALUES(1, 'admin', '4c7a34d25eff9121c49658dbceadf694', 'e10adc3949ba59abbe56e057f20f883e', '127.0.0.1', '', 'myemail@mydomain.com', 0, 0, 'enable', 'a:27:{s:10:\"statistics\";s:1:\"1\";s:14:\"manage_members\";s:1:\"1\";s:14:\"add_new_member\";s:1:\"1\";s:9:\"send_mail\";s:1:\"1\";s:13:\"send_messages\";s:1:\"1\";s:6:\"ptcads\";s:1:\"1\";s:14:\"ptcads_manager\";s:1:\"1\";s:11:\"featuredads\";s:1:\"1\";s:19:\"featuredads_manager\";s:1:\"1\";s:13:\"featuredlinks\";s:1:\"1\";s:21:\"featuredlinks_manager\";s:1:\"1\";s:9:\"bannerads\";s:1:\"1\";s:17:\"bannerads_manager\";s:1:\"1\";s:8:\"loginads\";s:1:\"1\";s:16:\"loginads_manager\";s:1:\"1\";s:10:\"ptsuoffers\";s:1:\"1\";s:18:\"ptsuoffers_manager\";s:1:\"1\";s:12:\"specialpacks\";s:1:\"1\";s:6:\"orders\";s:1:\"1\";s:8:\"deposits\";s:1:\"1\";s:11:\"withdrawals\";s:1:\"1\";s:7:\"support\";s:1:\"1\";s:15:\"support_manager\";s:1:\"1\";s:12:\"site_content\";s:1:\"1\";s:9:\"utilities\";s:1:\"1\";s:5:\"setup\";s:1:\"1\";s:14:\"administrators\";s:1:\"1\";}', '', 0, '');";
$datasql[] = "INSERT INTO `admin_advertisement` (`ad_title`, `ad_descr`, `ad_url`, `ad_time`, `ad_expires`) VALUES('Admin advertisement', 'Visit this site', 'http://www.evolutionscript.com', 5, 1388552399);";
$datasql[] = "INSERT INTO `ads_price` (`id`, `credits`, `price`) VALUES(2, 1000, 2.40);";
$datasql[] = "INSERT INTO `ad_value` (`id`, `catname`, `value`, `credits`, `time`, `earn_ref`, `hide_descr`) VALUES(1, 'Micro Ads', 0.005, 5, 15, 0, 1);";
$datasql[] = "INSERT INTO `ad_value` (`id`, `catname`, `value`, `credits`, `time`, `earn_ref`, `hide_descr`) VALUES(2, 'Standard Ads', 0.010, 10, 30, 1, 0);";
$datasql[] = "INSERT INTO `ad_value` (`id`, `catname`, `value`, `credits`, `time`, `earn_ref`, `hide_descr`) VALUES(4, 'Extended Ads', 0.020, 20, 60, 1, 0);";
$datasql[] = "INSERT INTO `ad_value` (`id`, `catname`, `value`, `credits`, `time`, `earn_ref`, `hide_descr`) VALUES(3, 'Macro Ads', 0.015, 15, 45, 1, 0);";
$datasql[] = "INSERT INTO `banner_price` (`id`, `credits`, `price`) VALUES(1, 25000, 2.00);";
$datasql[] = "INSERT INTO `buyoptions` (`name`, `tblname`, `fieldassign`, `comtype`, `autoassign`, `descr`, `hook_verify`, `enable`) VALUES('ptc_credits', 'ads_price', 'credits', 'purchase', '', '%descr PTC Credits', NULL, 'yes');";
$datasql[] = "INSERT INTO `buyoptions` (`name`, `tblname`, `fieldassign`, `comtype`, `autoassign`, `descr`, `hook_verify`, `enable`) VALUES('ptsu_credits', 'ptsu_price', 'credits', 'purchase', '', '%descr PTSU Credits', NULL, 'yes');";
$datasql[] = "INSERT INTO `buyoptions` (`name`, `tblname`, `fieldassign`, `comtype`, `autoassign`, `descr`, `hook_verify`, `enable`) VALUES('fad_credits', 'fads_price', 'credits', 'purchase', '', '%descr Featured Ads Credits', NULL, 'yes');";
$datasql[] = "INSERT INTO `buyoptions` (`name`, `tblname`, `fieldassign`, `comtype`, `autoassign`, `descr`, `hook_verify`, `enable`) VALUES('bannerad_credits', 'banner_price', 'credits', 'purchase', '', '%descr Banner Ad Credits', NULL, 'yes');";
$datasql[] = "INSERT INTO `buyoptions` (`name`, `tblname`, `fieldassign`, `comtype`, `autoassign`, `descr`, `hook_verify`, `enable`) VALUES('flink_credits', 'flinks_price', 'month', 'purchase', '', '%descr Featured Link Month(s)', NULL, 'yes');";
$datasql[] = "INSERT INTO `buyoptions` (`name`, `tblname`, `fieldassign`, `comtype`, `autoassign`, `descr`, `hook_verify`, `enable`) VALUES('specialpack', 'specialpacks', 'name', NULL, 'yes', 'Special pack: %descr', NULL, 'yes');";
$datasql[] = "INSERT INTO `buyoptions` (`name`, `tblname`, `fieldassign`, `comtype`, `autoassign`, `descr`, `hook_verify`, `enable`) VALUES('membership', 'membership', 'name', 'upgrade', 'yes', '%descr Membership', NULL, 'yes');";
$datasql[] = "INSERT INTO `buyoptions` (`name`, `tblname`, `fieldassign`, `comtype`, `autoassign`, `descr`, `hook_verify`, `enable`) VALUES('referrals', 'referral_price', 'refs', NULL, '', '%descr Referral(s)', NULL, 'yes');";
$datasql[] = "INSERT INTO `buyoptions` (`name`, `tblname`, `fieldassign`, `comtype`, `autoassign`, `descr`, `hook_verify`, `enable`) VALUES('rent_referrals', '', '', NULL, 'yes', '%descr Rented Referral(s)', 'yes', 'yes');";
$datasql[] = "INSERT INTO `buyoptions` (`name`, `tblname`, `fieldassign`, `comtype`, `autoassign`, `descr`, `hook_verify`, `enable`) VALUES('purchase_balance', '', NULL, NULL, 'yes', 'Internal transfer to purchase balance: $%descr', 'yes', 'yes');";
$datasql[] = "INSERT INTO `buyoptions` (`name`, `tblname`, `fieldassign`, `comtype`, `autoassign`, `descr`, `hook_verify`, `enable`) VALUES('membership_points', 'membership', 'name', '', 'yes', '%descr Membership', 'yes', 'yes');";
$datasql[] = "INSERT INTO `country` (`name`, `users`) VALUES('', 0);";
$datasql[] = "INSERT INTO `cron_settings` (`field`, `value`) VALUES('reset_ptc', 'yes');";
$datasql[] = "INSERT INTO `cron_settings` (`field`, `value`) VALUES('delete_inactive', '');";
$datasql[] = "INSERT INTO `cron_settings` (`field`, `value`) VALUES('suspend_inactive', '');";
$datasql[] = "INSERT INTO `cron_settings` (`field`, `value`) VALUES('delete_ptc', 'yes');";
$datasql[] = "INSERT INTO `cron_settings` (`field`, `value`) VALUES('delete_fads', 'yes');";
$datasql[] = "INSERT INTO `cron_settings` (`field`, `value`) VALUES('delete_flinks', 'yes');";
$datasql[] = "INSERT INTO `cron_settings` (`field`, `value`) VALUES('delete_bannerads', 'yes');";
$datasql[] = "INSERT INTO `cron_settings` (`field`, `value`) VALUES('last_cron', '0000-00-00');";
$datasql[] = "INSERT INTO `fads_price` (`id`, `credits`, `price`) VALUES(1, 150000, 1.00);";
$datasql[] = "INSERT INTO `flinks_price` (`id`, `month`, `price`) VALUES(1, 1, 10.00);";
$datasql[] = "INSERT INTO `forum_groups` (`id`, `name`, `canviewforum`, `canviewtopic`, `canposttopic`, `caneditownpost`, `caneditotherspost`, `candeleteownpost`, `candeleteotherspost`, `canopencloseowntopics`, `canopenclosetopics`, `canmoveowntopics`, `canmoveotherstopic`, `canbanmembers`, `cansuspendmember`) VALUES(1, 'Admin', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes');";
$datasql[] = "INSERT INTO `forum_groups` (`id`, `name`, `canviewforum`, `canviewtopic`, `canposttopic`, `caneditownpost`, `caneditotherspost`, `candeleteownpost`, `candeleteotherspost`, `canopencloseowntopics`, `canopenclosetopics`, `canmoveowntopics`, `canmoveotherstopic`, `canbanmembers`, `cansuspendmember`) VALUES(2, 'Moderator', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no');";
$datasql[] = "INSERT INTO `forum_groups` (`id`, `name`, `canviewforum`, `canviewtopic`, `canposttopic`, `caneditownpost`, `caneditotherspost`, `candeleteownpost`, `candeleteotherspost`, `canopencloseowntopics`, `canopenclosetopics`, `canmoveowntopics`, `canmoveotherstopic`, `canbanmembers`, `cansuspendmember`) VALUES(3, 'Normal Members', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no');";
$datasql[] = "INSERT INTO `forum_groups` (`id`, `name`, `canviewforum`, `canviewtopic`, `canposttopic`, `caneditownpost`, `caneditotherspost`, `candeleteownpost`, `candeleteotherspost`, `canopencloseowntopics`, `canopenclosetopics`, `canmoveowntopics`, `canmoveotherstopic`, `canbanmembers`, `cansuspendmember`) VALUES(4, 'Banned', 'yes', 'yes', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no');";
$datasql[] = "INSERT INTO `forum_groups` (`id`, `name`, `canviewforum`, `canviewtopic`, `canposttopic`, `caneditownpost`, `caneditotherspost`, `candeleteownpost`, `candeleteotherspost`, `canopencloseowntopics`, `canopenclosetopics`, `canmoveowntopics`, `canmoveotherstopic`, `canbanmembers`, `cansuspendmember`) VALUES(5, 'Guests', 'yes', 'yes', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no');";
$datasql[] = "INSERT INTO `gateways` (`id`, `name`, `account`, `allow_deposits`, `allow_withdrawals`, `allow_upgrade`, `withdraw_fee`, `withdraw_fee_fixed`, `currency`, `option1`, `option2`, `option3`, `option4`, `option5`, `min_deposit`, `total_withdraw`, `total_deposit`, `status`) VALUES(1, 'Payza', 'mypayza@yoursite.com', 'yes', 'yes', 'yes', '0', 0.000, 'USD', 'AP''s Security Code', 'AP''s Api Password', 'myap@yoursite.com', '', 'Payment From %sitename% to member %username%', 5.00, 0.00, 0.00, 'Active');";
$datasql[] = "INSERT INTO `gateways` (`id`, `name`, `account`, `allow_deposits`, `allow_withdrawals`, `allow_upgrade`, `withdraw_fee`, `withdraw_fee_fixed`, `currency`, `option1`, `option2`, `option3`, `option4`, `option5`, `min_deposit`, `total_withdraw`, `total_deposit`, `status`) VALUES(2, 'PayPal', 'mypaypal@yoursite.com', 'yes', 'yes', 'yes', '0.5', 0.100, 'USD', 'PP''s APi Username', 'PP''s APi Pswd', 'PP''s APi Signature', '', 'Payment From %sitename% to member %username%', 2.00, 0.00, 0.00, 'Active');";
$datasql[] = "INSERT INTO `gateways` (`id`, `name`, `account`, `allow_deposits`, `allow_withdrawals`, `allow_upgrade`, `withdraw_fee`, `withdraw_fee_fixed`, `currency`, `option1`, `option2`, `option3`, `option4`, `option5`, `min_deposit`, `total_withdraw`, `total_deposit`, `status`) VALUES(4, 'Perfect Money', 'U123456', 'yes', 'yes', 'yes', '1', 0.015, 'USD', 'My PM Ac', 'PM''s Alt. Pass.', '123456', 'PMPasswd', 'Payment From %sitename% to member %username%', 1.00, 0.00, 0.00, 'Active');";
$datasql[] = "INSERT INTO `gateways` (`id`, `name`, `account`, `allow_deposits`, `allow_withdrawals`, `allow_upgrade`, `withdraw_fee`, `withdraw_fee_fixed`, `currency`, `option1`, `option2`, `option3`, `option4`, `option5`, `min_deposit`, `total_withdraw`, `total_deposit`, `status`) VALUES(5, 'Egopay', 'ABCDEFGHI', 'yes', 'yes', 'yes', '0', 0.000, 'USD', 'abcdefghi123456', 'api_name', 'api_id', 'api_pass', 'Payment From %sitename% to member %username%', 1.00, 0.00, 0.00, 'Active');";
$datasql[] = "INSERT INTO `gateways` (`id`, `name`, `account`, `allow_deposits`, `allow_withdrawals`, `allow_upgrade`, `withdraw_fee`, `withdraw_fee_fixed`, `currency`, `option1`, `option2`, `option3`, `option4`, `option5`, `min_deposit`, `total_withdraw`, `total_deposit`, `status`) VALUES(6, 'SolidTrustPay', 'STPUsername', 'yes', 'yes', 'yes', '0', 0.000, 'USD', 'SecPassword', 'API_ID', 'API_PASSWORD', '', 'Payment From %sitename% to member %username%', 1.00, 0.00, 0.00, 'Active');";
$datasql[] = "INSERT INTO `helpdesk_department` (`id`, `name`) VALUES(1, 'General Support');";
$datasql[] = "INSERT INTO `helpdesk_department` (`id`, `name`) VALUES(2, 'Payments Support');";
$datasql[] = "INSERT INTO `helpdesk_department` (`id`, `name`) VALUES(3, 'Advertising Support');";
$datasql[] = "INSERT INTO `helpdesk_settings` (`field`, `value`) VALUES('helpdesk_enable', 'yes');";
$datasql[] = "INSERT INTO `helpdesk_settings` (`field`, `value`) VALUES('members_only', '');";
$datasql[] = "INSERT INTO `language` (`id`, `name`, `version`, `filename`, `default_lang`) VALUES(1, 'English (US)', '" . $software_version . "', 'english.php', 1);";
$datasql[] = "INSERT INTO `localkey` (`id`, `localkey`) VALUES(1, '');";
$datasql[] = "INSERT INTO `membership` (`id`, `name`, `duration`, `price`, `click`, `ref_click`, `minimum_payout`, `ref_upgrade`, `ref_purchase`, `directref_limit`, `rent_pack`, `rentedref_limit`, `recycle_cost`, `rent_time`, `cashout_time`, `referral_deletion`, `active`, `instant_withdrawal`, `max_clicks`, `rentprice`, `cashoutamount`, `max_withdraw`, `rent250`, `rent500`, `rent750`, `rent1000`, `rent1250`, `rent1500`, `rent1750`, `rentover`, `autopay250`, `autopay500`, `autopay750`, `autopay1000`, `autopay1250`, `autopay1500`, `autopay1750`, `autopayover`, `point_enable`, `point_ref`, `point_ptc`, `point_post`, `point_ptsu`, `point_deposit`, `point_upgrade`, `point_upgraderate`, `point_purchasebalance`, `point_cashrate`) VALUES(1, 'Standard', 30, 0.00, 50, 20, '2,4,6,8,10', 0.00, 0, 20, '5,10,20,50,75,100', 100, 0.080, 0, 7, 0.100, 'yes', '', 100, 0.50, 10.00, 0.00, '0.32', '0.32', '0.32', '0.32', '0.32', '0.32', '0.32', '0.32', '0.0067', '0.0067', '0.0067', '0.0067', '0.0067', '0.0067', '0.0067', '0.0067', 1, 0.01, 0.02, 0.04, 0.05, 0.07, 1, 1.00, 0, 0.01);";
$datasql[] = "INSERT INTO `referral_price` (`id`, `refs`, `price`) VALUES(1, 1, 1.00);";
$datasql[] = "INSERT INTO `site_content` (`name`, `content`) VALUES('terms', '<h2 align=\"center\"><u>Terms of Service</u></h2>My terms of service');";
$datasql[] = "INSERT INTO `statistics` (`field`, `value`) VALUES('deposit', '0.00');";
$datasql[] = "INSERT INTO `statistics` (`field`, `value`) VALUES('cashout', '0.00');";
$datasql[] = "INSERT INTO `statistics` (`field`, `value`) VALUES('last_check', '0');";
$datasql[] = "INSERT INTO `templates` (`id`, `name`, `version`, `folder`, `default_tpl`) VALUES(1, 'Modern Blue', '" . $software_version . "', 'ModernBlue', 1);";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('ssl_host', '');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('site_name', 'EvolutionScript');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('site_title', 'EvolutionScript " . $software_version . "');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('show_fads', '4');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('show_flinks', '4');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('show_news', '5');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('email_support', 'support@yourdomain.com');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('captcha_contact', '');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('captcha_login', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('captcha_register', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('register_activation', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('site_url', '" . url . "');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('instant_payment', '');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('emailchange_activation', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('max_result_page', '50');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('inactive_days', '30');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('maintenance', '');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('maintenance_msg', 'We are currently performing maintenance and will be back shortly.');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('site_stats', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('captcha_type', '1');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('recaptcha_publickey', '');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('recaptcha_privatekey', '');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('buy_referrals', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('amount_transfer', '0.10');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('withdraw_clicks', '0');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('recaptcha_theme', 'clean');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('ptc_approval', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('rent_referrals', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('todayclick', '6');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('click_yesterday', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('clicks_necessary', '4');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('multi_registration', '');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('multi_login', '');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('multi_country', '');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('payment_proof', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('ref_deletion', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('money_transfer', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('googleanalytics', '');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('googleanalyticsid', '');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('allowchangelanguage', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('allowchangetemplate', 'no');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('rentype', '2');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('message_system', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('message_per_page', '5');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('topdomains', '');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('flinks_available', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('fads_approval', '');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('ptsu_available', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('bannerads_available', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('special_available', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('bannerads_approval', '');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('fads_available', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('flinks_approval', '');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('ptsu_approval', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('forum_search', '1');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('forum_signature', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('quick_news', '2');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('forum_active', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('upgrade_purchasebalance', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('forum_signature_maxchar', '500');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('ptsu_exclusion', '1');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('demo', '');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('ptcevonews_nextcheck', '0');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('ptcevonews_lastid', '0');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('buyref_filter', 'disable');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('buyref_clicks', '0');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('buyref_days', '7');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('rentref_filter', 'disable');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('rentref_clicks', '0');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('rentref_days', '7');";
$datasql[] = "ALTER TABLE `admin` ADD `signature` TEXT NULL ;";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`) VALUES ('cancel_pendingwithdraw', 'no');";
$datasql[] = "INSERT INTO `rent_discount` (`id`, `days`, `discount`) VALUES(1, 30, 0);";
$datasql[] = "INSERT INTO settings(field,value) VALUES('loginads_available', 'no');";
$datasql[] = "INSERT INTO settings(field,value) VALUES('loginads_approval', 'no');";
$datasql[] = "INSERT INTO settings(field,value) VALUES('loginads_max', '2');";
$datasql[] = "INSERT INTO `buyoptions` (`name`, `tblname`, `fieldassign`, `comtype`, `autoassign`, `descr`, `hook_verify`, `enable`) VALUES ('loginads_credits', 'loginads_price', 'days', 'purchase', 'yes', '%descr Login Ads Day(s)', NULL, 'yes');";
$datasql[] = "INSERT INTO `loginads_price` (`days` ,`price`)VALUES ('30', '10.00');";
$datasql[] = "ALTER TABLE `members` ADD `loginads_credits` INT(11) NOT NULL DEFAULT '0' AFTER `ad_credits` ;";
$datasql[] = "ALTER TABLE `members` ADD `loginads_view` INT(11) NOT NULL DEFAULT '0' AFTER `advisto`;";
$datasql[] = "ALTER TABLE `news` ADD `loginads` INT(2) NOT NULL DEFAULT '0';";
$datasql[] = "INSERT INTO `cron_settings` (`field` ,`value`)VALUES ('delete_loginads', 'yes');";
$datasql[] = "INSERT INTO settings(field,value) VALUES('ptsu_autoapprovedays', '30');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES ('fail_payments', 'yes');";
$datasql[] = "INSERT INTO `statistics` (`field` ,`value`)VALUES ('members', '0');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('usersonline', '0');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('copyright', '0');";
$datasql[] = "UPDATE buyoptions SET hook_verify='yes' WHERE name = 'referrals'";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('timezone', '');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('solvemedia_ckey', '');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('solvemedia_vkey', '');";
$datasql[] = "INSERT INTO `settings` (`field`, `value`) VALUES('solvemedia_hkey', '');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('ptc_chars_title', '100');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('ptc_chars_descr', '100');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('loginad_chars_title', '30');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('bannerad_chars_title', '200');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('featuredad_chars_title', '30');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('featuredad_chars_descr', '50');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('featuredlink_chars_title', '30');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('ptsu_chars_title', '100');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('ptsu_chars_descr', '200');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('withdraw_sameprocessor', 'yes');";
$datasql[] = "INSERT INTO `statistics` (`field` ,`value`)VALUES ('members_today', '0');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('unique_ip', 'no');";
$datasql[] = "INSERT INTO `mail_settings` (`field`, `value`) VALUES('email_from_address', 'noreply@evolutionscript.com'),('email_from_name', 'EvolutionScript Staff'),('email_type', 'php'),('smtp_host', ''),('smtp_password', ''),('smtp_port', '25'),('smtp_ssl', ''),('smtp_username', '');";
$datasql[] = "INSERT INTO `email_template` (`oid`, `id`, `type`, `name`, `subject`, `message_plain`, `message_html`) VALUES
(1, 'registration_activation', 'plain', 'Registration Activation Notification', 'Action Required to Activate Membership for %site_name%', 'Dear %fullname%,



Thank you for registering at the %site_name%. Before we can activate your account one last step must be taken to complete your registration.

Please note:

you must complete this last step to become a registered member. You will only need to visit this URL once to activate your account.

To complete your

registration, please visit this URL:

%activation_url_code%

**** Does The Above URL Not Work? ****

If the above URL does not work, please use your Web

browser to go to:

%activation_url%

Your Username is: %username%
Your Activation ID is: %activation_code%

If you are still having problems signing up

please contact a member of our support staff.

All the best,
%site_name% Team.', '<p>Dear %fullname%,<br /><br />Thank you for registering at the %site_name%.

Before we can activate your account one last step must be taken to complete your registration.<br /><br />Please note: you must complete this last step to become

a registered member. You will only need to visit this URL once to activate your account.<br /><br />To complete your registration, please visit this URL:<br

/><br />%activation_url_code%<br /><br />**** Does The Above URL Not Work? ****<br /><br />If the above URL does not work, please use your Web browser to go

to:<br /><br />%activation_url%<br /><br />Your Username is: %username%<br />Your Activation ID is: %activation_code%<br /><br />If you are still having problems

signing up please contact a member of our support staff.<br /><br />All the best,<br />%site_name% Team.</p>'),
(2, 'registration_complete', 'plain', 'Registration Completion Notification', 'Welcome to %site_name%!', 'Dear %fullname%,

Thanks for registering at

%site_name%! We are glad you have chosen to be a part of our community and we hope you enjoy your stay.

All the best,
%site_name% Team.', '<p>Dear %fullname

%,</p>
<p>Thanks for registering at %site_name%!</p>
<p>We are glad you have chosen to be a part of our community and we hope you enjoy your stay.</p>



<p>&nbsp;</p>
<p>All the best, <br />%site_name% Team.</p>'),
(3, 'forgot_password', 'plain', 'Password Reset Notification', 'New Password Required for %site_name%', 'Dear %fullname%

Your request for a new password was

sucessfully processed.

New password: %newpassword%

All the best,
%site_name% Team.', '<p>Dear %fullname%<br /><br />Your request for a new password was

sucessfully processed.<br /><br />New password: %newpassword%<br /><br />All the best,<br />%site_name% Team.</p>'),
(4, 'newmail_verification', 'plain', 'New Email Verification', 'Action Required to Change Email for %site_name%', 'Dear %fullname%

You have been update your

%site_name% account, but before we can change your email one last step must be taken to complete this operation.

Go to your personal settings and enter the

next activation id.

Your Activation ID is: %activation_code%

All the best,
%site_name% Team.', '<p>Dear %fullname%<br /><br />You have been update your

%site_name% account, but before we can change your email one last step must be taken to complete this operation.<br /><br />Go to your personal settings and

enter the next activation id.<br /><br />Your Activation ID is: %activation_code%<br /><br />All the best,<br />%site_name% Team.</p>'),
(5, 'support_ticket_creation', 'plain', 'Support Ticket Creation', '[%ticket_id%] Support Request', '*************************************
%site_name% Support


*************************************

You have submitted a support ticket to %site_name%

Your ticket number is %ticket_id%

You will receive a response

within 48 hours.

Best regards,
%site_name% Team.', '<p>*************************************<br />%site_name% Support<br

/>*************************************<br /><br />You have submitted a support ticket to %site_name%<br /><br />Your ticket number is %ticket_id%<br /><br />You

will receive a response within 48 hours.<br /><br />Best regards,<br />%site_name% Team.</p>'),
(6, 'support_ticket_answer', 'plain', 'Support Ticket Answer', '[%ticket_id%] Ticket Reply', '*************************************
%site_name% Support


*************************************

Your support ticket submitted to %site_name% was replied by our staff.

Your ticket number is %ticket_id%

Best

regards,
%site_name% team.', '<p>*************************************<br />%site_name% Support<br />*************************************<br /><br />Your

support ticket submitted to %site_name% was replied by our staff.<br /><br />Your ticket number is %ticket_id%<br /><br />Best regards,<br />%site_name%

team.</p>');";
$datasql[] = "ALTER TABLE `settings` ADD PRIMARY KEY(`field`);";
$datasql[] = "ALTER TABLE `members` ADD `last_cron` DATE NULL DEFAULT NULL ;";
$datasql[] = "ALTER TABLE `site_content` CHANGE `name` `id` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ;";
$datasql[] = "ALTER TABLE `site_content` ADD INDEX (`id`) ;";
$datasql[] = "ALTER TABLE `cron_settings` ADD PRIMARY KEY(`field`);";
$datasql[] = "ALTER TABLE `statistics` ADD PRIMARY KEY(`field`);";
$datasql[] = "ALTER TABLE `members` ADD INDEX (`username`) ;";
$datasql[] = "ALTER TABLE `members` ADD INDEX (`rented`) ;";
$datasql[] = "ALTER TABLE `members` ADD `chart_num` INT(11) NOT NULL DEFAULT '0';";
$datasql[] = "INSERT INTO `gateways` (`id`, `name`, `account`, `allow_deposits`, `allow_withdrawals`, `allow_upgrade`, `withdraw_fee`, `withdraw_fee_fixed`, `currency`, `option1`, `option2`, `option3`, `option4`, `option5`, `min_deposit`, `total_withdraw`, `total_deposit`, `status`) VALUES(7, 'Payeer', '123456', 'yes', 'yes', 'yes', '0', 0.000, 'USD', 'Shop Key', 'P123456', '123456', 'API Key', 'Payment From %sitename% to member %username%', 0.00, 0.00, 0.00, 'Active');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('force_viewads', '1');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('autoloadad_secs', '7');";
$datasql[] = "ALTER TABLE `gateways` ADD `option6` VARCHAR(255) NULL DEFAULT NULL AFTER `option5` ;";
$datasql[] = "ALTER TABLE `addon` ADD PRIMARY KEY (`name`) ;";
$datasql[] = "ALTER TABLE `addon` ENGINE = InnoDB;";
$datasql[] = "ALTER TABLE `membership` ENGINE = InnoDB;";
$datasql[] = "INSERT INTO `gateways` (`id`, `name`, `account`, `allow_deposits`, `allow_withdrawals`, `allow_upgrade`, `withdraw_fee`, `withdraw_fee_fixed`, `currency`, `option1`, `option2`, `option3`, `option4`, `option5`, `option6`, `min_deposit`, `total_withdraw`, `total_deposit`, `status`) VALUES
(8, 'Bitcoin', '', 'yes', 'yes', 'yes', '0', '0.000', 'USD', '6', '', '', '', '', '', '0.00', '0.00', '0.00', 'Inactive');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('signup_bonus', 'yes');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('balance_bonus', '0.00');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('purchase_bonus', '0.00');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('membership_bonus', '');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('membershipdays_bonus', '0');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('bonus_start', '0');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('bonus_ends', '0');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('bonus_date', '');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('bonus_totalmembers', '');";
$datasql[] = "INSERT INTO `settings` (`field` ,`value`)VALUES ('bonus_date_ends', '');";

if ($input->g['do'] == "finish" && $_SESSION['installation_done']) {
  require_once INCLUDES . "config.php";
  $ptcevolution = new Registry();
  $db = new Database();
  $db->connect($ptcevolution->config['Database']['dbname'], $ptcevolution->config['Database']['servername'], $ptcevolution->config['Database']['username'], $ptcevolution->config['Database']['password']);
  $query = $db->query("SELECT * FROM settings");

  while ($result = $db->fetch_array($query)) {
    $settings[$result['field']] = $result['value'];
  }

  show_header();
  echo "<h2>Installation complete</h2>";
  echo "<div style=\"padding-bottom:5px\">Congratulations! Your EvolutionScript installation is now complete!</div>";
  echo "<div style=\"padding-bottom:5px\">Bellow you will find the administration details:</div>";
  echo "<table width=100%>
    <tr>
      <td width=150><strong>Admin panel:</strong></td>
      <td><a href=\"" . $settings['site_url'] . "admin/\" target=\"_blank\" style=\"color:blue\">" . $settings['site_url'] . "admin/</a></td>
    </tr>
    <tr>
      <td width=150><strong>Admin username:</strong></td>
      <td style=\"color:green; font-weight:bold;\">admin</td>
    </tr>
    <tr>
      <td width=150><strong>Admin password:</strong></td>
      <td style=\"color:green; font-weight:bold;\">demopass</td>
    </tr>
    <tr>
      <td width=150><strong>Admin pin code:</strong></td>
      <td style=\"color:green; font-weight:bold;\">123456</td>
    </tr>
  </table>";
  show_footer();
  exit();
}

switch ($input->r['step']) {
  case "6":
    if (creating_table == 1 && $_SESSION['support_ok']) {
      $_SESSION['installation_done'] = 1;
      show_header();
      echo "<h2>Inserting data</h2>";
      foreach ($datasql as $query) {
        $db->query($query);
        echo " . ";
        flush();
        ob_flush();
      }

      $sql_statements = file_get_contents("ip2nation.sql");
      $arr_sql = preg_split('/;[\n\r]+/', $sql_statements);
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
    }
    break;

  case "5":
    if ((((((install_path && url) && servername) && dbname) && dbusername) && terms) && licensekey) {
      $chkadmin = new VData();
      $chkadmin->details(licensekey);
      $chkadmin->getinfo();
      $chkadmin->validate(licensekey);

      if ($chkadmin->checkstatus !== true) {
        $show_error = "Invalid license key";
      }
      else {
        if ($chkadmin->info['support'] < time()) {
          $show_error = "<strong>Your support expired on " . date("dS M, Y", $chkadmin->info['support']) . "</strong> and you are not able to install or upgrade the script, contact to EvolutionScript administration to extend your support";
        }
        else {
          $_SESSION['support_ok'] = 1;
          $myFile = REALPATH . "/includes/config.php";
          $fh = @fopen($myFile, "w");

          if ($fh) {
            $configtxt = "<?php\n";
            $configtxt .= "\$config['Database']['servername'] = '" . servername . "';\n";
            $configtxt .= "\$config['Database']['dbname'] = '" . dbname . "';\n";
            $configtxt .= "\$config['Database']['username'] = '" . dbusername . "';\n";
            $configtxt .= "\$config['Database']['password'] = '" . dbpassword . "';\n";
            $configtxt .= "\$config['Misc']['license'] = '" . licensekey . "';\n";
            $configtxt .= "\$config['Misc']['version'] = '" . $software_version . "';\n";
            $configtxt .= "?>";
            fwrite($fh, $configtxt);
            fclose($fh);
            $db = new Database();
            $db->connect(dbname, servername, dbusername, dbpassword);
            show_header();
            echo "<form method=\"post\"><input type=\"hidden\" name=\"step\" value=\"6\">
            <input type=\"hidden\" name=\"install_path\" value=\"" . install_path . "\">
            <input type=\"hidden\" name=\"url\" value=\"" . url . "\">
            <input type=\"hidden\" name=\"servername\" value=\"" . servername . "\">
            <input type=\"hidden\" name=\"dbname\" value=\"" . dbname . "\">
            <input type=\"hidden\" name=\"dbusername\" value=\"" . dbusername . "\">
            <input type=\"hidden\" name=\"dbpassword\" value=\"" . dbpassword . "\">
            <input type=\"hidden\" name=\"terms\" value=\"" . terms . "\">
            <input type=\"hidden\" name=\"terms\" value=\"" . licensekey . "\">
            <input type=\"hidden\" name=\"creating_table\" value=\"1\">
            <h2>Installing tables</h2>";
            foreach ($sql as $query) {
              $db->query($query);
              echo " . ";
              flush();
              ob_flush();
            }

            echo "done. <div style=\"text-align:right; padding-top:20px;\"><input type=\"submit\" name=\"btn\" value=\"Next &raquo;\" /></div>
            </form>";
            show_footer();
          } else $show_error = "Can't open config.php";
        }
      }
    } else $show_error = "Enter your license key";
    break;

  case "4":
    if (((((install_path && url) && servername) && dbname) && dbusername) && terms) {
      $link = @mysql_connect($input->r['servername'], $input->r['dbusername'], $input->r['dbpassword']);

      if ($link) {
        if (@mysql_select_db($input->r['dbname'], $link)) {
          show_header($show_error);
          echo "<form method=\"post\"><input type=\"hidden\" name=\"step\" value=\"5\">
            <input type=\"hidden\" name=\"terms\" value=\"" . terms . "\">
            <input type=\"hidden\" name=\"install_path\" value=\"" . install_path . "\">
            <input type=\"hidden\" name=\"url\" value=\"" . url . "\">
            <input type=\"hidden\" name=\"servername\" value=\"" . servername . "\">
            <input type=\"hidden\" name=\"dbname\" value=\"" . dbname . "\">
            <input type=\"hidden\" name=\"dbusername\" value=\"" . dbusername . "\">
            <input type=\"hidden\" name=\"dbpassword\" value=\"" . dbpassword . "\">
            <h2>License key</h2>
            <table width=100%>
              <tr>
                <td width=150><strong>Your license key:</strong></td>
                <td><input type=\"text\" name=\"licensekey\" value=\"" . licensekey . "\" style=\"width:300px\"></td>
              </tr>
            </table>
            <div style=\"text-align:right; padding-top:20px;\"><input type=\"submit\" name=\"btn\" value=\"Next &raquo;\" /></div>
            </form>";
          show_footer();
          mysql_close($link);
        }
      } else $show_error = "Error MySQL DB Conection";
    } else $show_error = "You must complete all details required.";
    break;

  case "3":
    if ((install_path && url) && terms) {
      show_header($show_error);
      echo "<form method=\"post\"><input type=\"hidden\" name=\"step\" value=\"4\">
        <input type=\"hidden\" name=\"terms\" value=\"" . terms . "\">
        <input type=\"hidden\" name=\"install_path\" value=\"" . install_path . "\">
        <input type=\"hidden\" name=\"url\" value=\"" . url . "\">
        <h2>Database details</h2>
        <table width=100%>
          <tr>
            <td width=150><strong>SQL Host:</strong></td>
            <td><input type=\"text\" name=\"servername\" value=\"localhost\" style=\"width:300px\"></td>
          </tr>
          <tr>
            <td width=150><strong>Database name:</strong></td>
            <td><input type=\"text\" name=\"dbname\" style=\"width:300px\"></td>
          </tr>
          <tr>
            <td width=150><strong>SQL Username:</strong></td>
            <td><input type=\"text\" name=\"dbusername\" style=\"width:300px\"></td>
          </tr>
          <tr>
            <td width=150><strong>SQL Password:</strong></td>
            <td><input type=\"password\" name=\"dbpassword\" style=\"width:300px\"></td>
          </tr>
        </table>
        <div style=\"text-align:right; padding-top:20px;\"><input type=\"submit\" name=\"btn\" value=\"Next &raquo;\" /></div>
        </form>
        ";
      show_footer();
    }
    break;

  case "2":
    if ($input->r['terms']) {
      show_header();
      if ($_SERVER["SERVER_NAME"] == "localhost") {
        $sysurl = "http://" . $_SERVER["SERVER_ADDR"] . ($_SERVER["SERVER_PORT"] == 80 ? '' : ':' . $_SERVER["SERVER_PORT"]) . $_SERVER["REQUEST_URI"];
      } else $sysurl = "http://" . $_SERVER["SERVER_NAME"] . ($_SERVER["SERVER_PORT"] == 80 ? '' : ':' . $_SERVER["SERVER_PORT"]) . $_SERVER["REQUEST_URI"];
      $sysurl = str_replace("install/install.php", "", $sysurl);
      echo "<form method=\"post\"><input type=\"hidden\" name=\"step\" value=\"3\">
        <input type=\"hidden\" name=\"terms\" value=\"" . terms . "\">
        <h2>Address  details</h2>
        <table width=100%>
          <tr>
            <td width=150><strong>Install Directory:</strong></td>
            <td><input type=\"text\" name=\"install_path\" value=\"" . REALPATH . "\" style=\"width:300px\"></td>
          </tr>
          <tr>
            <td width=150><strong>Install Address:</strong></td>
            <td><input type=\"text\" name=\"url\" value=\"" . $sysurl . "\" style=\"width:300px\"></td>
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
    if ($input->r['file_req'] && $input->r['php_req']) {
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
              <div>Welcome to the installer. This wizard will guide you through the installation process.</div>
          <h2>Checking requirements</h2>
          ";

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
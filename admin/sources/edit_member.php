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

$today_date = date("Y-m-d");
$member = $db->fetchRow("SELECT * FROM members WHERE id=" . $input->gc['edit']);
$days_diff = dateDiff($member['last_cron'], $today_date);
$user_info = $member;

if (1 <= $days_diff) {
	include INCLUDES . "crons/ptc.php";
	$cron_list = scandir(INCLUDES . "crons/");
	foreach ($cron_list as $c) {

		if (!in_array($c, array(".", ".."))) {
			if ($c != "ptc.php" && is_file(INCLUDES . "crons/" . $c)) {
				include INCLUDES . "crons/" . $c;
				continue;
			}

			continue;
		}
	}

	header("location: ./?view=members&edit=" . $member['id']);
	exit();
}

$paymentq = $db->query("SELECT id, name FROM gateways ORDER BY name ASC");
$gateway = array();

while ($row = $db->fetch_array($paymentq)) {
	$gateway[] = $row;
}

$user_gateway = unserialize($member['gateways']);

if (!is_array($user_gateway)) {
	$user_gateway = array();
}


if ($input->p['a'] == "misc") {
	verifyajax();
	verifydemo();
	$dothing = $input->pc['do'];

	if ($dothing == "delete") {
		deletemember($member['id']);
		$db->query(("UPDATE country SET users=users-1 WHERE name='" . $member['country'] . "'"));

		if ($member['ref1'] != 0) {
			$db->query("UPDATE members SET referrals=referrals-1, myrefs1=myrefs1-1 WHERE id=" . $member['ref1']);
		}

		serveranswer(4, "location.href=\"./?view=members\";");
	}
	else {
		if ($dothing == "resetads") {
			$upd = $db->query("UPDATE members SET advisto='' WHERE id=" . $member['id']);
			serveranswer(1, "Ads were reset for this member");
		}
		else {
			if ($dothing == "unhookrefs") {
				unhookrefs($member['id']);
				serveranswer(1, "Account updated.");
			}
			else {
				if ($dothing == "unhookrented") {
					unhookrented($member['id']);
					serveranswer(1, "Account updated.");
				}
			}
		}
	}
}


if ($input->pc['a'] == "update") {
	verifyajax();
	verifydemo();
	$required_fields = array("fullname", "email", "country");
	foreach ($required_fields as $k) {

		if (!$input->pc[$k]) {
			serveranswer(0, "One of the required field(s) is empty");
			continue;
		}
	}


	if ($input->pc['email'] != $member['email']) {
		$chk = $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE email='" . $input->pc['email'] . "' AND id!=" . $member['id']);

		if ($chk != 0) {
			serveranswer(0, "Email is already used by other member");
		}
	}


	if (is_array($input->p['gateway'])) {
		foreach ($input->p['gateway'] as $k => $v) {

			if ($v) {
				$verify = $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE gateways LIKE '%" . $v . "%' AND id!=" . $member['id']);

				if ($verify != 0) {
					serveranswer(0, $k . " account (" . $v . ") is being used by other member");
					continue;
				}

				continue;
			}
		}

		$gatewayusr = serialize($input->p['gateway']);
	}


	if ($input->pc['password']) {
		if (strlen($input->pc['password']) < 6) {
			serveranswer(0, "Password must has 6 characters as minimum");
		}

		$array1 = array("password" => md5($input->pc['password']));
	}
	else {
		$array1 = array("password" => $member['password']);
	}


	if (0 < $input->pc['extend']) {
		$days = $input->pc['extend'] * 60 * 60 * 24;

		if ($member['upgrade_ends'] < TIMENOW) {
			$daystoextend = TIMENOW + $days;
			$array2 = array("upgrade_ends" => $daystoextend);
		}
		else {
			$daystoextend = $member['upgrade_ends'] + $days;
			$array2 = array("upgrade_ends" => $daystoextend);
		}
	}
	else {
		if ($input->pc['extend'] == -1) {
			$array2 = array("upgrade_ends" => $member['upgrade_ends']);
		}
		else {
			$array2 = array("upgrade_ends" => 0);
		}
	}

	$set = array_merge($array1, $array2);

	if ($input->pc['refname'] == "") {
		if ($member['ref1'] == 0) {
			$refid = "0";
		}
		else {
			$upd = $db->query("UPDATE members SET referrals=referrals-1 WHERE id=" . $member['ref1']);
			$refid = "0";
		}
	}
	else {
		$verifymember = $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE username='" . $input->pc['refname'] . "' and id!=" . $member['id']);

		if ($verifymember != 0) {
			$refid = $db->fetchOne(("SELECT id FROM members WHERE username='" . $input->pc['refname'] . "'"));

			if ($member['ref1'] != $refid) {
				$upd = $db->query("UPDATE members SET referrals=referrals+1, myrefs1=myrefs1+1 WHERE id=" . $refid);
				$upd = $db->query("UPDATE members SET referrals=referrals-1, myrefs1=myrefs1-1 WHERE id=" . $member['ref1']);
			}
		}
		else {
			$refid = $member['ref1'];
		}
	}

	$arrayother = array("fullname" => $input->pc['fullname'], "country" => $input->pc['country'], "type" => $input->pc['type'], "purchase_balance" => $input->pc['purchase_balance'], "money" => $input->pc['money'], "ad_credits" => $input->pc['ad_credits'], "loginads_credits" => $input->pc['loginads_credits'], "ptsu_credits" => $input->pc['ptsu_credits'], "fads_credits" => $input->pc['fads_credits'], "flink_credits" => $input->pc['flink_credits'], "banner_credits" => $input->pc['banner_credits'], "ref1" => $refid, "email" => $input->pc['email'], "gateways" => $gatewayusr, "adminnotes" => $input->pc['adminnotes'], "ptsu_denied" => $input->pc['ptsu_denied'], "points" => $input->pc['points']);
	$data = array_merge($set, $arrayother);
	$upd = $db->update("members", $data, "id=" . $member['id']);
	$upd = $db->query(("UPDATE country SET users=users-1 WHERE name='" . $member['country'] . "'"));
	$countcountry = $db->fetchOne("SELECT COUNT(*) AS NUM FROM country WHERE name='" . $input->pc['country'] . "'");

	if ($countcountry == 0) {
		$data = array("name" => $input->pc['country'], "users" => "1");
		$upd = $db->insert("country", $data);
	}
	else {
		$upd = $db->query("UPDATE country SET users=users+1 WHERE name='" . $input->pc['country'] . "'");
	}

	serveranswer(3, "Account Updated.");
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Member: ";
echo $member['username'];
echo "</div>
<div class=\"site_content\">

<div id=\"tabs\">
    <ul>
        <li><a href=\"#tabs-1\">Update Member</a></li>
        <li><a href=\"#tabs-2\">Other Information</a></li>
        <li><a href=\"#tabs-3\">Other Action</a></li>
    </ul>

	<div id=\"tabs-1\">
    	";
include SOURCES . "edit_member_1.php";
echo "
    </div>
	<div id=\"tabs-2\">
    	";
include SOURCES . "edit_member_2.php";
echo "    </div>
    <div id=\"tabs-3\">
    	<div class=\"dashbaord-img-1\">
                    <form method=\"post\" id=\"misc1frm\" onsubmit=\"return submitform(this.id);\">
                    <input type=\"hidden\" name=\"a\" value=\"misc\" />
                    <input type=\"hidden\" name=\"do\" value=\"delete\" />
                    <div class=\"widget-title\">
                    Delete User
                    </div>
                    <div class=\"widget-content\">
                    Warning: Account deletion is irreversible.
                        <div align=\"center\" style=\"padding-top:5px;\">
                            <input type=\"submit\" name=\"btn\" value=\"Send\" />
                        </div>
                    </div>
                    </form>

                    <form method=\"post\" id=\"misc3frm\" onsubmit=\"return submitform(this.id);\">
                    <input type=\"hidden\" name=\"a\" value=\"misc\" />
                    <input type=\"hidden\" name=\"do\" value=\"unhookrefs\" />
                    <div class=\"widget-title\">
                    Unhook Referrals
                    </div>
                    <div class=\"widget-content\">
                     Direct referrals from this account  will be reset.
                        <div align=\"center\" style=\"padding-top:5px;\">
                            <input type=\"submit\" name=\"btn\" value=\"Send\" />
                        </div>
                    </div>
                    </form>

                    <div class=\"widget-title\">
                    Send Mail
                    </div>
                    <div class=\"widget-content\">
                    Send a message to this member via email
                        <div align=\"center\" style=\"padding-top:5px;\">
                            <input type=\"submit\" name=\"btn\" value=\"Send\" onclick=\"location.href='./?view=massmail&member=";
echo $member['username'];
echo "';\" />
                        </div>
                    </div>
		</div>
    	<div class=\"dashbaord-img-2\">
                    <form method=\"post\" id=\"misc2frm\" onsubmit=\"return submitform(this.id);\">
                    <input type=\"hidden\" name=\"a\" value=\"misc\" />
                    <input type=\"hidden\" name=\"do\" value=\"resetads\" />
                    <div class=\"widget-title\">
                    Reset Ads
                    </div>
                    <div class=\"widget-content\">
                    Allows to member to surf ads again.
                        <div align=\"center\" style=\"padding-top:5px;\">
                            <input type=\"submit\" name=\"btn\" value=\"Send\" />
                        </div>
                    </div>
                    </form>

                    <form method=\"post\" id=\"misc4frm\" onsubmit=\"return submitform(this.id);\">
                    <input type=\"hidden\" name=\"a\" value=\"misc\" />
                    <input type=\"hidden\" name=\"do\" value=\"unhookrented\" />
                    <div class=\"widget-title\">
                    Unhook Rented Referrals
                    </div>
                    <div class=\"widget-content\">
                    Rented referrals from this account  will be reset.
                        <div align=\"center\" style=\"padding-top:5px;\">
                            <input type=\"submit\" name=\"btn\" value=\"Send\" />
                        </div>
                    </div>
                    </form>
                    <div class=\"widget-title\">
                    Send On Site Message
                    </div>
                    <div class=\"widget-content\">
                    Send a message to this member via internal message system
                        <div align=\"center\" style=\"padding-top:5px;\">
                            <input type=\"submit\" name=\"btn\" value=\"Send\" onclick=\"location.href='./?view=massmessage&member=";
echo $member['username'];
echo "';\" />
                        </div>
                    </div>
		</div>
        <div class=\"clear\"></div>

    </div>
</div>

 </div>
";
include SOURCES . "footer.php";
echo " ";
?>
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

$daterange = daterange(date("m/d/Y"));
$cheatlogs = $db->fetchOne("SELECT COUNT(*) AS NUM FROM cheat_log WHERE date>=" . $daterange[0] . " AND date<=" . $daterange[1]);
$pending_ptc = $db->fetchOne("SELECT COUNT(*) AS NUM FROM ads WHERE status='Pending'");
$pending_loginads = $db->fetchOne("SELECT COUNT(*) AS NUM FROM login_ads WHERE status='Pending'");
$pending_fads = $db->fetchOne("SELECT COUNT(*) AS NUM FROM featured_ads WHERE status='Pending'");
$pending_flinks = $db->fetchOne("SELECT COUNT(*) AS NUM FROM featured_link WHERE status='Pending'");
$pending_banners = $db->fetchOne("SELECT COUNT(*) AS NUM FROM banner_ads WHERE status='Pending'");
$pending_ptsu = $db->fetchOne("SELECT COUNT(*) AS NUM FROM ptsu_offers WHERE status='Pending'");
$pending_ptsurequest = $db->fetchOne("SELECT COUNT(*) AS NUM FROM ptsu_requests WHERE owner_id=0 AND status='Pending'");
$pending_ptsurejected = $db->fetchOne("SELECT COUNT(*) AS NUM FROM ptsu_requests WHERE status='Rejected1'");
$pending_withdrawal = $db->fetchOne("SELECT COUNT(*) AS NUM FROM withdraw_history WHERE status='Pending'");
$pending_orders = $db->fetchOne("SELECT COUNT(*) AS NUM FROM order_history WHERE status='Pending'");
$open_tickets = $db->fetchOne("SELECT COUNT(*) AS NUM FROM helpdesk_ticket WHERE status=1");
$awaiting_tickets = $db->fetchOne("SELECT COUNT(*) AS NUM FROM helpdesk_ticket WHERE status=3");
$unreferred = $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE ref1='0'");
$pendingcashout = $db->fetchOne("SELECT SUM(amount) FROM withdraw_history WHERE status='Pending'");
$pendingcashout = ($pendingcashout ? $pendingcashout : 0);

if ($settings['ptcevonews_nextcheck'] < TIMENOW) {
	//$validurl = "http://50.28.45.97/";
	$validurl = "";
	$ch = curl_init();
	$postfields['last_id'] = $settings['ptcevonews_lastid'];
	curl_setopt($ch, CURLOPT_URL, $validurl . "script_news.php");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	curl_close($ch);
	$data = unserialize($data);

	if (is_array($data)) {
		foreach ($data as $ptcnews) {
			$data = array("date" => $ptcnews['date'], "title" => $ptcnews['title'], "message" => $ptcnews['message'], "important" => $ptcnews['important']);
			$last_id = $ptcnews['id'];
			$db->insert("ptcevo_news", $data);
		}

		$db->query("UPDATE settings SET value='" . $last_id . "' WHERE field='ptcevonews_lastid'");
	}

	$db->query("UPDATE settings SET value='" . (TIMENOW + 43200) . "' WHERE field='ptcevonews_nextcheck'");
}


if ($input->p['do'] == "delete_news") {
	verifyajax();
	verifydemo();
	$db->delete("ptcevo_news", "id=" . $input->pc['nid']);
	serveranswer(6, "$(\"#msg" . $input->pc['nid'] . "\").remove();");
}

$total_news = $db->fetchOne("SELECT COUNT(*) AS NUM FROM ptcevo_news");
include SOURCES . "header.php";
echo "
<div class=\"site_title\">Dashboard</div>
<div class=\"site_content\">
<div class=\"widget-title\">Welcome!</div>
<div class=\"widget-content\">
    <div class=\"admin-info\">
        <div class=\"title\">";
echo $admin->getUsername();
echo "</div>
        <div>Username: ";
echo $admin->getUsername();
echo "</div>
        <div>Email: ";
echo $admin->getEmail() == "" ? "<a href=\"./?view=account\">Click here to update</a>" : $admin->getEmail();
echo "</div>
        <div>Last Login: ";
echo $admin->getLastlogin() == 0 ? "Never" : date("d M Y h:i A", $admin->getLastlogin());
echo "</div>
    </div>
    <div class=\"calendar\">
        <div class=\"top corner-top\">
		<div style=\"font-size:14px\">";
echo date("l");
echo "</div>
		";
echo date("d");
echo "</div>
        <div class=\"bottom corner-bottom\">";
echo date("M");
echo "</div>
    </div>
    <div class=\"clear\"></div>
</div>

";
$pending_action = array();

if (0 < $cheatlogs) {
	$pending_action[] = "<a href=\"./?view=cheat_logs\">" . $cheatlogs . " Cheat logs today</a>";
}


if (0 < $pending_withdrawal && $admin->permissions['withdrawals']) {
	$pending_action[] = "<a href=\"./?view=withdrawals&do=search&status=Pending\">" . $pending_withdrawal . " Requests for withdrawal</a>";
}


if (0 < $open_tickets && $admin->permissions['support_manager']) {
	$pending_action[] = "<a href=\"./?view=support&do=search&status=1\">" . $open_tickets . " New Open Ticket(s)</a>";
}


if (0 < $awaiting_tickets && $admin->permissions['support_manager']) {
	$pending_action[] = "<a href=\"?view=support&do=search&status=3\">" . $awaiting_tickets . " Ticket(s) Awaiting Reply</a>";
}


if (0 < $pending_orders && $admin->permissions['orders']) {
	$pending_action[] = "<a href=\"./?view=orders&do=search&status=Pending\">" . $pending_orders . " Pending Order(s)</a>";
}


if (0 < $pending_ptc && $admin->permissions['ptcads_manager']) {
	$pending_action[] = "<a href=\"./?view=manageptc&do=search&status=Pending\">" . $pending_ptc . " PTC Ads Waiting for Approval</a>";
}


if (0 < $pending_loginads && $admin->permissions['loginads_manager']) {
	$pending_action[] = "<a href=\"./?view=manageloginad&do=search&status=Pending\">" . $pending_loginads . " Login Ads Waiting for Approval</a>";
}


if (0 < $pending_fads && $admin->permissions['featuredads_manager']) {
	$pending_action[] = "<a href=\"./?view=managefad&do=search&status=Pending\">" . $pending_fads . " Featured Ads Waiting for Approval</a>";
}


if (0 < $pending_flinks && $admin->permissions['featuredlinks_manager']) {
	$pending_action[] = "<a href=\"./?view=manageflink&do=search&status=Pending\">" . $pending_flinks . " Featured Link Ads Waiting for Approval</a>";
}


if (0 < $pending_banners && $admin->permissions['bannerads_manager']) {
	$pending_action[] = "<a href=\"./?view=managebannerad&do=search&status=Pending\">" . $pending_banners . " Banner Ads Waiting for Approval</a>";
}


if (0 < $pending_ptsu && $admin->permissions['ptsuoffers_manager']) {
	$pending_action[] = "<a href=\"./?view=manageptsu&do=search&status=Pending\">" . $pending_ptsu . " PTSU Offers Waiting for Approval</a>";
}


if ((0 < $pending_ptsurequest || 0 < $pending_ptsurejected) && $admin->permissions['ptsuoffers_manager']) {
	$pending_action[] = "<a href=\"./?view=ptsu_pending&do=search&status=Pending2\">" . ($pending_ptsurequest + $pending_ptsurejected) . " PTSU Waiting for Review</a>";
}


if (0 < count($pending_action)) {
	echo "<div class=\"dashboardbox corner-all\">";
	$n = 0;
	foreach ($pending_action as $v) {
		$n = $n + 1;
		echo $v . ($n != count($pending_action) ? "&nbsp; &bull; &nbsp;" : "");
	}

	echo "</div>";
}

echo "
    <div id=\"tabs\">
        <ul>
        	";

if ($admin->permissions['statistics']) {
	echo "            <li><a href=\"#tabs-1\">Statistics</a></li>
            ";
}

echo "            <li><a href=\"#tabs-2\">Login Failures</a></li>
        	";

if ($admin->permissions['statistics']) {
	echo "            <li><a href=\"#tabs-3\">Site Information</a></li>
            ";
}

echo "            <li><a href=\"#tabs-4\">Product Information</a></li>
            <li><a href=\"#tabs-5\">EvolutionScript News ";
echo $total_news != 0 ? "<strong>(" . $total_news . ")</strong>" : "";
echo "</a>
        </ul>
		";

if ($admin->permissions['statistics']) {
	echo "        <div id=\"tabs-1\">
            ";
	include SOURCES . "statistics.php";
	echo "        </div>
        ";
}

echo "
            <div id=\"tabs-2\">
            <div style=\"margin-bottom:5px;\"><input type=\"button\" value=\"View all\" onclick=\"location.href='?view=loginlog';\"></div>
            ";

if (!$admin->permissions['administrators']) {
	$conditional = ("AND username='" . $admin->getUsername() . "'");
}

$todayis = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
$q = $db->query(("SELECT * FROM admin_loginlog WHERE fail=1 AND date>=" . $todayis . " ") . $conditional);
$n = 0;

while ($r = $db->fetch_array($q)) {
	$n = $n + 1;
	echo "            <div class=\"error_login\">
                <div class=\"title\">";
	echo $r['username'];
	echo "</div>
                <div><strong>User Agent:</strong> ";
	echo $r['agent'];
	echo "</div>
                <div><strong>IP Address:</strong> ";
	echo $r['ip'];
	echo "</div>
                <div><strong>Date:</strong> ";
	echo date("d M Y h:i A", $r['date']);
	echo " (<span>";
	echo datepass($r['date']);
	echo "</span>)</div>
            </div>
            ";
}

echo $n == 0 ? "No information available in this view" : "";
echo "        </div>
		";

if ($admin->permissions['statistics']) {
	echo "        <div id=\"tabs-3\">
            ";
	include SOURCES . "site_information.php";
	echo "        </div>
        ";
}

echo "        <div id=\"tabs-4\">
            ";
include SOURCES . "product_information.php";
echo "        </div>
        <div id=\"tabs-5\">
        	";

if ($total_news == 0) {
	echo "There are not news.";
}
else {
	$q = $db->query("SELECT * FROM ptcevo_news ORDER BY date DESC LIMIT 20");

	while ($r = $db->fetch_array($q)) {
		echo "        <form id=\"msg";
		echo $r['id'];
		echo "\" onsubmit=\"return submitform(this.id);\">
        <input type=\"hidden\" name=\"do\" value=\"delete_news\" />
        <input type=\"hidden\" name=\"nid\" value=\"";
		echo $r['id'];
		echo "\" />
        <fieldset class=\"";
		echo $r['important'] == 1 ? "news-important" : "news-normal";
		echo "\" style=\"line-height:normal\">
        	<legend>Published on ";
		echo date("dS M, Y \a\t h:i a", $r['date']);
		echo "</legend>
            <div style=\"font-weight:bold; padding-bottom:5px; font-size:12px;\">";
		echo $r['title'];
		echo "</div>
            ";
		echo $r['message'];
		echo "            <div style=\"padding-top:5px\">
            <input type=\"submit\" name=\"btn\" value=\"Delete this news\" />
            </div>
        </fieldset>
        </form>
        ";
	}
}

echo "        </div>
    </div>
 </div>
";
include SOURCES . "footer.php";
echo " ";
?>
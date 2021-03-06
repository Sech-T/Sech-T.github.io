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


if (!$admin->permissions['manage_members']) {
	header("location: ./");
	exit();
}


if (is_numeric($input->g['loginas'])) {
	$chk = $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE id=" . $input->gc['loginas']);

	if ($chk != 0) {
		$cookie_id = strtoupper(md5(TIMENOW . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']));
		$db->query("UPDATE members SET cookie_id='" . $cookie_id . "' WHERE id=" . $input->gc['loginas']);
		$user_info = $db->fetchRow("SELECT * FROM members WHERE id=" . $input->gc['loginas']);
		$_SESSION['user_id'] = $user_info['id'];
		$_SESSION['password'] = $user_info['password'];
		$_SESSION['cookie_id'] = $cookie_id;
		setcookie("user_id", $user_info['id'], time() + 86400);
		setcookie("password", $user_info['password'], time() + 86400);
		setcookie("cookie_id", $cookie_id, time() + 86400);
		header("location: " . $settings['site_url']);
		exit();
	}
}


if (is_numeric($input->g['edit'])) {
	$chk = $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE id=" . $input->gc['edit']);

	if ($chk != 0) {
		include SOURCES . "edit_member.php";
		exit();
	}
}


if ($input->p['action']) {
	if ($settings['demo'] == "yes") {
		$error_msg = "This is not possible in demo version";
	}
	else {
		if ($input->p['sesion_id'] != $_SESSION['sesion_id']) {
			$error_msg = "Invalid token try again please";
		}
		else {
			if (is_array($input->p['mid'])) {
				foreach ($input->p['mid'] as $mid) {
					switch ($input->p['a']) {
						case "suspend":
							$setupd = array("status" => "Suspended");
							$db->update("members", $setupd, "id=" . $mid);
							break;

						case "unsuspend":
							$setupd = array("status" => "Active");
							$db->update("members", $setupd, "id=" . $mid);
							break;

						case "activate":
							$setupd = array("status" => "Active");
							$db->update("members", $setupd, "id=" . $mid);
							break;

						case "delete":
							$userdata = $db->fetchRow("SELECT username, country, ref1 FROM members WHERE id=" . $mid);
							deletemember($mid);

							if ($userdata['username'] != "BOT") {
								$db->query(("UPDATE country SET users=users-1 WHERE name='" . $userdata['country'] . "'"));
							}


							if ($userdata['ref1'] != 0) {
								$db->query("UPDATE members SET referrals=referrals-1, myrefs1=myrefs1-1 WHERE id=" . $userdata['ref1']);
							}
							break;

						case "unhook":
							unhookrefs($mid);
							break;

						case "unhook2":
							unhookrented($mid);
					}
				}
			}
		}
	}
}

$membership = array();
$q = $db->query("SELECT id, name FROM membership");

while ($r = $db->fetch_array($q)) {
	$membership[$r['id']] = $r['name'];
}


if ($input->r['do'] == "search") {
	$searchvars = array("username", "ref1", "fullname", "email", "status", "signup", "type", "last_login", "country", "ip", "rented", "adminnotes");
	foreach ($searchvars as $k) {

		if ($input->r[$k]) {
			switch ($k) {
				case "ref1":
					$refid = $db->fetchOne("SELECT id FROM members WHERE username='" . $db->real_escape_string($input->rc[$k]) . "'");
					$cond .= $k . "='" . $refid . "' AND ";
					break;

				case "fullname":
					$cond .= ("(") . $k . " LIKE '%" . $input->rc[$k] . "%') AND ";
					break;

				case "signup":
					$signup = daterange($input->rc[$k]);
					$cond .= ("(") . $k . " > " . $signup[0] . " AND " . $k . " < " . $signup[1] . ") AND ";
					break;

				case "last_login":
					$last_login = daterange($input->rc[$k]);
					$cond .= ("(") . $k . " > " . $last_login[0] . " AND " . $k . " < " . $last_login[1] . ") AND ";
					break;

				case "ip":
					$cond .= "(signup_ip='" . $input->rc[$k] . "' OR last_ip='" . $input->rc[$k] . "') AND ";
					break;

				case "rented":
					$rentedid = $db->fetchOne(("SELECT id FROM members WHERE username='" . $input->rc[$k] . "'"));
					$rentedid = ($rentedid == "" ? -1 : $rentedid);
					$cond .= $k . "='" . $rentedid . "' AND ";
					break;

				case "adminnotes":
					$cond .= ("(") . $k . " LIKE '%" . $input->rc[$k] . "%') AND ";
					break;

				default:
					$cond .= $k . "='" . $input->rc[$k] . "' AND ";
					break;
			}

			$adlink .= (($k . "=") . $input->r[$k] . "&");
			continue;
		}
	}


	if ($cond) {
		$cond = substr($cond, 0, -5);
	}


	if ($adlink) {
		$adlink = "do=search&" . $adlink;
	}
}

$paginator = new Pagination("members", $cond);
$paginator->setOrders("id", "DESC");
$paginator->setPage($input->gc['page']);
$paginator->allowedfield($allowed);
$paginator->setNewOrders($input->gc['orderby'], $input->gc['sortby']);
$paginator->setLink("./?view=members&" . $adlink);
$q = $paginator->getQuery();
include SOURCES . "header.php";
echo "<script>
$(function()
{
	$(\".datepicker\").datepicker({ minDate: \"-2Y\" });

});
</script>
<div class=\"site_title\">Manage Members</div>
<div class=\"site_content\">
";

if ($error_msg) {
	echo "<div class=\"error_box\">";
	echo $error_msg;
	echo "</div>
";
}

echo "

<div class=\"ui-tabs ui-widget ui-widget-content ui-corner-all\">
   <ul class=\"ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all\">
     <li class=\"ui-state-default ui-corner-top ui-tabs-selected ui-state-active\"><a href=\"javascript:void(0);\" onclick=\"$('#search-content').slideToggle();\" style=\"cursor:pointer\">Search</a></li>
  </ul>
   <div class=\"ui-tabs-panel ui-widget-content ui-corner-bottom\" id=\"search-content\" ";
echo !$adlink ? "style=\"display:none\"" : "";
echo ">
<form method=\"post\">
            <input type=\"hidden\" name=\"do\" value=\"search\" />
            <table width=\"100%\" class=\"widget-tbl\">
                <tr>
                    <td align=\"right\">Username:</td>
                    <td><input type=\"text\" name=\"username\" value=\"";
echo $input->r['username'];
echo "\" /></td>
                    <td align=\"right\">Upline:</td>
                    <td><input type=\"text\" name=\"ref1\" value=\"";
echo $input->r['ref1'];
echo "\" /></td>
                </tr>
                <tr>
                    <td align=\"right\">Name:</td>
                    <td><input type=\"text\" name=\"fullname\" value=\"";
echo $input->r['fullname'];
echo "\" /></td>
                    <td align=\"right\">Email:</td>
                    <td><input type=\"text\" name=\"email\" value=\"";
echo $input->r['email'];
echo "\" /></td>
                </tr>
                <tr>
                    <td align=\"right\">Status</td>
                    <td>
            <select name=\"status\">
            <option value=\"\">All</option>
            ";
$statusvalues = array("Active", "Un-verified", "Inactive", "Suspended");
foreach ($statusvalues as $v) {

	if ($v == $input->r['status']) {
		echo "<option value='" . $v . "' selected>" . $v . "</option>";
		continue;
	}

	echo "<option value='" . $v . "'>" . $v . "</option>";
}

echo "            </select>
                    </td>
                    <td align=\"right\">Registration date:</td>
                    <td><input type=\"text\" name=\"signup\" value=\"";
echo $input->r['signup'];
echo "\" class=\"datepicker\" /></td>
                </tr>
                <tr>
                    <td align=\"right\">Membership:</td>
                    <td>
                    <select name=\"type\">
                        <option value=\"\">All</option>
                        ";
foreach ($membership as $k => $v) {

	if ($input->r['type'] == $k) {
		echo "<option value=\"" . $k . "\" selected>" . $v . "</option>";
		continue;
	}

	echo "<option value=\"" . $k . "\">" . $v . "</option>";
}

echo "                    </select>
                    </td>
                    <td align=\"right\">Last Login:</td>
                    <td><input type=\"text\" name=\"last_login\" value=\"";
echo $input->r['last_login'];
echo "\" class=\"datepicker\" /></td>
                </tr>
                <tr>
                    <td align=\"right\">
                    Country
                    </td>
                    <td>
                    <select name=\"country\">
                        <option value=\"\">All</option>
                  ";
$countrylist = $db->query("SELECT country FROM ip2nationCountries ORDER BY country ASC");

while ($list = $db->fetch_array($countrylist)) {
	if ($input->r['country'] == $list['country']) {
		echo "<option value=\"" . $list['country'] . "\" selected>" . $list['country'] . "</option>";
	}
	else {
		echo "<option value=\"" . $list['country'] . "\">" . $list['country'] . "</option>";
	}
}

echo "                    </select>
                    </td>
                    <td align=\"right\">IP:</td>
                    <td><input type=\"text\" name=\"ip\" value=\"";
echo $input->r['ip'];
echo "\" /></td>
                </tr>
                <tr>
                    <td align=\"right\">Uplined rented:</td>
                    <td><input type=\"text\" name=\"rented\" value=\"";
echo $input->r['rented'];
echo "\" /></td>
                    <td align=\"right\">Admin notes:</td>
                    <td><input type=\"text\" name=\"adminnotes\" value=\"";
echo $input->r['adminnotes'];
echo "\" /></td>
                </tr>
                <tr>
                     <td colspan=\"4\" align=\"center\"><input type=\"submit\" name=\"send\" value=\"Search\">
                </tr>
            </table>
            </form>
   </div>
</div>



<form method=\"post\" action=\"";
echo $paginator->gotopage();
echo "\">
  <table width=\"100%\" class=\"widget-tbl\">
  	<tr class=\"titles\">
    	<td width=\"20\"><input type=\"checkbox\" id=\"checkall\"></td>
        <td>";
echo $paginator->linkorder("username", "Username");
echo " / ";
echo $paginator->linkorder("email", "E-mail");
echo "</td>
        <td align=\"center\">";
echo $paginator->linkorder("type", "Membership");
echo "</td>
        <td align=\"center\">";
echo $paginator->linkorder("referrals", "Refs");
echo " / ";
echo $paginator->linkorder("rented_referrals", "Rented Refs");
echo "</td>
        <td align=\"center\">";
echo $paginator->linkorder("money", "Balance");
echo " / ";
echo $paginator->linkorder("purchase_balance", "Purchase");
echo "</td>
        <td align=\"center\">";
echo $paginator->linkorder("withdraw", "Paid");
echo " / ";
echo $paginator->linkorder("pending_withdraw", "Pending");
echo "</td>
        <td align=\"center\">";
echo $paginator->linkorder("cashout_times", "Times Paid");
echo "</td>
        <td align=\"center\">";
echo $paginator->linkorder("country", "Country");
echo "</td>
        <td align=\"center\">";
echo $paginator->linkorder("status", "Status");
echo "</td>
        <td></td>
    </tr>
    ";

while ($r = $db->fetch_array($q)) {
	$tr = ($tr == "tr1" ? "tr2" : "tr1");
	echo "  	<tr class=\"";
	echo $tr;
	echo " normal_linetbl\">
    	<td align=\"center\"><input type=\"checkbox\" name=\"mid[]\" value=\"";
	echo $r['id'];
	echo "\" class=\"checkall\" /></td>
        <td>";
	echo $r['username'];
	echo "<div style=\"font-size:11px\">";
	echo $r['email'];
	echo "</div></td>
        <td align=\"center\">";
	echo $membership[$r['type']];
	echo "</td>
        <td align=\"center\">
			<span style=\"color:#000099\">";
	echo $r['referrals'];
	echo "</span> / <span style=\"color:orange\">";
	echo $r['rented_referrals'];
	echo "</span>
        </td>
        <td align=\"center\">
			<span style=\"color:green\">";
	echo $r['money'];
	echo "</span> / <span style=\"color:#990000\">";
	echo $r['purchase_balance'];
	echo "</span>
        </td>
        <td align=\"center\">
			<span style=\"color:#990000\">";
	echo $r['withdraw'];
	echo "</span> / <span style=\"color:#000099\">";
	echo $r['pending_withdraw'];
	echo "</span>
        </td>
        <td align=\"center\">";
	echo $r['cashout_times'];
	echo "</td>
        <td align=\"center\">";
	echo $r['country'];
	echo "</td>
        <td align=\"center\"><span style=\"color:
        ";
	switch ($r['status']) {
		case "Active":
			echo "#009900";
			break;

		case "Inactive":
			echo "orange";
			break;

		case "Suspended":
			echo "#990000";
			break;

		default:
			echo "#996600";
			break;
	}

	echo "        \">";
	echo $r['status'];
	echo "</span></td>
        <td align=\"center\"><a href=\"./?view=members&edit=";
	echo $r['id'];
	echo "\"><img src=\"./css/images/edit.png\" border=\"0\" title=\"Edit member\" /></a> <a href=\"./?view=members&loginas=";
	echo $r['id'];
	echo "\" target=\"_blank\"><img src=\"./css/images/lock.png\" border=\"0\" title=\"Login as ";
	echo $r['username'];
	echo "\" /></a> <a href=\"javascript:void(0);\" onClick=\"openWindows('<span style=\'font-weight:normal\'>Member:</span> ";
	echo $r['username'];
	echo "', 'info-";
	echo $r['id'];
	echo "');\"><img src=\"./css/images/info.png\" title=\"More info\" border=\"0\" /></a>
<div id=\"info-";
	echo $r['id'];
	echo "\" style=\"display:none\">
<table width=\"100%\" class=\"widget-tbl\">
    <tr>
        <td align=\"right\" width=\"25%\">Fullname:</td>
        <td width=\"25%\"><strong>";
	echo $r['fullname'];
	echo "</strong></td>
        <td align=\"right\" width=\"25%\">Upline:</td>
        <td width=\"25%\" style=\"color:#000099\">";
	echo $r['ref1'] == 0 ? "-" : getusername($r['ref1']);
	echo "</td>
    </tr>
    ";
	$totaldep = $db->fetchOne("SELECT SUM(amount) FROM deposit_history WHERE user_id=" . $r['id']);
	$totaldep = ($totaldep == "" ? "0.00" : $totaldep);
	$totalpur = $db->fetchOne("SELECT SUM(price) FROM order_history WHERE user_id=" . $r['id'] . " AND type!='purchase_balance'");
	$totalpur = ($totalpur == "" ? "0.00" : $totalpur);
	echo "    <tr>
        <td align=\"right\">Total deposits:</td>
        <td style=\"color:green\">";
	echo $totaldep;
	echo "</td>
        <td align=\"right\">Total purchases:</td>
        <td style=\"color:orange\">";
	echo $totalpur;
	echo "</td>
    </tr>
    <tr>
        <td align=\"right\">PTC Credits:</td>
        <td style=\"color:green\">";
	echo $r['ad_credits'];
	echo "</td>
        <td align=\"right\">PTSU Credits:</td>
        <td style=\"color:green\">";
	echo $r['ptsu_credits'];
	echo "</td>
    </tr>
    <tr>
        <td align=\"right\">Banner Credits:</td>
        <td style=\"color:green\">";
	echo $r['banner_credits'];
	echo "</td>
        <td align=\"right\">Featured Ad Credits:</td>
        <td style=\"color:green\">";
	echo $r['fads_credits'];
	echo "</td>
    </tr>
    <tr>
        <td align=\"right\">Featured Link Credits:</td>
        <td style=\"color:green\">";
	echo $r['flink_credits'];
	echo "</td>
        <td align=\"right\">Total Clicks:</td>
        <td style=\"color:#990000\">";
	echo $r['clicks'];
	echo "</td>
    </tr>
    <tr>
        <td align=\"right\">Referral Earnings:</td>
        <td style=\"color:#990000\">";
	echo $r['refearnings'];
	echo "</td>
        <td align=\"right\">Referral Clicks:</td>
        <td style=\"color:#990000\">";
	echo $r['refclicks'];
	echo "</td>
    </tr>
    <tr>
        <td align=\"right\">Points:</td>
        <td style=\"color:green\">";
	echo $r['points'];
	echo "</td>
        <td align=\"right\">PTSU Denied:</td>
        <td style=\"color:red\">";
	echo $r['ptsu_denied'];
	echo "</td>
    </tr>
    <tr>
        <td align=\"right\">Signup IP:</td>
        <td style=\"color:#FF9900\">";
	echo $r['signup_ip'];
	echo "</td>
        <td align=\"right\">Last IP:</td>
        <td style=\"color:#FF9900\">";
	echo $r['last_ip'];
	echo "</td>
    </tr>
    <tr>
        <td align=\"right\">Signup Date:</td>
        <td style=\"color:#000099\">";
	echo date("d M, Y h:i a", $r['signup']);
	echo "</td>
        <td align=\"right\">Last Login Date:</td>
        <td style=\"color:#000099\">";
	echo date("d M, Y h:i a", $r['last_login']);
	echo "</td>
    </tr>
     <tr>
        <td align=\"right\">Comes From:</td>
        <td colspan=\"3\" style=\"color:#000099\">";
	echo $r['comes_from'];
	echo "</td>
    </tr>
    <tr>
        <td align=\"right\">Admin Notes:</td>
        <td colspan=\"3\" style=\"color:#990033\">";
	echo $r['adminnotes'];
	echo "</td>
    </tr>
    <tr>
        <td colspan=\"2\" align=\"center\"><input type=\"button\" name=\"btn\" value=\"Send Mail\" onclick=\"location.href='./?view=massmail&member=";
	echo $r['username'];
	echo "';\" />
        </td>
        <td colspan=\"2\" align=\"center\"><input type=\"button\" name=\"btn\" value=\"Send Message\" onclick=\"location.href='./?view=massmessage&member=";
	echo $r['username'];
	echo "';\" />
        </td>
    </tr>
</table>
</div>
        </td>
    </tr>
    ";
}


if ($paginator->totalResults() == 0) {
	echo "    <tr>
    	<td colspan=\"10\" align=\"center\">Records not found</td>
    </tr>
    ";
}

echo "  </table>
    <div style=\"margin-top:10px\">
    <input type=\"button\" value=\"&larr; Prev Page\" ";
echo ($paginator->totalPages() == 1 || $paginator->getPage() == 1) ? "disabled class=\"btn-disabled\"" : "onclick=\"location.href='" . $paginator->prevpage() . "';\";";
echo " />

    <input type=\"button\" value=\"Next Page &rarr;\" ";
echo ($paginator->totalPages() == 0 || $paginator->totalPages() == $paginator->getPage()) ? "disabled class=\"btn-disabled\"" : "onclick=\"location.href='" . $paginator->nextpage() . "';\";";
echo " />
    	";

if (1 < $paginator->totalPages()) {
	echo "        <div style=\"float:right\">
        Jump to page:
        <select name=\"p\" style=\"min-width:inherit;\" id=\"pagid\" onchange=\"gotopage(this.value)\">
            ";
	$i = 1;

	while ($i <= $paginator->totalPages()) {
		if ($i == $paginator->getPage()) {
			echo "<option selected value=\"" . $paginator->gotopage($i) . "\">" . $i . "</option>";
		}
		else {
			echo "<option value=\"" . $paginator->gotopage($i) . "\">" . $i . "</option>";
		}

		++$i;
	}

	echo "        </select>
        <script type=\"text/javascript\">
			function gotopage(pageid){
				location.href=pageid;
			}
		</script>
        </div>
        <div class=\"clear\"></div>
        ";
}

echo "    </div>

	";

if (0 < $paginator->totalPages()) {
	echo "    <div class=\"widget-title\" style=\"margin-top:5px\">Action</div>
        <div class=\"widget-content\">
        	<select name=\"a\">
            	<option value=\"\">Select one</option>
            	<option value=\"suspend\">Suspend</option>
                <option value=\"unsuspend\">Unsuspend</option>
                <option value=\"activate\">Activate</option>
                <option value=\"delete\">Delete (irreversible)</option>
                <option value=\"unhook\">Unhook direct referrals</option>
                <option value=\"unhook2\">Unhook rented referrals</option>
            </select>
            <input type=\"submit\" name=\"action\" value=\"Submit\" />
        </div>
    ";
}

echo "    <input type=\"hidden\" name=\"sesion_id\" value=\"";
echo sesion_id();
echo "\" />
</form>
</div>
        ";
include SOURCES . "footer.php";
echo " ";
?>
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


if (!$admin->permissions['administrators']) {
	header("location: ./");
	exit();
}

$admin_permissions = array("statistics" => "Able to see Site Statistics", "manage_members" => "Able to manage members", "add_new_member" => "Able to add a new member", "send_mail" => "Able to send e-mails to members", "send_messages" => "Able to send on-site messages to members", "ptcads" => "Able to edit PTC settings", "ptcads_manager" => "Able to manage PTC Ads", "featuredads" => "Able to edit Featured Ads settings", "featuredads_manager" => "Able to manage Featured Ads", "featuredlinks" => "Able to edit Featured Link Ads settings", "featuredlinks_manager" => "Able to manage Featured Link Ads", "bannerads" => "Able to edit Banner Ads settings", "bannerads_manager" => "Able to manage Banner Ads", "loginads" => "Able to edit Login Ads settings", "loginads_manager" => "Able manage Login Ads", "ptsuoffers" => "Able to edit PTSU Offers settings", "ptsuoffers_manager" => "Able to manage PTSU Offers", "specialpacks" => "Able to manage Special Packs", "orders" => "Able to manage Orders", "deposits" => "Able to manage Deposits", "withdrawals" => "Able to manage Withdrawals", "support" => "Able to edit Support settings", "support_manager" => "Able to manage Support tickets", "site_content" => "Able to manage Site Content<br><span style=\"font-size:11px\">(News, site banners, terms, faq, etc)</span>", "utilities" => "Able to manage Utilities tab content", "setup" => "Able to manage Setup tab content", "administrators" => "Able to manage administrators");

if ($input->g['add'] == "newadmin") {
	include SOURCES . "new_administrator.php";
	exit();
}


if (is_numeric($input->g['edit'])) {
	$chk = $db->fetchOne("SELECT COUNT(*) AS NUM FROM admin WHERE id=" . $input->gc['edit']);

	if ($chk != 0) {
		include SOURCES . "edit_administrator.php";
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
					$list = $db->fetchRow("SELECT * FROM admin WHERE id=" . $mid);
					switch ($input->p['a']) {
						case "delete":
							if ($list['username'] == $admin->getUsername()) {
								$error_msg = "You can not delete your account.";
							}
							else {
								$db->delete("admin", "id=" . $mid);
							}
							break;

						case "disable":
							if ($list['username'] != $admin->getUsername()) {
								$data = array("status" => "disable");
								$db->update("admin", $data, "id=" . $mid);
							}
							break;

						case "enable":
							$data = array("status" => "enable");
							$db->update("admin", $data, "id=" . $mid);
							break;
					}
				}
			}
		}
	}
}


if ($input->r['do'] == "search") {
	$searchvars = array("username", "email", "last_login", "status");
	foreach ($searchvars as $k) {

		if ($input->r[$k]) {
			switch ($k) {
				case "last_login":
					$from_date = daterange($input->rc['last_login']);
					$cond .= "(last_login >= " . $from_date[0] . " AND last_login <= " . $from_date[1] . ") AND ";
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

$gat_q = $db->query("SELECT id, name FROM gateways");
$gateway = array();

while ($r = $db->fetch_array($gat_q)) {
	$gateway[$r['id']] = $r['name'];
}

$mem_q = $db->query("SELECT id, name FROM membership");
$membership = array();

while ($r = $db->fetch_array($mem_q)) {
	$membership[$r['id']] = $r['name'];
}

$paginator = new Pagination("admin", $cond);
$paginator->setOrders("id", "ASC");
$paginator->setPage($input->gc['page']);
$paginator->allowedfield($allowed);
$paginator->setNewOrders($input->gc['orderby'], $input->gc['sortby']);
$paginator->setLink("./?view=administrators&" . $adlink);
$q = $paginator->getQuery();
include SOURCES . "header.php";
echo "<div class=\"site_title\">Manage Administrators</div>

    <div class=\"site_content\">
        ";

if ($error_msg) {
	echo "        <div class=\"error_box\">";
	echo $error_msg;
	echo "</div>
        ";
}

echo "        <div class=\"ui-tabs ui-widget ui-widget-content ui-corner-all\">
           <ul class=\"ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all\">
             <li class=\"ui-state-default ui-corner-top ui-tabs-selected ui-state-active\"><a href=\"javascript:void(0);\" onclick=\"$('#search-content').slideToggle();\" style=\"cursor:pointer\">Search</a></li>
             <li class=\"ui-state-default ui-corner-top\"><a href=\"./?view=administrators&add=newadmin\" style=\"cursor:pointer\" class=\"ui-tabs-anchor\">Create a new administrator</a></li>
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
                            <td align=\"right\">E-mail:</td>
                            <td><input type=\"text\" name=\"email\" value=\"";
echo $input->r['email'];
echo "\" /></td>
                        </tr>
                        <tr>
                            <td align=\"right\">Last Login:</td>
                            <td><input type=\"text\" name=\"last_login\" value=\"";
echo $input->r['last_login'];
echo "\" class=\"datepicker\" /></td>
                            <td align=\"right\">Status</td>
                            <td><select name=\"status\">
                    <option value=\"\">All</option>
                    ";
$statusvalues = array("enable", "disable");
foreach ($statusvalues as $v) {

	if ($v == $input->r['status']) {
		echo "<option value='" . $v . "' selected>" . $v . "</option>";
		continue;
	}

	echo "<option value='" . $v . "'>" . $v . "</option>";
}

echo "                    </select>
                            </td>
                        </tr>
                        <tr>
                             <td colspan=\"4\" align=\"center\"><input type=\"submit\" name=\"send\" value=\"Search\"></td>
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
echo "</td>
                <td>";
echo $paginator->linkorder("email", "E-mail");
echo "</td>
                <td align=\"center\">";
echo $paginator->linkorder("last_login", "Las Login");
echo "</td>
                <td align=\"center\">";
echo $paginator->linkorder("status", "Status");
echo "</td>
                <td></td>
            </tr>
            ";

while ($r = $db->fetch_array($q)) {
	$tr = ($tr == "tr1" ? "tr2" : "tr1");
	echo "            <tr class=\"";
	echo $tr;
	echo " normal_linetbl\">
                <td align=\"center\"><input type=\"checkbox\" name=\"mid[]\" value=\"";
	echo $r['id'];
	echo "\" class=\"checkall\" /></td>
                <td>";
	echo $r['username'];
	echo "</td>
                <td>";
	echo $r['email'];
	echo "</td>
                <td align=\"center\">";
	echo date("d M Y h:i A", $r['last_login']);
	echo "</td>
                <td align=\"center\"><span style=\"color:
                ";
	switch ($r['status']) {
		case "enable":
			echo "#009900";
			break;

		case "disable":
			echo "#990000";
			break;

		default:
			echo "#996600";
			break;

	}

	echo "                \">";
	echo $r['status'];
	echo "</span></td>
        <td align=\"center\">
        <a href=\"./?view=administrators&edit=";
	echo $r['id'];
	echo "\"><img src=\"./css/images/edit.png\" title=\"Edit Administrator\" border=\"0\" /></a>

        <a href=\"javascript:void(0);\" onClick=\"openWindows('<span style=\'font-weight:normal\'>Member:</span> ";
	echo $member['username'];
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
	echo $member['fullname'];
	echo "</strong></td>
                <td align=\"right\" width=\"25%\">Country:</td>
                <td width=\"25%\" style=\"color:#000099\">";
	echo $member['country'];
	echo "</td>
            </tr>
            <tr>
                <td align=\"right\">Membership:</td>
                <td style=\"color:green\">";
	echo $membership[$member['type']];
	echo "</td>
                <td align=\"right\">Total withdrew:</td>
                <td style=\"color:#990000\">";
	echo $member['withdraw'];
	echo "</td>
            </tr>
            <tr>
                <td align=\"right\">Account balance:</td>
                <td style=\"color:orange\">";
	echo $member['money'];
	echo "</td>
                <td align=\"right\">Purchase balance:</td>
                <td style=\"color:green\">";
	echo $member['purchase_balance'];
	echo "</td>
            </tr>
            <tr>
                <td align=\"right\">Cashout Times:</td>
                <td style=\"color:green\">";
	echo $member['cashout_times'];
	echo "</td>
                <td align=\"right\">Total Clicks:</td>
                <td style=\"color:#990000\">";
	echo $member['clicks'];
	echo "</td>
            </tr>
            <tr>
                <td align=\"right\">Signup Date:</td>
                <td style=\"color:#000099\">";
	echo date("d M, Y h:i a", $member['signup']);
	echo "</td>
                <td align=\"right\">Last Login Date:</td>
                <td style=\"color:#000099\">";
	echo date("d M, Y h:i a", $member['last_login']);
	echo "</td>
            </tr>
            <tr>
                <td align=\"right\">Admin Notes:</td>
                <td colspan=\"3\" style=\"color:#990033\">";
	echo $member['adminnotes'];
	echo "</td>
            </tr>
        </table>
        </div>
                </td>
            </tr>
            ";
}


if ($paginator->totalResults() == 0) {
	echo "            <tr>
                <td colspan=\"8\" align=\"center\">Records not found</td>
            </tr>
            ";
}

echo "          </table>
            <div style=\"margin-top:10px\">
            <input type=\"button\" value=\"&larr; Prev Page\" ";
echo ($paginator->totalPages() == 1 || $paginator->getPage() == 1) ? "disabled class=\"btn-disabled\"" : "onclick=\"location.href='" . $paginator->prevpage() . "';\";";
echo " />

            <input type=\"button\" value=\"Next Page &rarr;\" ";
echo ($paginator->totalPages() == 0 || $paginator->totalPages() == $paginator->getPage()) ? "disabled class=\"btn-disabled\"" : "onclick=\"location.href='" . $paginator->nextpage() . "';\";";
echo " />
                ";

if (1 < $paginator->totalPages()) {
	echo "                <div style=\"float:right\">
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

	echo "                </select>
                <script type=\"text/javascript\">
                    function gotopage(pageid){
                        location.href=pageid;
                    }
                </script>
                </div>
                <div class=\"clear\"></div>
                ";
}

echo "            </div>

            ";

if (0 < $paginator->totalPages()) {
	echo "            <div class=\"widget-title\" style=\"margin-top:5px\">Action</div>
                <div class=\"widget-content\">
                    <select name=\"a\">
                        <option value=\"\">Select one</option>
                        <option value=\"delete\">Delete (irreversible)</option>
                        <option value=\"disable\">Disable</option>
                        <option value=\"enable\">Enable</option>
                    </select>
                    <input type=\"submit\" name=\"action\" value=\"Submit\" />
                </div>
            ";
}

echo "        <input type=\"hidden\" name=\"sesion_id\" value=\"";
echo sesion_id();
echo "\" />
        </form>
    </div>
        ";
include SOURCES . "footer.php";
echo " ";
?>
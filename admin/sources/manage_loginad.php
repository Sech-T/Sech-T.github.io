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


if (!$admin->permissions['loginads_manager']) {
	header("location: ./");
	exit();
}


if ($input->g['new_loginads']) {
	include SOURCES . "new_loginads.php";
	exit();
}


if (is_numeric($input->g['edit'])) {
	$chk = $db->fetchOne("SELECT COUNT(*) AS NUM FROM login_ads WHERE id=" . $input->gc['edit']);

	if ($chk != 0) {
		include SOURCES . "edit_loginad.php";
		exit();
	}
}


if ($input->p['action']) {
	if ($settings['demo'] == "yes") {
		header("location: ./?view=manageloginad&msg=this_is_demo");
		exit();
	}


	if (is_array($input->p['mid'])) {
		foreach ($input->p['mid'] as $mid) {
			switch ($input->p['a']) {
				case "delete":
					$db->delete("login_ads", "id=" . $mid);
					break;

				case "selfsponsored":
					$setupd = array("user_id" => "0");
					$db->update("login_ads", $setupd, "id=" . $mid);
					break;

				default:
					$setupd = array("status" => $input->p['a']);
					$db->update("login_ads", $setupd, "id=" . $mid);
					break;
			}
		}
	}
}


if ($input->r['do'] == "search") {
	$searchvars = array("owner", "username", "status", "url", "title", "expires");
	foreach ($searchvars as $k) {

		if ($input->r[$k]) {
			switch ($k) {
				case "owner":
					if ($input->rc[$k] == "selfsponsored") {
						$cond .= "user_id=0 AND ";
					}
					else {
						if ($input->rc[$k] == "single" && $input->rc['username'] != "") {
							$user_id = $db->fetchOne(("SELECT id FROM members WHERE username='" . $input->rc['username'] . "'"));
							$cond .= "user_id=" . $user_id . " AND ";
						}
					}
					break;

				case "username":
					break;

				case "url":
					$cond .= ("(") . $k . " LIKE '%" . $input->rc[$k] . "%') AND ";
					break;

				case "title":
					$cond .= ("(") . $k . " LIKE '%" . $input->rc[$k] . "%') AND ";
					break;

				case "expires":
					$expires = daterange($input->rc[$k]);
					$cond .= ("(") . $k . " >= " . $expires[0] . " AND " . $k . " <= " . $expires[1] . ") AND ";
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

$paginator = new Pagination("login_ads", $cond);
$paginator->setOrders("id", "DESC");
$paginator->setPage($input->gc['page']);
$paginator->allowedfield($allowed);
$paginator->setNewOrders($input->gc['orderby'], $input->gc['sortby']);
$paginator->setLink("./?view=manageloginad&" . $adlink);
$q = $paginator->getQuery();
include SOURCES . "header.php";
echo "<div class=\"site_title\">Manage Login Ads</div>
<div class=\"site_content\">

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
                    <td align=\"right\">Owner:</td>
                    <td>
                    <select name=\"owner\" onchange=\"selectowner();\" id=\"owner\">
                        <option value=\"\">all members</option>
                        <option value=\"single\" ";
echo $input->r['owner'] == "single" ? "selected" : "";
echo ">single member</option>
                        <option value=\"selfsponsored\" ";
echo $input->r['owner'] == "selfsponsored" ? "selected" : "";
echo ">self-sponsored</option>
                    </select>
                    <input type=\"text\" name=\"username\" value=\"";
echo $input->r['username'];
echo "\" id=\"username\" ";
echo $input->r['owner'] == "single" ? "" : "style=\"display:none\"";
echo " />
					</td>
                    <td align=\"right\">Status:</td>
                    <td>            <select name=\"status\">
            <option value=\"\">All</option>
            ";
$statusvalues = array("Active", "Inactive", "Pending", "Expired", "Paused");
foreach ($statusvalues as $v) {

	if ($v == $input->r['status']) {
		echo "<option value='" . $v . "' selected>" . $v . "</option>";
		continue;
	}

	echo "<option value='" . $v . "'>" . $v . "</option>";
}

echo "            </select>
                    </td>
                </tr>
                <tr>
                    <td align=\"right\">Ad Title:</td>
                    <td><input type=\"text\" name=\"title\" value=\"";
echo $input->r['title'];
echo "\" /></td>
                    <td align=\"right\">URL:</td>
                    <td><input type=\"text\" name=\"url\" value=\"";
echo $input->r['url'];
echo "\" /></td>
                </tr>
                <tr>
                    <td align=\"right\">Expires:</td>
                    <td colspan=\"3\"><input type=\"text\" name=\"expires\" value=\"";
echo $input->r['expires'];
echo "\" class=\"datepicker\" /></td>
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
echo $paginator->linkorder("user_id", "Owner");
echo "</td>
        <td align=\"center\">";
echo $paginator->linkorder("title", "Ad");
echo " / ";
echo $paginator->linkorder("url", "URL");
echo "</td>
        <td align=\"center\">";
echo $paginator->linkorder("views", "Views");
echo " / ";
echo $paginator->linkorder("clicks", "Clicks");
echo "</td>
        <td align=\"center\">";
echo $paginator->linkorder("expires", "Expires");
echo "</td>
        <td align=\"center\">";
echo $paginator->linkorder("status", "Status");
echo "</td>
        <td></td>
    </tr>
    ";

while ($r = $db->fetch_array($q)) {
	$tr = ($tr == "tr1" ? "tr2" : "tr1");
	$username = ($r['user_id'] == 0 ? "<span style=\"color:green\">Administrator</span>" : "<a href=\"./?view=members&edit=" . $r['user_id'] . "\">" . $db->fetchOne("SELECT username FROM members WHERE id=" . $r['user_id']) . "</a>");
	echo "  	<tr class=\"";
	echo $tr;
	echo " normal_linetbl\">
    	<td align=\"center\"><input type=\"checkbox\" name=\"mid[]\" value=\"";
	echo $r['id'];
	echo "\" class=\"checkall\" /></td>
        <td>";
	echo $username;
	echo "</td>
        <td>";

	if (35 < strlen($r['title'])) {
		echo mb_substr($r['title'], 0, 35) . "...";
	}
	else {
		echo $r['title'];
	}

	echo "<br><span style=\"font-size:11px\">
        <a href=\"";
	echo $r['url'];
	echo "\" target=\"_blank\" style=\"color:#CC66CC\">
		";

	if (35 < strlen($r['url'])) {
		echo substr($r['url'], 0, 35) . "...";
	}
	else {
		echo $r['url'];
	}

	echo "        </a>
		</span></td>
        <td align=\"center\">
			<span style=\"color:green\">";
	echo $r['views'];
	echo "</span> / <span style=\"color:#990000\">";
	echo $r['clicks'];
	echo "</span>
        </td>
        <td align=\"center\">
			<span style=\"color:#000099\">";
	echo date("dS M, Y", $r['expires']);
	echo "</span>
        </td>
        <td align=\"center\"><span style=\"color:
        ";
	switch ($r['status']) {
		case "Active":
			echo "#009900";
			break;

		case "Inactive":
			echo "orange";
			break;

		case "Expired":
			echo "#990000";
			break;

		default:
			echo "#996600";
			break;
	}

	echo "        \">";
	echo $r['status'];
	echo "</span></td>
        <td align=\"center\"><a href=\"./?view=manageloginad&edit=";
	echo $r['id'];
	echo "\"><img src=\"./css/images/edit.png\" border=\"0\" title=\"Edit Login Ad\" /></a>
        </td>
    </tr>
    ";
}


if ($paginator->totalResults() == 0) {
	echo "    <tr>
    	<td colspan=\"8\" align=\"center\">Records not found</td>
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
                <option value=\"delete\">Delete (irreversible)</option>
                <option value=\"Active\">Set Active</option>
                <option value=\"Inactive\">Set Inactive</option>
                <option value=\"Expired\">Set Expired</option>
                <option value=\"Paused\">Set Paused</option>
                <option value=\"selfsponsored\">Set Self-sponsored</option>
            </select>
            <input type=\"submit\" name=\"action\" value=\"Submit\" />
        </div>
    ";
}

echo "</form>
</div>
        ";
include SOURCES . "footer.php";
echo " ";
?>
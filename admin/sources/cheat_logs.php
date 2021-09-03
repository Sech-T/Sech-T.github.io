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


if (!$admin->permissions['utilities']) {
	header("location: ./");
	exit();
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
						case "delete":
							$db->delete("cheat_log", "id=" . $mid);
					}
				}
			}
		}
	}
}


if ($input->r['do'] == "search") {
	$searchvars = array("username", "type");
	foreach ($searchvars as $k) {

		if ($input->r[$k]) {
			switch ($k) {
				case "username":
					$userid = $db->fetchOne("SELECT id FROM members WHERE username='" . $db->real_escape_string($input->rc[$k]) . "'");
					$cond .= "user_id='" . $userid . "' OR (log LIKE '%" . $input->rc[$k] . "%') AND ";
					break;

				default:
					$cond .= $k . "='" . $db->real_escape_string($input->rc[$k]) . "' AND ";
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

$typelogs = array(1 => "Critical", 2 => "Medium", 3 => "Low");
$paginator = new Pagination("cheat_log", $cond);
$paginator->setOrders("date", "DESC");
$paginator->setPage($input->gc['page']);
$paginator->allowedfield($allowed);
$paginator->setNewOrders($input->gc['orderby'], $input->gc['sortby']);
$paginator->setLink("./?view=cheat_logs&" . $adlink);
$q = $paginator->getQuery();
$typecolor = array(1 => "#d20000", 2 => "#ff8000");
include SOURCES . "header.php";
echo "<div class=\"site_title\">Cheat Logs</div>
<div class=\"site_content\">

		";

if ($error_msg) {
	echo "        <div class=\"error_box\">";
	echo $error_msg;
	echo "</div>
        ";
}

echo "<div class=\"ui-tabs ui-widget ui-widget-content ui-corner-all\">
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
                    <td align=\"right\">Type:</td>
                    <td><select name=\"type\">
                    <option value=\"\">All</option>
                    ";
foreach ($typelogs as $k => $v) {

	if ($input->r['type'] == $k) {
		echo "<option value=\"" . $k . "\" selected>" . $v . "</option>";
		continue;
	}

	echo "<option value=\"" . $k . "\">" . $v . "</option>";
}

echo "
                    </select>
                    </td>
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
                <input type=\"hidden\" name=\"sesion_id\" value=\"";
echo sesion_id();
echo "\" />
                  <table width=\"100%\" class=\"widget-tbl\">
                    <tr class=\"titles\">
                        <td width=\"20\"><input type=\"checkbox\" id=\"checkall\"></td>
                        <td>";
echo $paginator->linkorder("date", "Date");
echo "</td>
                        <td>";
echo $paginator->linkorder("type", "Type");
echo "</td>
                        <td>";
echo $paginator->linkorder("user_id", "Username");
echo "</td>
                        <td>";
echo $paginator->linkorder("log", "Log");
echo "</td>
                    </tr>
                    ";

while ($r = $db->fetch_array($q)) {
	$tr = ($tr == "tr1" ? "tr2" : "tr1");
	$username = $db->fetchOne("SELECT username FROM members WHERE id=" . $r['user_id']);
	echo "                    <tr class=\"";
	echo $tr;
	echo " normal_linetbl\">
                        <td align=\"center\"><input type=\"checkbox\" name=\"mid[]\" value=\"";
	echo $r['id'];
	echo "\" class=\"checkall\" /></td>
                        <td>";
	echo date("dS M, Y", $r['date']);
	echo "</td>
                        <td><span style=\"color:";
	echo $typecolor[$r['type']];
	echo "\">";

	if ($r['type'] == 1) {
		echo "Critical";
	}
	else {
		if ($r['type'] == 2) {
			echo "Medium";
		}
		else {
			echo $typelogs[$r['type']];
		}
	}

	echo "</span>
                        </td>
                        <td>
                            <span style=\"color:green\">";
	echo $username;
	echo "</span>
                        </td>
                        <td><span style=\"color:";
	echo $typecolor[$r['type']];
	echo "\">";
	echo $r['log'];
	echo "</span></td>
                    </tr>
                    ";
}


if ($paginator->totalResults() == 0) {
	echo "                    <tr>
                        <td colspan=\"8\" align=\"center\">Records not found</td>
                    </tr>
                    ";
}

echo "                  </table>
                    <div style=\"margin-top:10px\">
                    <input type=\"button\" value=\"&larr; Prev Page\" ";
echo ($paginator->totalPages() == 1 || $paginator->getPage() == 1) ? "disabled class=\"btn-disabled\"" : "onclick=\"location.href='" . $paginator->prevpage() . "';\";";
echo " />

                    <input type=\"button\" value=\"Next Page &rarr;\" ";
echo ($paginator->totalPages() == 0 || $paginator->totalPages() == $paginator->getPage()) ? "disabled class=\"btn-disabled\"" : "onclick=\"location.href='" . $paginator->nextpage() . "';\";";
echo " />
                        ";

if (1 < $paginator->totalPages()) {
	echo "                        <div style=\"float:right\">
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

	echo "                        </select>
                        <script type=\"text/javascript\">
                            function gotopage(pageid){
                                location.href=pageid;
                            }
                        </script>
                        </div>
                        <div class=\"clear\"></div>
                        ";
}

echo "                    </div>

                    ";

if (0 < $paginator->totalPages()) {
	echo "                    <div class=\"widget-title\" style=\"margin-top:5px\">Action</div>
                        <div class=\"widget-content\">
                            <select name=\"a\">
                                <option value=\"\">Select one</option>
                                <option value=\"delete\">Delete</option>
                            </select>
                            <input type=\"submit\" name=\"action\" value=\"Submit\" />
                        </div>
                    ";
}

echo "                </form>

</div>
";
include SOURCES . "footer.php";
echo " ";
?>
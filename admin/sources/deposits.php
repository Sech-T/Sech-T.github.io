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


if (!$admin->permissions['deposits']) {
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
							$db->delete("deposit_history", "id=" . $mid);
					}
				}
			}
		}
	}
}


if ($input->r['do'] == "search") {
	$searchvars = array("username", "fromacc", "method", "batch", "from_date", "to_date");
	foreach ($searchvars as $k) {

		if ($input->r[$k]) {
			switch ($k) {
				case "username":
					$user_id = $db->fetchOne(("SELECT id FROM members WHERE username='" . $input->rc['username'] . "'"));
					$cond .= "user_id=" . $user_id . " AND ";
					break;

				case "from_date":
					$from_date = daterange($input->rc['from_date']);
					$cond .= "date >= " . $from_date[0] . " AND ";
					break;

				case "to_date":
					$to_date = daterange($input->rc['to_date']);
					$cond .= "date <= " . $to_date[1] . " AND ";
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

$paginator = new Pagination("deposit_history", $cond);
$paginator->setOrders("date", "DESC");
$paginator->setPage($input->gc['page']);
$paginator->allowedfield($allowed);
$paginator->setNewOrders($input->gc['orderby'], $input->gc['sortby']);
$paginator->setLink("./?view=deposits&" . $adlink);
$q = $paginator->getQuery();
include SOURCES . "header.php";
echo "    <script>
    $(function() {
        $(\"#from_date\").datepicker({
            defaultDate: \"+1w\",
            numberOfMonths: 1,
            onClose: function(selectedDate) {
                $(\"#to_date\").datepicker(\"option\", \"minDate\", selectedDate);
            }
        });
        $(\"#to_date\").datepicker({
            defaultDate: \"+1w\",
            numberOfMonths: 1,
            onClose: function(selectedDate) {
                $(\"#from_date\").datepicker(\"option\", \"maxDate\", selectedDate);
            }
        });
    });
    </script>
<div class=\"site_title\">Manage Deposits</div>
<div class=\"site_content\">

";

if ($error_msg) {
	echo "<div class=\"error_box\">";
	echo $error_msg;
	echo "</div>
";
}

echo "<div class=\"widget-content\">

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
                    <td align=\"right\">Member:</td>
                    <td>
                    <input type=\"text\" name=\"username\" value=\"";
echo $input->r['username'];
echo "\" />
					</td>
                    <td align=\"right\">Account:</td>
                    <td><input type=\"text\" name=\"fromacc\" value=\"";
echo $input->r['fromacc'];
echo "\" /></td>
                </tr>
                <tr>
                    <td align=\"right\">Method</td>
                    <td><select name=\"method\">
                    	<option value=\"\">All</option>
						";
foreach ($gateway as $k => $v) {

	if ($input->r['method'] == $k) {
		echo "<option value=\"" . $k . "\" selected>" . $v . "</option>";
		continue;
	}

	echo "<option value=\"" . $k . "\">" . $v . "</option>";
}

echo "                    </select>
                    </td>
                    <td align=\"right\">Payment ID:</td>
                    <td><input type=\"text\" name=\"batch\" value=\"";
echo $input->r['batch'];
echo "\" /></td>
                </tr>
                <tr>
                    <td align=\"right\">From:</td>
                    <td><input type=\"text\" name=\"from_date\" id=\"from_date\" value=\"";
echo $input->r['from_date'];
echo "\" /></td>
                    <td align=\"right\">To:</td>
                    <td><input type=\"text\" name=\"to_date\" id=\"to_date\" value=\"";
echo $input->r['to_date'];
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
echo $paginator->linkorder("date", "Date");
echo "</td>
        <td>";
echo $paginator->linkorder("user_id", "Member");
echo "</td>
        <td align=\"center\">";
echo $paginator->linkorder("amount", "Amount");
echo "</td>
        <td align=\"center\">";
echo $paginator->linkorder("method", "Method");
echo "</td>
        <td align=\"center\">";
echo $paginator->linkorder("fromacc", "Account");
echo "</td>
        <td align=\"center\">";
echo $paginator->linkorder("batch", "Payment ID");
echo "</td>
    </tr>
    ";

while ($r = $db->fetch_array($q)) {
	$tr = ($tr == "tr1" ? "tr2" : "tr1");
	$username = "<a href=\"./?view=members&edit=" . $r['user_id'] . "\">" . $db->fetchOne("SELECT username FROM members WHERE id=" . $r['user_id']) . "</a>";
	echo "  	<tr class=\"";
	echo $tr;
	echo " normal_linetbl\">
    	<td align=\"center\"><input type=\"checkbox\" name=\"mid[]\" value=\"";
	echo $r['id'];
	echo "\" class=\"checkall\" /></td>
        <td>";
	echo date("dS M, Y", $r['date']);
	echo "</td>
        <td>";
	echo $username;
	echo "</td>
        <td align=\"center\">
			<span style=\"color:green\">";
	echo $r['amount'];
	echo "</span>
        </td>
        <td align=\"center\">
        <img src=\"../images/proofs/";
	echo $r['method'];
	echo ".gif\">
        </td>
        <td align=\"center\">
        ";
	echo $r['fromacc'];
	echo "        </td>
        <td align=\"center\"><span style=\"color:#996600;\">";
	echo $r['batch'];
	echo "</span></td>
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
                <option value=\"delete\">Delete</option>
            </select>
            <input type=\"submit\" name=\"action\" value=\"Submit\" />
        </div>
    ";
}

echo "<input type=\"hidden\" name=\"sesion_id\" value=\"";
echo sesion_id();
echo "\" />
</form>
</div>


</div>
        ";
include SOURCES . "footer.php";
echo " ";
?>
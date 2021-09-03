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


if ($input->p['do'] == "create") {
	verifyajax();
	verifydemo();

	if (empty($input->p['descr'])) {
		serveranswer(0, "Enter the tracker name");
	}


	if (empty($input->p['name'])) {
		serveranswer(0, "Enter the tracker url");
	}


	if (!ctype_alnum($input->p['name'])) {
		serveranswer(0, "The tracker url must be alphanumeric.");
	}

	$data = array("date" => TIMENOW, "name" => $input->pc['name'], "descr" => $input->pc['descr']);
	$db->insert("linktracker", $data);
	serveranswer(4, "location.href='./?view=linktracker';");
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
							$db->delete("linktracker", "id=" . $mid);
					}
				}
			}
		}
	}
}

$paginator = new Pagination("linktracker", $cond);
$paginator->setOrders("date", "DESC");
$paginator->setPage($input->gc['page']);
$paginator->allowedfield($allowed);
$paginator->setNewOrders($input->gc['orderby'], $input->gc['sortby']);
$paginator->setLink("./?view=linktracker&" . $adlink);
$q = $paginator->getQuery();
include SOURCES . "header.php";
echo "<div class=\"site_title\">Campaign Tracker</div>
<div class=\"site_content\">
<div id=\"tabs\">
	<ul>
    	<li><a href=\"#tabs-1\">Manage Campaigns</a></li>
        <li><a href=\"#tabs-2\">Add New Campaign</a></li>
    </ul>
    <div id=\"tabs-1\">
		";

if ($error_msg) {
	echo "        <div class=\"error_box\">";
	echo $error_msg;
	echo "</div>
        ";
}

echo "
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
echo $paginator->linkorder("date", "Date added");
echo "</td>
                        <td>";
echo $paginator->linkorder("descr", "Name");
echo "</td>
                        <td>";
echo $paginator->linkorder("name", "URL");
echo "</td>
                        <td align=\"center\">";
echo $paginator->linkorder("hits", "Total hits");
echo "</td>
                        <td align=\"center\">";
echo $paginator->linkorder("uniquehits", "Unique hits");
echo "</td>
                        <td align=\"center\">";
echo $paginator->linkorder("signups", "Total Signups");
echo "</td>
                    </tr>
                    ";

while ($r = $db->fetch_array($q)) {
	$tr = ($tr == "tr1" ? "tr2" : "tr1");
	echo "                    <tr class=\"";
	echo $tr;
	echo " normal_linetbl\">
                        <td align=\"center\"><input type=\"checkbox\" name=\"mid[]\" value=\"";
	echo $r['id'];
	echo "\" class=\"checkall\" /></td>
                        <td>";
	echo date("dS M, Y", $r['date']);
	echo "</td>
                        <td><span style=\"color:#000099\">";
	echo $r['descr'];
	echo "</span>
                        </td>
                        <td>
                            <span style=\"color:green\">";
	echo $settings['site_url'] . "?track=" . $r['name'];
	echo "</span>
                        </td>
                        <td align=\"center\"><span style=\"color:orange\">";
	echo $r['hits'];
	echo "</span></td>
                        <td align=\"center\"><span style=\"color:#000099\">";
	echo $r['uniquehits'];
	echo "</span></td>
                        <td align=\"center\"><span style=\"color:#990000\">";
	echo $r['signups'];
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
    <div id=\"tabs-2\">
    	<div class=\"info_box\">Campaign Tracker helps you to see where your traffic comes from</div>
    <form method=\"post\" id=\"addnewcamp\" onsubmit=\"return submitform(this.id);\">
    <input type=\"hidden\" name=\"do\" value=\"create\" />
    <table width=\"100%\" class=\"widget-tbl\">
      <tr>
        <td width=\"200\" align=\"right\">Tracker Name:</td>
        <td><input type=\"text\" name=\"descr\" /></td>
      </tr>
      <tr>
        <td width=\"300\" align=\"right\">Tracker URL:</td>
        <td>";
echo $settings['site_url'];
echo "?track=<input type=\"text\" name=\"name\" /></td>
      </tr>
      <tr>
      <td></td>
      <td>
        <input type=\"submit\" name=\"save\" value=\"Add Tracker\" />
      </td>
      </tr>
    </table>
    </form>
    </div>
</div>

</div>
";
include SOURCES . "footer.php";
echo " ";
?>
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


if ($input->p['do'] == "update") {
	$topdomains = $input->pc['topdomains'];
	$upd = $db->query("UPDATE settings SET value='" . $topdomains . "' WHERE field='topdomains'");
	$cache->delete("settings");
	serveranswer(1, "Settings were updated.");
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
							$db->delete("topdomains", "id=" . $mid);
					}
				}
			}
		}
	}
}

$paginator = new Pagination("topdomains", $cond);
$paginator->setOrders("hits", "DESC");
$paginator->setPage($input->gc['page']);
$paginator->allowedfield($allowed);
$paginator->setNewOrders($input->gc['orderby'], $input->gc['sortby']);
$paginator->setLink("./?view=topdomains&" . $adlink);
$q = $paginator->getQuery();
include SOURCES . "header.php";
echo "<div class=\"site_title\">Top Domains</div>
<div class=\"site_content\">
<div id=\"tabs\">
	<ul>
    	<li><a href=\"#tabs-1\">Manage Top Domains</a></li>
        <li><a href=\"#tabs-2\">Settings</a></li>
    </ul>
    <div id=\"tabs-1\">
		";

if ($error_msg) {
	echo "        <div class=\"error_box\">";
	echo $error_msg;
	echo "</div>
        ";
}

echo "		<form method=\"post\" action=\"";
echo $paginator->gotopage();
echo "\">
                <input type=\"hidden\" name=\"sesion_id\" value=\"";
echo sesion_id();
echo "\" />
                  <table width=\"100%\" class=\"widget-tbl\">
                    <tr class=\"titles\">
                        <td width=\"20\"><input type=\"checkbox\" id=\"checkall\"></td>
                        <td>";
echo $paginator->linkorder("domain", "Domain");
echo "</td>
                        <td align=\"center\">";
echo $paginator->linkorder("hits", "Hits");
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

                        <td><span style=\"color:#000099\">";
	echo $r['domain'];
	echo "</span></td>
                        <td align=\"center\"><span style=\"color:orange\">";
	echo $r['hits'];
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
    	<div class=\"info_box\">This tool lets you know where the visits come from.<br />If you have too much visits per day, it's recomendable to disable to save mysql resources. <br />You can use <a href=\"./?view=googleanalytics\">google analytics</a> as other option </div>
        <form method=\"post\" id=\"settingsdom\" onsubmit=\"return submitform(this.id);\">
        <input type=\"hidden\" name=\"do\" value=\"update\" />
        <table class=\"widget-tbl\" width=\"100%\">
        <tr>
            <td align=\"right\">Enable?:</td>
            <td><input type=\"checkbox\" name=\"topdomains\" value=\"yes\" ";

if ($settings['topdomains'] == "yes") {
	echo "checked";
}

echo " /> Tick to enable - This tool will be executed in every visit.</td>
        </tr>
        <tr>
        	<td></td>
            <td>
            <input type=\"submit\" name=\"send\" value=\"Save\" /></td>
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
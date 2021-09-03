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


if (!$admin->permissions['setup']) {
	header("location: ./");
	exit();
}

$auto_buyrefs = $db->fetchOne("SELECT autoassign FROM buyoptions WHERE name='referrals'");

if ($input->p['do'] == "update_settings") {
	verifyajax();
	verifydemo();
	$db->query("UPDATE buyoptions SET autoassign='" . $input->pc['auto_buyrefs'] . "' WHERE name='referrals'");

	if ($input->p['buy_referrals'] == "yes") {
		$data = array("value" => "yes");
		$data2 = array("enable" => "yes");
	}
	else {
		$data = array("value" => "no");
		$data2 = array("enable" => "no");
	}

	$upd = $db->update("settings", $data, "field='buy_referrals'");
	$upd = $db->update("buyoptions", $data2, "name='referrals'");
	$db->query("UPDATE settings SET value='" . $input->pc['buyref_filter'] . "' WHERE field='buyref_filter'");
	$db->query("UPDATE settings SET value='" . $input->pc['buyref_clicks'] . "' WHERE field='buyref_clicks'");
	$db->query("UPDATE settings SET value='" . $input->pc['buyref_days'] . "' WHERE field='buyref_days'");
	$cache->delete("settings");
	serveranswer(1, "Settings were updated.");
}
else {
	if ($input->p['do'] == "new_pack") {
		if ($settings['demo'] == "yes") {
			$error_msg = "This is not possible in demo version";
		}
		else {
			if ($input->p['sesion_id'] != $_SESSION['sesion_id']) {
				$error_msg = "Invalid token try again please";
			}
			else {
				if (!is_numeric($input->p['credits']) || !is_numeric($input->p['price'])) {
					$error_msg = "Some fields are incorrect.";
				}
				else {
					$set = array("refs" => $input->p['credits'], "price" => $input->p['price']);
					$db->insert("referral_price", $set);
					$success_msg = "New Pack was added.";
				}
			}
		}
	}
	else {
		if ($input->p['do'] == "update_pack") {
			verifyajax();
			verifydemo();
			$id = $input->pc['packid'];

			if (!is_numeric($input->p['refs'][$id]) || !is_numeric($input->p['price'][$id])) {
				serveranswer(0, "Some fields are incorrect.");
			}

			$set = array("refs" => $input->p['refs'][$id], "price" => $input->p['price'][$id]);
			$db->update("referral_price", $set, "id=" . $id);
			serveranswer(1, "Pack was updated.");
		}
		else {
			if ($input->p['do'] == "delete_pack") {
				verifyajax();
				verifydemo();
				$id = $input->pc['packid'];
				$db->delete("referral_price", "id=" . $id);
				serveranswer(6, "$(\"#tr_" . $id . "\").remove();");
			}
		}
	}
}

$paginator = new Pagination("referral_price", $cond);
$paginator->setOrders("refs", "ASC");
$paginator->setPage($input->gc['page']);
$paginator->allowedfield($allowed);
$paginator->setNewOrders($input->gc['orderby'], $input->gc['sortby']);
$paginator->setLink("./?view=buy_referrals&" . $adlink);
$q = $paginator->getQuery();
include SOURCES . "header.php";
echo "<div class=\"site_title\">Buy Referrals</div>
<div class=\"site_content\">
<div id=\"tabs\">
	<ul>
    	<li><a href=\"#tab-1\">Manage Packages</a></li>
    	<li><a href=\"#tab-2\">Settings</a></li>
    </ul>
<div id=\"tab-1\">
    	<div class=\"widget-title\">Add New Package</div>
        <div class=\"widget-content\">
		";

if ($error_msg) {
	echo "        <div class=\"error_box\">";
	echo $error_msg;
	echo "</div>
        ";
}

echo "		";

if ($success_msg) {
	echo "        <div class=\"success_box\">";
	echo $success_msg;
	echo "</div>
        ";
}

echo "        <form method=\"post\" action=\"./?view=buy_referrals\">
        <input type=\"hidden\" name=\"sesion_id\" value=\"";
echo sesion_id();
echo "\" />
        <input type=\"hidden\" name=\"do\" value=\"new_pack\" />
            <table class=\"widget-tbl\" width=\"100%\">
              <tr>
                <td align=\"right\" width=\"100\">
            Referrals:
            	</td>
                <td>
            <input type=\"text\" name=\"credits\" value=\"0\" />
            	</td>
                <td align=\"right\" width=\"100\">
            Price:
            	</td>
                <td>
            <input type=\"text\" name=\"price\" value=\"0.00\" />
            <input type=\"submit\" name=\"btn\" value=\"Add\" class=\"orange\" />
            </td>
            </tr>
            </table>
    	</form>
        </div>

        <div class=\"widget-title\">Manage</div>
        <form method=\"post\" id=\"frmlist\" onsubmit=\"return submitform(this.id);\">

          <table width=\"100%\" class=\"widget-tbl\">
            <tr class=\"titles\">
                <td align=\"center\">";
echo $paginator->linkorder("refs", "Referrals");
echo "</td>
                <td align=\"center\">";
echo $paginator->linkorder("price", "Price");
echo "</td>
                <td></td>
            </tr>
            ";

while ($r = $db->fetch_array($q)) {
	$tr = ($tr == "tr1" ? "tr2" : "tr1");
	echo "            <tr class=\"";
	echo $tr;
	echo " normal_linetbl\" id=\"tr_";
	echo $r['id'];
	echo "\">
                <td align=\"center\">
                <input type=\"text\" name=\"refs[";
	echo $r['id'];
	echo "]\" value=\"";
	echo $r['refs'];
	echo "\" />
                </td>
                <td align=\"center\">
                	 <input type=\"text\" name=\"price[";
	echo $r['id'];
	echo "]\" value=\"";
	echo $r['price'];
	echo "\" />
                </td>
                <td align=\"center\">
                <input type=\"submit\" name=\"btn\" value=\"Save\" onclick=\"updfrmvars({'do_action': 'update_pack', 'packid': '";
	echo $r['id'];
	echo "'});\" />
                <input type=\"submit\" name=\"btn\" value=\"Delete\" onclick=\"updfrmvars({'do_action': 'delete_pack', 'packid': '";
	echo $r['id'];
	echo "'});\" />
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
          <input type=\"hidden\" name=\"do\" value=\"\" id=\"do_action\" />
          <input type=\"hidden\" name=\"packid\" value=\"\" id=\"packid\" />

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

        </form>
    </div>
    <div id=\"tab-2\">
    	<script type=\"text/javascript\">
		function chkref_filter(val){
			if(val == 'enable'){
				$(\"#ref_filter\").show();
			}else{
				$(\"#ref_filter\").hide();
			}
		}
		</script>
        <form method=\"post\" id=\"frm1\" onsubmit=\"return submitform(this.id);\">
        <input type=\"hidden\" name=\"do\" value=\"update_settings\" />
        <table class=\"widget-tbl\" width=\"100%\">
          <tr>
            <td align=\"right\" width=\"300\">Auto-Assign referrals after member purchases</td>
            <td><input type=\"checkbox\" name=\"auto_buyrefs\" id=\"auto_buyrefs\" value=\"yes\" ";

if ($auto_buyrefs) {
	echo "checked";
}

echo " /></td>
          </tr>
          <tr>
            <td align=\"right\">Buy referrals enabled?</td>
            <td><input type=\"checkbox\" name=\"buy_referrals\" id=\"buy_referrals\" value=\"yes\" ";

if ($settings['buy_referrals'] == "yes") {
	echo "checked";
}

echo " /></td>
          </tr>
          <tr>
          	<td align=\"right\">Referral filter?</td>
            <td><select name=\"buyref_filter\" onchange=\"chkref_filter(this.value);\"><option value=\"disable\">Disable</option><option value=\"enable\" ";
echo $settings['buyref_filter'] == "enable" ? "selected" : "";
echo ">Enable</option></select></td>
          </tr>
          <tr style=\"";
echo $settings['buyref_filter'] == "enable" ? "" : "display:none";
echo "\" id=\"ref_filter\">
            <td colspan=\"2\" align=\"center\">Sell referrals that make at least <input type=\"text\" name=\"buyref_clicks\" value=\"";
echo $settings['buyref_clicks'];
echo "\" class=\"default\" size=\"5\" /> clicks in the last <select name=\"buyref_days\" class=\"default\">
            <option ";
echo $settings['buyref_days'] == 1 ? "selected" : "";
echo ">1</option>
            <option ";
echo $settings['buyref_days'] == 2 ? "selected" : "";
echo ">2</option>
            <option ";
echo $settings['buyref_days'] == 3 ? "selected" : "";
echo ">3</option>
            <option ";
echo $settings['buyref_days'] == 4 ? "selected" : "";
echo ">4</option>
            <option ";
echo $settings['buyref_days'] == 5 ? "selected" : "";
echo ">5</option>
            <option ";
echo $settings['buyref_days'] == 6 ? "selected" : "";
echo ">6</option>
            <option ";
echo $settings['buyref_days'] == 7 ? "selected" : "";
echo ">7</option>
            </select> days</td>
          </tr>
          <tr>
          	<td></td>
            <td>
                <input type=\"submit\" name=\"btn\" value=\"Save\" />
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
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


if (is_numeric($input->g['edit'])) {
	$chk = $db->fetchOne("SELECT COUNT(*) AS NUM FROM membership WHERE id=" . $input->gc['edit']);

	if ($chk != 0) {
		include SOURCES . "edit_membership.php";
		exit();
	}
}

$auto_upgrade = $db->fetchOne("SELECT autoassign FROM buyoptions WHERE name='membership'");

if ($input->p['do'] == "update_settings") {
	verifyajax();
	verifydemo();
	$db->query("UPDATE buyoptions SET autoassign='" . $input->pc['auto_upgrade'] . "' WHERE name='membership'");
	$set = array("ref_deletion" => $input->pc['ref_deletion']);
	foreach ($set as $field => $value) {
		$db->query(("UPDATE settings SET value='" . $value . "' WHERE field='" . $field . "'"));
	}

	$cache->delete("settings");
	serveranswer(1, "Settings were updated.");
}
else {
	if ($input->p['do'] == "new_membership") {
		verifyajax();
		verifydemo();
		$set = array("name" => $input->pc['name'], "price" => $input->pc['price'], "click" => $input->pc['click'], "ref_click" => $input->pc['ref_click'], "minimum_payout" => $input->pc['minimum_payout'], "ref_upgrade" => $input->pc['ref_upgrade'], "ref_purchase" => $input->pc['ref_purchase'], "directref_limit" => $input->pc['directref_limit'], "duration" => $input->pc['duration'], "rentedref_limit" => $input->pc['rentedref_limit'], "recycle_cost" => $input->pc['recycle_cost'], "rent_time" => $input->pc['rent_time'], "rent_pack" => $input->pc['rent_pack'], "cashout_time" => $input->pc['cashout_time'], "referral_deletion" => $input->pc['referral_deletion'], "active" => $input->pc['active'], "instant_withdrawal" => $input->pc['instant_withdrawal'], "max_clicks" => $input->pc['max_clicks'], "max_withdraw" => $input->pc['max_withdraw'], "rent250" => $input->pc['rent250'], "rent500" => $input->pc['rent500'], "rent750" => $input->pc['rent750'], "rent1000" => $input->pc['rent1000'], "rent1250" => $input->pc['rent1250'], "rent1500" => $input->pc['rent1500'], "rent1750" => $input->pc['rent1750'], "rentover" => $input->pc['rentover'], "autopay250" => $input->pc['autopay250'], "autopay500" => $input->pc['autopay500'], "autopay750" => $input->pc['autopay750'], "autopay1000" => $input->pc['autopay1000'], "autopay1250" => $input->pc['autopay1250'], "autopay1500" => $input->pc['autopay1500'], "autopay1750" => $input->pc['autopay1750'], "autopayover" => $input->pc['autopayover'], "point_enable" => $input->pc['point_enable'], "point_ref" => $input->pc['point_ref'], "point_ptc" => $input->pc['point_ptc'], "point_post" => $input->pc['point_post'], "point_ptsu" => $input->pc['point_ptsu'], "point_deposit" => $input->pc['point_deposit'], "point_upgrade" => $input->pc['point_upgrade'], "point_upgraderate" => $input->pc['point_upgraderate'], "point_purchasebalance" => $input->pc['point_purchasebalance'], "point_cashrate" => $input->pc['point_cashrate']);
		$db->insert("membership", $set);
		serveranswer(4, "location.href='./?view=membership'");
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
                        case "delete":
							$data = array("type" => 1);
							$db->update("members", $data, "type=" . $mid);
							$db->delete("membership", "id=" . $mid);
					}
				}
			}
		}
	}
}

$paginator = new Pagination("membership", $cond);
$paginator->setOrders("price", "ASC");
$paginator->setPage($input->gc['page']);
$paginator->allowedfield($allowed);
$paginator->setNewOrders($input->gc['orderby'], $input->gc['sortby']);
$paginator->setLink("./?view=membership&" . $adlink);
$q = $paginator->getQuery();
include SOURCES . "header.php";
echo "<div class=\"site_title\">Memberships</div>
<div class=\"site_content\">
<div id=\"tabs\">
	<ul>
    	<li><a href=\"#tab-1\">Manage Memberships</a></li>
        <li><a href=\"#tab-2\">Add new membership</a></li>
        <li><a href=\"#tab-3\">Settings</a></li>
    </ul>
    <div id=\"tab-1\">
		";

if ($error_msg) {
	echo "        <div class=\"error_box\">";
	echo $error_msg;
	echo "</div>
        ";
}

echo "        <form method=\"post\" action=\"";
echo $paginator->gotopage();
echo "\">
        <input type=\"hidden\" name=\"sesion_id\" value=\"";
echo sesion_id();
echo "\" />
          <table width=\"100%\" class=\"widget-tbl\">
            <tr class=\"titles\">
                <td width=\"20\"><input type=\"checkbox\" id=\"checkall\"></td>
                <td>";
echo $paginator->linkorder("name", "Name");
echo "</td>
                <td align=\"center\">";
echo $paginator->linkorder("price", "Price");
echo "</td>
                <td align=\"center\">";
echo $paginator->linkorder("diration", "Duration");
echo "</td>
                <td align=\"center\">";
echo $paginator->linkorder("click", "Click %");
echo "</td>
                <td align=\"center\">";
echo $paginator->linkorder("ref_click", "Ref Click %");
echo "</td>
                <td align=\"center\">";
echo $paginator->linkorder("directref_limit", "Ref Limit");
echo "</td>
                <td align=\"center\">";
echo $paginator->linkorder("rentedref_limit", "Rented ref Limit");
echo "</td>
                <td align=\"center\">";
echo $paginator->linkorder("instant_withdrawal", "Inst. Payment");
echo "</td>
                <td align=\"center\"></td>
            </tr>
            ";

while ($r = $db->fetch_array($q)) {
	$tr = ($tr == "tr1" ? "tr2" : "tr1");
	echo "            <tr class=\"";
	echo $tr;
	echo " normal_linetbl\">
                <td align=\"center\">";
	echo $r['id'] != 1 ? "<input type=\"checkbox\" name=\"mid[]\" value=\"" . $r['id'] . "\" class=\"checkall\" />" : "";
	echo "</td>
                <td>";
	echo $r['name'];
	echo "</td>
                <td align=\"center\"><span style=\"color:green\">";
	echo $r['price'] == 0 ? "Free" : $r['price'];
	echo "</span></td>
                <td align=\"center\"><span style=\"color:#000099\">";
	echo $r['duration'];
	echo "</span></td>
                <td align=\"center\"><span style=\"color:orange\">";
	echo $r['click'];
	echo "</span></td>
                <td align=\"center\"><span style=\"color:#990000\">";
	echo $r['ref_click'];
	echo "</span></td>
                <td align=\"center\"><span style=\"color:#990033\">";
	echo $r['directref_limit'] == -1 ? "Unlimited" : $r['directref_limit'];
	echo "</span></td>
                <td align=\"center\"><span style=\"color:#333333\">";
	echo $r['rentedref_limit'] == -1 ? "Unlimied" : $r['rentedref_limit'];
	echo "</span></td>
                <td align=\"center\"><span style=\"color:#663300\">";
	echo $r['instant_withdrawal'] == "yes" ? "Yes" : "No";
	echo "</span></td>
                <td align=\"center\"><a href=\"./?view=membership&edit=";
	echo $r['id'];
	echo "\"><img src=\"./css/images/edit.png\" border=\"0\" title=\"Edit membership\" /></a> <a href=\"javascript:void(0);\" onClick=\"openWindows('<span style=\'font-weight:normal\'>Membership:</span> ";
	echo $r['name'];
	echo "', 'info-";
	echo $r['id'];
	echo "');\"><img src=\"./css/images/info.png\" title=\"More info\" border=\"0\" /></a>
        <div id=\"info-";
	echo $r['id'];
	echo "\" style=\"display:none\">
        <table width=\"100%\" class=\"widget-tbl\">
            <tr>
                <td align=\"right\"> Maximum clicks per day:</td>
                <td style=\"color:green\">";
	echo $r['max_clicks'] == 0 ? "Unlimited" : $r['max_clicks'];
	echo "</td>
                <td align=\"right\">Minimum Payout:</td>
                <td style=\"color:green\">";
	echo $r['minimum_payout'];
	echo "</td>

            </tr>
            <tr>
                <td align=\"right\">Purchase Comission (%):</td>
                <td style=\"color:#990000\">";
	echo $r['ref_purchase'];
	echo "</td>
                <td align=\"right\">Upgrade Commission :</td>
                <td style=\"color:#990000\">";
	echo $r['ref_upgrade'];
	echo "</td>
            </tr>
            <tr>
                <td align=\"right\">Rent Referrals Pack:</td>
                <td style=\"color:#FF9900\">";
	echo $r['rent_pack'];
	echo "</td>
                <td align=\"right\">Recycle Cost:</td>
                <td style=\"color:#000099\">";
	echo $r['recycle_cost'];
	echo "</td>
            </tr>
            <tr>
                <td align=\"right\">Rent Referrals Time:</td>
                <td style=\"color:#000099\">";
	echo $r['rent_time'] == 0 ? "Disable" : $r['rent_time'] . " days";
	echo "</td>
                <td align=\"right\">Cashout Time:</td>
                <td style=\"color:#990033\">";
	echo $r['cashout_time'] == 0 ? "Disable" : $r['cashout_time'] . " days";
	echo "</td>
            </tr>
            <tr>
                <td align=\"right\">Direct Referral Deletion Cost:</td>
                <td style=\"color:#990033\" colspan=\"3\">";
	echo $r['referral_deletion'];
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
                        <option value=\"delete\">Delete</option>
                    </select>
                    <input type=\"submit\" name=\"action\" value=\"Submit\" />
                </div>
            ";
}

echo "        </form>

    </div>
    <div id=\"tab-2\">

<form method=\"post\" id=\"newfrm\" onsubmit=\"return submitform(this.id);\">
<input type=\"hidden\" name=\"do\" value=\"new_membership\" />
		        <table class=\"widget-tbl\" width=\"100%\">
        	<tr>

            	<td width=\"300\" align=\"right\">Name</td>
                <td><input name=\"name\" type=\"text\" /></td>
           	</tr>
            <tr>
            	<td align=\"right\">Duration</td>
                <td>
                <input name=\"duration\" type=\"text\" value=\"30\"> days</td>
            </tr>
        	<tr>
        	  <td align=\"right\"> Price</td>
      	      <td><input name=\"price\" type=\"text\" id=\"price\" value=\"0.00\" /></td>
       	  </tr>
        	<tr>
        	  <td align=\"right\"> Click</td>
        	  <td><input name=\"click\" type=\"text\" id=\"click\" value=\"100\" />%</td>
       	  </tr>
          <tr>
          	<td align=\"right\"> Maximum clicks per day:</td>
<td><input name=\"max_clicks\" type=\"text\" id=\"max_clicks\" value=\"0\"> 0 = Unlimited</td>
          </tr>
        	<tr>
        	  <td align=\"right\"> Referral Click:</td>
        	  <td><input name=\"ref_click\" type=\"text\" id=\"ref_click\" value=\"100\" />%</td>
       	  </tr>
        	<tr>
        	  <td align=\"right\">Purchase Comission:</td>
        	  <td><input name=\"ref_purchase\" type=\"text\" id=\"ref_purchase\" value=\"0\" />%</td>
      	  </tr>
        	<tr>
        	  <td align=\"right\">Upgrade Commission:</td>
        	  <td><input name=\"ref_upgrade\" type=\"text\" id=\"ref_upgrade\" value=\"0.00\" /></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\">Direct Referral Limit:</td>
        	  <td><input name=\"directref_limit\" type=\"text\" id=\"ref_upgrade\" value=\"-1\" /> -1 = Unlimited</td>
      	  </tr>
                  	<tr>
        	  <td align=\"right\">Direct Referral Deletion Cost:</td>
        	  <td><input name=\"referral_deletion\" type=\"text\" id=\"referral_deletion\" value=\"0\" /> 0 = free</td>
      	  </tr>
        	<tr>
        	  <td align=\"right\">Membership Active:</td>
        	  <td><input type=\"checkbox\" name=\"active\" value=\"yes\" checked>
       Tick to enable - membership will be allowed to purchase</td>
      	  </tr>

          <tr>
          	<td colspan=\"2\" class=\"widget-title\">Rent Referral Settings</td>
          </tr>
        	<tr>
        	  <td align=\"right\">Rent Referrals Pack:</td>
        	  <td><input name=\"rent_pack\" type=\"text\" id=\"rent_pack\" value=\"25,50,75,100\" /> Ex: 5,10,50,100</td>
      	  </tr>

        	<tr>
        	  <td align=\"right\">Rented Referral Limit:</td>
        	  <td><input name=\"rentedref_limit\" type=\"text\" id=\"rentedref_limit\" value=\"-1\" /> -1 = Unlimited</td>
      	  </tr>
        	<tr>
        	  <td align=\"right\">Recycle Cost:</td>
        	  <td><input name=\"recycle_cost\" type=\"text\" id=\"recycle_cost\" value=\"0.00\" /> </td>
      	  </tr>
        	<tr>
        	  <td align=\"right\">Rent Referrals Time:</td>
        	  <td><input name=\"rent_time\" type=\"text\" id=\"rent_time\" value=\"0\" /> 0 = Disable</td>
      	  </tr>
          <tr>
          	<td colspan=\"2\">
   	<table width=\"100%\" class=\"widget-tbl\">
            <tr>
            	<td class=\"widget-title\" align=\"center\">Referrals</td>
                <td class=\"widget-title\" align=\"center\">Monthly</td>
                <td class=\"widget-title\" align=\"center\">Autopay</td>
            </tr>
            <tr>
            <td align=\"center\">0 -&gt; 250</td>
            <td align=\"center\"><input type=\"text\" name=\"rent250\" value=\"0.29\" /></td>
            <td align=\"center\"><input type=\"text\" name=\"autopay250\" value=\"0.009\" /></td>
            </tr>
            <tr>
            <td align=\"center\">251 -&gt; 500</td>
            <td align=\"center\"><input type=\"text\" name=\"rent500\" value=\"0.30\" /></td>
            <td align=\"center\"><input type=\"text\" name=\"autopay500\" value=\"0.009\" /></td>
            </tr>
            <tr>
            <td align=\"center\">501 -&gt; 750</td>
            <td align=\"center\"><input type=\"text\" name=\"rent750\" value=\"0.31\" /></td>
            <td align=\"center\"><input type=\"text\" name=\"autopay750\" value=\"0.009\" /></td>
            </tr>
            <tr>
            <td align=\"center\">751 -&gt; 1000</td>
            <td align=\"center\"><input type=\"text\" name=\"rent1000\" value=\"0.32\" /></td>
            <td align=\"center\"><input type=\"text\" name=\"autopay1000\" value=\"0.010\" /></td>
            </tr>
            <tr>
            <td align=\"center\">1001 -&gt; 1250</td>
            <td align=\"center\"><input type=\"text\" name=\"rent1250\" value=\"0.33\" /></td>
            <td align=\"center\"><input type=\"text\" name=\"autopay1250\" value=\"0.010\" /></td>
            </tr>
            <tr>
            <td align=\"center\">1251 -&gt; 1500</td>
            <td align=\"center\"><input type=\"text\" name=\"rent1500\" value=\"0.34\" /></td>
            <td align=\"center\"><input type=\"text\" name=\"autopay1500\" value=\"0.010\" /></td>
            </tr>
            <tr>
            <td align=\"center\">1501 -&gt; 1750</td>
            <td align=\"center\"><input type=\"text\" name=\"rent1750\" value=\"0.35\" /></td>
            <td align=\"center\"><input type=\"text\" name=\"autopay1750\" value=\"0.011\" /></td>
            </tr>
            <tr>
            <td align=\"center\">Over 1750</td>
            <td align=\"center\"><input type=\"text\" name=\"rentover\" value=\"0.36\" /></td>
            <td align=\"center\"><input name=\"autopayover\" type=\"text\" value=\"0.011\" /></td>
            </tr>
        </table>
            </td>
          </tr>
          <tr>
          	<td colspan=\"2\" class=\"widget-title\">Withdraw Settings</td>
          </tr>
        	<tr>
        	  <td align=\"right\">Maximum withdraw per day:</td>
        	  <td><input name=\"max_withdraw\" type=\"text\" value=\"0\"> 0 = No limit</td>
       	  </tr>
        	<tr>
        	  <td align=\"right\">Minimum Payout:</td>
        	  <td><input name=\"minimum_payout\" type=\"text\" id=\"minimum_payout\" value=\"5.00\"> Ex: 1.00,3.00,4.00</td>
       	  </tr>
        	<tr>
        	  <td align=\"right\">Cashout Time:</td>
        	  <td><input name=\"cashout_time\" type=\"text\" id=\"cashout_time\" value=\"0\" /> 0 = Disable</td>
      	  </tr>
        	<tr>
        	  <td align=\"right\">Instant Payment:</td>
              <td><input type=\"checkbox\" name=\"instant_withdrawal\" value=\"yes\">
       Tick to enable - membership will be allowed to use Instant Payment</td>
      	  </tr>

          <tr>
          	<td colspan=\"2\" class=\"widget-title\">Point System</td>
          </tr>
        	<tr>
        	  <td align=\"right\">Point system enable?</td>
              <td><select name=\"point_enable\">
              <option value=\"1\">Yes</option>
              <option value=\"0\">No</option>
              </select></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\"><span class=\"pointer\" title=\"The total number of points credited to member per direct referral signup.\">Points per direct referral:</span></td>
              <td><input type=\"text\" name=\"point_ref\" value=\"0.00\" /></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\"><span class=\"pointer\" title=\"The total number of points credited to member per ptc click.\">Points per ptc click:</span></td>
              <td><input type=\"text\" name=\"point_ptc\" value=\"0.00\" /></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\"><span class=\"pointer\" title=\"The total number of points credited to member per forum post.\">Points per forum post:</span></td>
              <td><input type=\"text\" name=\"point_post\" value=\"0.00\" /></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\"><span class=\"pointer\" title=\"The total number of points credited to member per completed offer.\">Points per completed offer:</span></td>
              <td><input type=\"text\" name=\"point_ptsu\" value=\"0.00\" /></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\"><span class=\"pointer\" title=\"The total number of points credited to member per dollar deposited.\">Points per dollar deposited:</span></td>
              <td><input type=\"text\" name=\"point_deposit\" value=\"0.00\" /></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\">Allow upgrade using points?</td>
              <td><select name=\"point_upgrade\">
              <option value=\"1\">Yes</option>
              <option value=\"0\">No</option>
              </select></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\"><span class=\"pointer\" title=\"Example: if set to 5 and upgrade costs $10 you will need 50 points to upgrade.\">Points per dollar for upgrade value:</span></td>
              <td><input type=\"text\" name=\"point_upgraderate\" value=\"20.00\" /></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\">Allow convert points to purchase balance?</td>
              <td><select name=\"point_purchasebalance\">
              <option value=\"1\">Yes</option>
              <option value=\"0\">No</option>
              </select></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\"><span class=\"pointer\" title=\"Ex. 10, where 10 = $1\">Points per dollar for conversion to purchase balance:</span></td>
              <td><input type=\"text\" name=\"point_cashrate\" value=\"10.00\" /></td>
      	  </tr>
        	<tr>
            	<td></td>
        	  <td><input type=\"submit\" name=\"btn\" value=\"Create\" /></td>
      	  </tr>
        </table>
    </form>
<div class=\"info_box\">
<strong>Click:</strong> Percentage of click value for each member click.<br />
<strong>Maximum clicks per day:</strong> You can limit the amount of clicks per day per each membership. 0 = Unlimited.<br />
<strong>Referral Click:</strong> Percentage of click value for each direct referral click.<br />
<strong>Minimum Payout:</strong> Amount required to make a cashout. Ex: 2.00,5.00 (first cashout is $2.00, second cashout $5.00)<br />
<strong>Purchases Commission:</strong> Percentage of revenues generated from direct referrals' ad purchases.<br />
<strong>Upgrade Commission:</strong> Amount of comission per direct referral upgrade.<br />
<strong>Rent Referrals Pack:</strong> Rented referral pack available to member. Enter with commas and without space, ex: 25,75,100<br />
<strong>Rent Referrals Time:</strong> Days between referral rentals<br />
<strong>Cashout Time:</strong> Days between cashouts<br />
</div>
    </div>
    <div id=\"tab-3\">
    <form method=\"post\" id=\"frmsettings\" onsubmit=\"return submitform(this.id);\">
    <input type=\"hidden\" name=\"do\" value=\"update_settings\" />
    <table class=\"widget-tbl\" width=\"100%\">
    <tr>
    <td valign=\"top\" width=\"300\" align=\"right\">Auto-Upgrade after member purchases</td>
    <td valign=\"top\"><input type=\"checkbox\" name=\"auto_upgrade\" id=\"auto_upgrade\" value=\"yes\" ";

if ($auto_upgrade == "yes") {
	echo "checked";
}

echo " /></td>
    </tr>
    <tr>
    <td valign=\"top\" align=\"right\">Allow direct referral deletion</td>
    <td valign=\"top\"><input type=\"checkbox\" name=\"ref_deletion\" id=\"ref_deletion\" value=\"yes\" ";

if ($settings['ref_deletion'] == "yes") {
	echo "checked";
}

echo " /></td>
    </tr>

    <tr>
    <td></td>
    <td>
    <input type=\"submit\" name=\"btn\" value=\"Save\" class=\"orange\" />
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
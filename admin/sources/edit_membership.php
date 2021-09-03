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

$data = $db->fetchRow("SELECT * FROM membership WHERE id=" . $input->gc['edit']);

if ($input->p['do'] == "edit_membership") {
	verifyajax();
	verifydemo();

	if ($data['id'] != 1) {
		$set = array("name" => $input->pc['name'], "price" => $input->pc['price'], "click" => $input->pc['click'], "ref_click" => $input->pc['ref_click'], "minimum_payout" => $input->pc['minimum_payout'], "ref_upgrade" => $input->pc['ref_upgrade'], "ref_purchase" => $input->pc['ref_purchase'], "directref_limit" => $input->pc['directref_limit'], "duration" => $input->pc['duration'], "rentedref_limit" => $input->pc['rentedref_limit'], "recycle_cost" => $input->pc['recycle_cost'], "rent_time" => $input->pc['rent_time'], "rent_pack" => $input->pc['rent_pack'], "cashout_time" => $input->pc['cashout_time'], "referral_deletion" => $input->pc['referral_deletion'], "active" => $input->pc['active'], "instant_withdrawal" => $input->pc['instant_withdrawal'], "max_clicks" => $input->pc['max_clicks'], "max_withdraw" => $input->pc['max_withdraw'], "rent250" => $input->pc['rent250'], "rent500" => $input->pc['rent500'], "rent750" => $input->pc['rent750'], "rent1000" => $input->pc['rent1000'], "rent1250" => $input->pc['rent1250'], "rent1500" => $input->pc['rent1500'], "rent1750" => $input->pc['rent1750'], "rentover" => $input->pc['rentover'], "autopay250" => $input->pc['autopay250'], "autopay500" => $input->pc['autopay500'], "autopay750" => $input->pc['autopay750'], "autopay1000" => $input->pc['autopay1000'], "autopay1250" => $input->pc['autopay1250'], "autopay1500" => $input->pc['autopay1500'], "autopay1750" => $input->pc['autopay1750'], "autopayover" => $input->pc['autopayover'], "point_enable" => $input->pc['point_enable'], "point_ref" => $input->pc['point_ref'], "point_ptc" => $input->pc['point_ptc'], "point_post" => $input->pc['point_post'], "point_ptsu" => $input->pc['point_ptsu'], "point_deposit" => $input->pc['point_deposit'], "point_upgrade" => $input->pc['point_upgrade'], "point_upgraderate" => $input->pc['point_upgraderate'], "point_purchasebalance" => $input->pc['point_purchasebalance'], "point_cashrate" => $input->pc['point_cashrate']);
	}
	else {
		$set = array("name" => $input->pc['name'], "click" => $input->pc['click'], "ref_click" => $input->pc['ref_click'], "minimum_payout" => $input->pc['minimum_payout'], "ref_upgrade" => $input->pc['ref_upgrade'], "ref_purchase" => $input->pc['ref_purchase'], "directref_limit" => $input->pc['directref_limit'], "rentedref_limit" => $input->pc['rentedref_limit'], "recycle_cost" => $input->pc['recycle_cost'], "rent_time" => $input->pc['rent_time'], "rent_pack" => $input->pc['rent_pack'], "cashout_time" => $input->pc['cashout_time'], "referral_deletion" => $input->pc['referral_deletion'], "active" => $input->pc['active'], "instant_withdrawal" => $input->pc['instant_withdrawal'], "max_clicks" => $input->pc['max_clicks'], "max_withdraw" => $input->pc['max_withdraw'], "rent250" => $input->pc['rent250'], "rent500" => $input->pc['rent500'], "rent750" => $input->pc['rent750'], "rent1000" => $input->pc['rent1000'], "rent1250" => $input->pc['rent1250'], "rent1500" => $input->pc['rent1500'], "rent1750" => $input->pc['rent1750'], "rentover" => $input->pc['rentover'], "autopay250" => $input->pc['autopay250'], "autopay500" => $input->pc['autopay500'], "autopay750" => $input->pc['autopay750'], "autopay1000" => $input->pc['autopay1000'], "autopay1250" => $input->pc['autopay1250'], "autopay1500" => $input->pc['autopay1500'], "autopay1750" => $input->pc['autopay1750'], "autopayover" => $input->pc['autopayover'], "point_enable" => $input->pc['point_enable'], "point_ref" => $input->pc['point_ref'], "point_ptc" => $input->pc['point_ptc'], "point_post" => $input->pc['point_post'], "point_ptsu" => $input->pc['point_ptsu'], "point_deposit" => $input->pc['point_deposit'], "point_upgrade" => $input->pc['point_upgrade'], "point_upgraderate" => $input->pc['point_upgraderate'], "point_purchasebalance" => $input->pc['point_purchasebalance'], "point_cashrate" => $input->pc['point_cashrate']);
	}

	$db->update("membership", $set, "id=" . $data['id']);
	serveranswer(3, "Membership was updated.");
}

include SOURCES . "header.php";
echo "
<div class=\"site_title\">Edit Membership</div>
<div class=\"site_content\">
<form method=\"post\" id=\"newfrm\" onsubmit=\"return submitform(this.id);\">
<input type=\"hidden\" name=\"do\" value=\"edit_membership\" />
		        <table class=\"widget-tbl\" width=\"100%\">
        	<tr>

            	<td width=\"300\" align=\"right\">Name</td>
                <td><input name=\"name\" type=\"text\" value=\"";
echo $data['name'];
echo "\" /></td>
           	</tr>
            ";

if ($data['id'] != 1) {
	echo "            <tr>
            	<td align=\"right\">Duration</td>
                <td>
                <input name=\"duration\" type=\"text\" value=\"";
	echo $data['duration'];
	echo "\"> days</td>
            </tr>
        	<tr>
        	  <td align=\"right\"> Price</td>
      	      <td><input name=\"price\" type=\"text\" value=\"";
	echo $data['price'];
	echo "\" /></td>
       	  </tr>
          ";
}

echo "        	<tr>
        	  <td align=\"right\"> Click</td>
        	  <td><input name=\"click\" type=\"text\" value=\"";
echo $data['click'];
echo "\" />%</td>
       	  </tr>
          <tr>
          	<td align=\"right\"> Maximum clicks per day:</td>
<td><input name=\"max_clicks\" type=\"text\" id=\"max_clicks\" value=\"";
echo $data['max_clicks'];
echo "\"> 0 = Unlimited</td>
          </tr>
        	<tr>
        	  <td align=\"right\"> Referral Click:</td>
        	  <td><input name=\"ref_click\" type=\"text\" id=\"ref_click\" value=\"";
echo $data['ref_click'];
echo "\" />%</td>
       	  </tr>


        	<tr>
        	  <td align=\"right\">Purchase Comission:</td>
        	  <td><input name=\"ref_purchase\" type=\"text\" value=\"";
echo $data['ref_purchase'];
echo "\" />%</td>
      	  </tr>
        	<tr>
        	  <td align=\"right\">Upgrade Commission: </td>
        	  <td><input name=\"ref_upgrade\" type=\"text\" value=\"";
echo $data['ref_upgrade'];
echo "\" /></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\">Direct Referral Limit: </td>
        	  <td><input name=\"directref_limit\" type=\"text\"  value=\"";
echo $data['directref_limit'];
echo "\" /> -1 = Unlimited</td>
      	  </tr>
                  	<tr>
        	  <td align=\"right\">Direct Referral Deletion Cost:</td>
        	  <td><input name=\"referral_deletion\" type=\"text\" value=\"";
echo $data['referral_deletion'];
echo "\" /> 0 = free</td>
      	  </tr>

        	<tr>
        	  <td align=\"right\">Membership Active:</td>
        	  <td><input type=\"checkbox\" name=\"active\" value=\"yes\"   ";
echo $data['active'] == "yes" ? "checked" : "";
echo ">
       Tick to enable - membership will be allowed to purchase</td>
      	  </tr>

          <tr>
          	<td colspan=\"2\" class=\"widget-title\">Rent Referral Settings</td>
          </tr>
        	<tr>
        	  <td align=\"right\">Rent Referrals Pack:</td>
        	  <td><input name=\"rent_pack\" type=\"text\" value=\"";
echo $data['rent_pack'];
echo "\" /> Ex: 5,10,50,100</td>
      	  </tr>

        	<tr>
        	  <td align=\"right\">Rented Referral Limit: </td>
        	  <td><input name=\"rentedref_limit\" type=\"text\" value=\"";
echo $data['rentedref_limit'];
echo "\" /> -1 = Unlimited</td>
      	  </tr>
        	<tr>
        	  <td align=\"right\">Recycle Cost:</td>
        	  <td><input name=\"recycle_cost\" type=\"text\" value=\"";
echo $data['recycle_cost'];
echo "\" /> </td>
      	  </tr>
        	<tr>
        	  <td align=\"right\">Rent Referrals Time:</td>
        	  <td><input name=\"rent_time\" type=\"text\" value=\"";
echo $data['rent_time'];
echo "\" /> 0 = Disable</td>
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
            <td align=\"center\"><input type=\"text\" name=\"rent250\" value=\"";
echo $data['rent250'];
echo "\" /></td>
            <td align=\"center\"><input type=\"text\" name=\"autopay250\" value=\"";
echo $data['autopay250'];
echo "\" /></td>
            </tr>
            <tr>
            <td align=\"center\">251 -&gt; 500</td>
            <td align=\"center\"><input type=\"text\" name=\"rent500\" value=\"";
echo $data['rent500'];
echo "\" /></td>
            <td align=\"center\"><input type=\"text\" name=\"autopay500\" value=\"";
echo $data['autopay500'];
echo "\" /></td>
            </tr>
            <tr>
            <td align=\"center\">501 -&gt; 750</td>
            <td align=\"center\"><input type=\"text\" name=\"rent750\" value=\"";
echo $data['rent750'];
echo "\" /></td>
            <td align=\"center\"><input type=\"text\" name=\"autopay750\" value=\"";
echo $data['autopay750'];
echo "\" /></td>
            </tr>
            <tr>
            <td align=\"center\">751 -&gt; 1000</td>
            <td align=\"center\"><input type=\"text\" name=\"rent1000\" value=\"";
echo $data['rent1000'];
echo "\" /></td>
            <td align=\"center\"><input type=\"text\" name=\"autopay1000\" value=\"";
echo $data['autopay1000'];
echo "\" /></td>
            </tr>
            <tr>
            <td align=\"center\">1001 -&gt; 1250</td>
            <td align=\"center\"><input type=\"text\" name=\"rent1250\" value=\"";
echo $data['rent1250'];
echo "\" /></td>
            <td align=\"center\"><input type=\"text\" name=\"autopay1250\" value=\"";
echo $data['autopay1250'];
echo "\" /></td>
            </tr>
            <tr>
            <td align=\"center\">1251 -&gt; 1500</td>
            <td align=\"center\"><input type=\"text\" name=\"rent1500\" value=\"";
echo $data['rent1500'];
echo "\" /></td>
            <td align=\"center\"><input type=\"text\" name=\"autopay1500\" value=\"";
echo $data['autopay1500'];
echo "\" /></td>
            </tr>
            <tr>
            <td align=\"center\">1501 -&gt; 1750</td>
            <td align=\"center\"><input type=\"text\" name=\"rent1750\" value=\"";
echo $data['rent1750'];
echo "\" /></td>
            <td align=\"center\"><input type=\"text\" name=\"autopay1750\" value=\"";
echo $data['autopay1750'];
echo "\" /></td>
            </tr>
            <tr>
            <td align=\"center\">Over 1750</td>
            <td align=\"center\"><input type=\"text\" name=\"rentover\" value=\"";
echo $data['rentover'];
echo "\" /></td>
            <td align=\"center\"><input name=\"autopayover\" type=\"text\" value=\"";
echo $data['autopayover'];
echo "\" /></td>
            </tr>
        </table>
            </td>
          </tr>
          <tr>
          	<td colspan=\"2\" class=\"widget-title\">Withdraw Settings</td>
          </tr>
        	<tr>
        	  <td align=\"right\">Maximum withdraw per day:</td>
        	  <td><input name=\"max_withdraw\" type=\"text\" value=\"";
echo $data['max_withdraw'];
echo "\"> 0 = No limit</td>
       	  </tr>
        	<tr>
        	  <td align=\"right\">Minimum Payout:</td>
        	  <td><input name=\"minimum_payout\" type=\"text\" value=\"";
echo $data['minimum_payout'];
echo "\"> Ex: 1.00,3.00,4.00</td>
       	  </tr>
        	<tr>
        	  <td align=\"right\">Cashout Time:</td>
        	  <td><input name=\"cashout_time\" type=\"text\" value=\"";
echo $data['cashout_time'];
echo "\" /> 0 = Disable</td>
      	  </tr>
        	<tr>
        	  <td align=\"right\">Instant Payment:</td>
              <td><input type=\"checkbox\" name=\"instant_withdrawal\" value=\"yes\"  ";
echo $data['instant_withdrawal'] == "yes" ? "checked" : "";
echo ">
       Tick to enable - membership will be allowed to use Instant Payment</td>
      	  </tr>
          <tr>
          	<td colspan=\"2\" class=\"widget-title\">Point System</td>
          </tr>
        	<tr>
        	  <td align=\"right\">Point system enable?</td>
              <td><select name=\"point_enable\">
              <option value=\"1\" ";
echo $data['point_enable'] == 1 ? "selected" : "";
echo ">Yes</option>
              <option value=\"0\" ";
echo $data['point_enable'] != 1 ? "selected" : "";
echo ">No</option>
              </select></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\"><span class=\"pointer\" title=\"The total number of points credited to member per direct referral signup.\">Points per direct referral:</span></td>
              <td><input type=\"text\" name=\"point_ref\" value=\"";
echo $data['point_ref'];
echo "\" /></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\"><span class=\"pointer\" title=\"The total number of points credited to member per ptc click.\">Points per ptc click:</span></td>
              <td><input type=\"text\" name=\"point_ptc\" value=\"";
echo $data['point_ptc'];
echo "\" /></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\"><span class=\"pointer\" title=\"The total number of points credited to member per forum post.\">Points per forum post:</span></td>
              <td><input type=\"text\" name=\"point_post\" value=\"";
echo $data['point_post'];
echo "\" /></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\"><span class=\"pointer\" title=\"The total number of points credited to member per completed offer.\">Points per completed offer:</span></td>
              <td><input type=\"text\" name=\"point_ptsu\" value=\"";
echo $data['point_ptsu'];
echo "\" /></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\"><span class=\"pointer\" title=\"The total number of points credited to member per dollar deposited.\">Points per dollar deposited:</span></td>
              <td><input type=\"text\" name=\"point_deposit\" value=\"";
echo $data['point_deposit'];
echo "\" /></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\">Allow upgrade using points?</td>
              <td><select name=\"point_upgrade\">
              <option value=\"1\" ";
echo $data['point_upgrade'] == 1 ? "selected" : "";
echo ">Yes</option>
              <option value=\"0\" ";
echo $data['point_upgrade'] != 1 ? "selected" : "";
echo ">No</option>
              </select></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\"><span class=\"pointer\" title=\"Example: if set to 5 and upgrade costs $10 you will need 50 points to upgrade.\">Points per dollar for upgrade value:</span></td>
              <td><input type=\"text\" name=\"point_upgraderate\" value=\"";
echo $data['point_upgraderate'];
echo "\" /></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\">Allow convert points to purchase balance?</td>
              <td><select name=\"point_purchasebalance\">
              <option value=\"1\" ";
echo $data['point_purchasebalance'] == 1 ? "selected" : "";
echo ">Yes</option>
              <option value=\"0\" ";
echo $data['point_purchasebalance'] != 1 ? "selected" : "";
echo ">No</option>
              </select></td>
      	  </tr>
        	<tr>
        	  <td align=\"right\"><span class=\"pointer\" title=\"Ex. 10, where 10 = $1\">Points per dollar for conversion to purchase balance:</span></td>
              <td><input type=\"text\" name=\"point_cashrate\" value=\"";
echo $data['point_cashrate'];
echo "\" /></td>
      	  </tr>
        	<tr>
            	<td></td>
        	  <td><input type=\"submit\" name=\"btn\" value=\"Update\" />
              <input type=\"button\" name=\"btn\" value=\"Return\" onclick=\"location.href='./?view=membership';\" />
              </td>
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
";
include SOURCES . "footer.php";
?>
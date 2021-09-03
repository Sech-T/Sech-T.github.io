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

$stp_currencies = array("USD" => "US Dollars", "EUR" => "Euro", "GBP" => "Pound Sterling", "AUD" => "Australian Dollar", "CAD" => "Canadian Dollar", "NZD" => "New Zealand Dollar");
echo "<form method=\"post\" id=\"frm";
echo $r['id'];
echo "\" onsubmit=\"return submitform(this.id);\">
	<table width=\"100%\" class=\"widget-tbl\">
    	<tr>
        	<td align=\"right\" width=\"200\">STP Username:</td>
            <td><input type=\"text\" name=\"account\" value=\"";
echo $r['account'];
echo "\" /></td>
        </tr>
    	<tr>
        	<td align=\"right\">SCSI Name:</td>
            <td><input type=\"text\" name=\"option1\" value=\"";
echo $r['option1'];
echo "\" /></td>
        </tr>
    	<tr>
        	<td align=\"right\">Notify and Confirm URL:</td>
            <td style=\"color:#0000CC\">";
echo $settings['site_url'];
echo "modules/gateways/stpstatus.php</td>
        </tr>
    	<tr>
        	<td align=\"right\">Return URL:</td>
            <td style=\"color:#0000CC\">";
echo $settings['site_url'];
echo "modules/gateways/thankyou.php</td>
        </tr>
    	<tr>
        	<td align=\"right\">Cancel URL:</td>
            <td style=\"color:#0000CC\">";
echo $settings['site_url'];
echo "modules/gateways/addfunds.php</td>
        </tr>
    	<tr>
        	<td align=\"right\">Secondary Password:</td>
            <td><input type=\"text\" name=\"option4\" value=\"";
echo $r['option4'];
echo "\" /></td>
        </tr>
    	<tr>
        	<td align=\"right\">Currency:</td>
            <td><select name=\"currency\">
            	";
foreach ($stp_currencies as $k => $v) {

	if ($k == $r['currency']) {
		echo "<option value=\"" . $k . "\" selected>" . $v . "</option>";
		continue;
	}

	echo "<option value=\"" . $k . "\">" . $v . "</option>";
}

echo "            </select>
            </td>
        </tr>
    	<tr>
        	<td align=\"right\">Allow upgrades:</td>
            <td><select name=\"allow_upgrade\">
            	<option value=\"yes\" ";
echo $r['allow_upgrade'] == "yes" ? "selected" : "";
echo ">Yes</option>
                <option value=\"no\" ";
echo $r['allow_upgrade'] == "no" ? "selected" : "";
echo ">No</option>
            </select>
            </td>
        </tr>
    	<tr>
        	<td align=\"right\">Allow deposits:</td>
            <td><select name=\"allow_deposits\">
            	<option value=\"yes\" ";
echo $r['allow_deposits'] == "yes" ? "selected" : "";
echo ">Yes</option>
                <option value=\"no\" ";
echo $r['allow_deposits'] == "no" ? "selected" : "";
echo ">No</option>
            </select>
            </td>
        </tr>
    	<tr>
        	<td align=\"right\">Minimum deposit:</td>
            <td><input type=\"text\" name=\"min_deposit\" value=\"";
echo $r['min_deposit'];
echo "\" /></td>
        </tr>
    	<tr>
        	<td align=\"right\">Allow withdrawals:</td>
            <td><select name=\"allow_withdrawals\">
            	<option value=\"yes\" ";
echo $r['allow_withdrawals'] == "yes" ? "selected" : "";
echo ">Yes</option>
                <option value=\"no\" ";
echo $r['allow_withdrawals'] == "no" ? "selected" : "";
echo ">No</option>
            </select>
            </td>
        </tr>
    	<tr>
        	<td align=\"right\">Withdraw fee:</td>
            <td>$<input type=\"text\" name=\"withdraw_fee_fixed\" value=\"";
echo $r['withdraw_fee_fixed'];
echo "\" /> + <input type=\"text\" name=\"withdraw_fee\" value=\"";
echo $r['withdraw_fee'];
echo "\" />%</td>
        </tr>
    	<tr>
        	<td align=\"right\">API ID:</td>
            <td><input type=\"text\" name=\"option2\" value=\"";
echo $r['option2'];
echo "\" /> <span style=\"color:green\">(For instant withdrawals)</span></td>
        </tr>
    	<tr>
        	<td align=\"right\">API Password:</td>
            <td><input type=\"text\" name=\"option3\" value=\"";
echo $r['option3'];
echo "\" /> <span style=\"color:green\">(For instant withdrawals)</span></td>
        </tr>
    	<tr>
        	<td align=\"right\">Notify URL:</td>
            <td style=\"color:#0000CC\">";
echo $settings['site_url'];
echo "stpnotify.php</td>
        </tr>
        <tr>
        	<td align=\"right\">Server IP:</td>
            <td style=\"color:#0000CC\">";
echo $_SERVER['SERVER_ADDR'];
echo "</td>
        </tr>
        </tr>
    	<tr>
        	<td align=\"right\">Payment Note:</td>
            <td><input type=\"text\" name=\"option5\" value=\"";
echo $r['option5'];
echo "\" /> <span style=\"color:green\">(For instant withdrawals)</span></td>
        </tr>
        <tr>
        	<td></td>
            <td>
            <input type=\"hidden\" name=\"gateway_action\" value=\"\" id=\"action";
echo $r['id'];
echo "\" />
            <input type=\"hidden\" name=\"gateway_id\" value=\"";
echo $r['id'];
echo "\" />
            <input type=\"submit\" name=\"btn\" value=\"Update\" onclick=\"updfrmvars({'action";
echo $r['id'];
echo "': 'update'});\" />
            	<input type=\"submit\" name=\"btn\" value=\"Deactivate\" onclick=\"updfrmvars({'action";
echo $r['id'];
echo "': 'deactivate'});\" />
            </td>
        </tr>
    </table>
</form>";
?>
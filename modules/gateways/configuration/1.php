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

$ap_currencies = array("USD" => "US Dollars", "EUR" => "Euro", "AUD" => "Australian Dollar", "BGN" => "Bulgarian Lev", "CAD" => "Canadian Dollar", "CHF" => "Swiss Franc", "CZK" => "Czech Koruna", "DKK" => "Danish Krone", "EEK" => "Estonia Kroon", "GBP" => "Pound Sterling", "HKD" => "Hong Kong Dollar", "HUF" => "Hungarian Forint", "INR" => "Indian Rupee", "LTL" => "Lithuanian Litas", "MYR" => "Malaysian Ringgit", "MKD" => "Macedonian Denar", "NOK" => "Norwegian Krone", "NZD" => "New Zealand Dollar", "PLN" => "Polish Zloty", "RON" => "Romanian New Leu", "SEK" => "Swedish Krona", "SGD" => "Singapore Dollar", "ZAR" => "South African Rand");
echo "<form method=\"post\" id=\"frm";
echo $r['id'];
echo "\" onsubmit=\"return submitform(this.id);\">
	<table width=\"100%\" class=\"widget-tbl\">
    	<tr>
        	<td align=\"right\" width=\"200\">Account:</td>
            <td><input type=\"text\" name=\"account\" value=\"";
echo $r['account'];
echo "\" /></td>
        </tr>
    	<tr>
        	<td align=\"right\">Currency:</td>
            <td><select name=\"currency\">
            	";
foreach ($ap_currencies as $k => $v) {

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
        	<td align=\"right\">Security Code:</td>
            <td><input type=\"text\" name=\"option1\" value=\"";
echo $r['option1'];
echo "\" /></td>
        </tr>
    	<tr>
        	<td align=\"right\">Alert URL:</td>
            <td style=\"color:#000099\">";
echo $settings['site_url'];
echo "modules/gateways/apstatus.php</td>
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
        	<td align=\"right\">API Password:</td>
            <td><input type=\"text\" name=\"option2\" value=\"";
echo $r['option2'];
echo "\" /> <span style=\"color:green\">(For instant withdrawals)</span></td>
        </tr>
    	<tr>
        	<td align=\"right\">Sender Account:</td>
            <td><input type=\"text\" name=\"option3\" value=\"";
echo $r['option3'];
echo "\" /> <span style=\"color:green\">(For instant withdrawals)</span></td>
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
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

$ap_currencies = array("USD" => "US Dollars");
echo "<div class=\"info_box\">This payment module works with <strong>BlockChain</strong> and instant payment is not allowed, so you must process payments manually</div>
<form method=\"post\" id=\"frm";
echo $r['id'];
echo "\" onsubmit=\"return submitform(this.id);\">
	<table width=\"100%\" class=\"widget-tbl\">
    	<tr>
        	<td align=\"right\" width=\"200\">Bitcoin address:</td>
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
        	<td align=\"right\">Confirmations required:</td>
            <td><select name=\"option1\">
            	";
$i = 1;

while ($i <= 10) {
	echo "<option value=\"" . $i . "\" " . ($r['option1'] == $i ? "selected" : "") . ">" . $i . "</option>";
	++$i;
}

echo "            </select></td>
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
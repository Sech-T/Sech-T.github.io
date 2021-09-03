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

echo "<form method=\"post\" id=\"editmemberform\" onsubmit=\"return submitform(this.id);\">
<input type=\"hidden\" name=\"a\" value=\"update\" />
<table cellpadding=\"4\" width=\"100%\" class=\"widget-tbl\">
  <tr>
    <td width=\"200\">Full Name:</td>
    <td><input name=\"fullname\" type=\"text\" value=\"";
echo $member['fullname'];
echo "\" /></td>
    </tr>
  <tr>
    <td>New Password:</td>
    <td><input name=\"password\" type=\"text\" /> (leave blank to not change)</td>
  </tr>
  <tr>
    <td>Email:</td>
    <td><input name=\"email\" type=\"text\" value=\"";
echo $member['email'];
echo "\" /></td>
  </tr>
  <tr>
    <td>Country:</td>
    <td><select name=\"country\">
    <option value=\"-\">-</option>
      ";
$countrylist = $db->query("SELECT country FROM ip2nationCountries ORDER BY country ASC");

while ($list = $db->fetch_array($countrylist)) {
	if ($member['country'] == $list['country']) {
		echo "<option value=\"" . $list['country'] . "\" selected>" . $list['country'] . "</option>";
	}
  else {
	 echo "<option value=\"" . $list['country'] . "\">" . $list['country'] . "</option>";
  }
}

echo "    </select></td>
  </tr>
  ";

if (is_array($gateway)) {
	foreach ($gateway as $k => $v) {
		echo "  <tr>
    <td>";
		echo $v['name'];
		echo ":</td>
    <td><input type=\"text\" name=\"gateway[";
		echo $v['id'];
		echo "]\" value=\"";
		echo $user_gateway[$v['id']];
		echo "\" /></td>
  </tr>
  ";
	}
}

echo "
  <tr>
    <td>Referrer:</td>
    <td>

    ";

if ($member['ref1'] == 0) {
	$refname = "";
}
else {
	$refname = $db->fetchOne("SELECT username FROM members WHERE id=" . $member['ref1']);
}

echo "         <input name=\"refname\" type=\"text\" id=\"refname\" value=\"";
echo $refname;
echo "\" />

         (Leave empty to unassign referral)</td>
  </tr>
  <tr>
    <td>Membership:</td>
    <td>
        <select name=\"type\" id=\"type\">
            ";
$membershiplist = $db->query("SELECT id, name FROM membership ORDER BY price ASC");

while ($membership = $db->fetch_array($membershiplist)) {
	if ($membership['id'] == $member['type']) {
		echo "<option value=\"" . $membership['id'] . "\" selected>" . $membership['name'] . "</option>";
	}
  else {
	 echo "<option value=\"" . $membership['id'] . "\">" . $membership['name'] . "</option>";
  }
}

echo "        </select>    </td>
  </tr>
  <tr>
    <td>Membership Expires:</td>
    <td>
        ";

if ($member['upgrade_ends'] == 0) {
	echo "Never";
}
else {
	echo date("d-m-Y", $member['upgrade_ends']);
}

echo "    </td>
  </tr>
  <tr>
    <td>Extend Membership:<br />(Enter amount of days)<br /></td>
    <td><input type=\"text\" name=\"extend\" id=\"extend\" value=\"-1\" />
      (0 = Never Expires, -1 = does not make changes)</td>
  </tr>
  <tr>
    <td>Balance:</td>
    <td><input type=\"text\" name=\"money\" id=\"money\" value=\"";
echo $member['money'];
echo "\" /></td>
  </tr>
  <tr>
    <td>Purchase Balance:</td>
    <td><input type=\"text\" name=\"purchase_balance\" value=\"";
echo $member['purchase_balance'];
echo "\" /></td>
  </tr>
  <tr>
    <td>Points:</td>
    <td><input type=\"text\" name=\"points\" value=\"";
echo $member['points'];
echo "\" /></td>
  </tr>
  <tr>
    <td>PTC Ad Credits:</td>
    <td><input type=\"text\" name=\"ad_credits\" id=\"ad_credits\" value=\"";
echo $member['ad_credits'];
echo "\" /></td>
  </tr>
  <tr>
    <td>Login Ad Credits:</td>
    <td><input type=\"text\" name=\"loginads_credits\" id=\"loginads_credits\" value=\"";
echo $member['loginads_credits'];
echo "\" /></td>
  </tr>

  <tr>
    <td>Featured Ad Credits:</td>
    <td><input type=\"text\" name=\"fads_credits\" id=\"fads_credits\" value=\"";
echo $member['fads_credits'];
echo "\" /></td>
  </tr>
  <tr>
    <td>Featured Link Ad Credits:</td>
    <td><input type=\"text\" name=\"flink_credits\" id=\"flink_credits\" value=\"";
echo $member['flink_credits'];
echo "\" /></td>
  </tr>
  <tr>
    <td>Banner Ad Credits:</td>
    <td><input type=\"text\" name=\"banner_credits\" id=\"banner_credits\" value=\"";
echo $member['banner_credits'];
echo "\" /></td>
  </tr>
  <tr>
    <td>PTSU Credits:</td>
    <td><input type=\"text\" name=\"ptsu_credits\" id=\"ptsu_credits\" value=\"";
echo $member['ptsu_credits'];
echo "\" /></td>
  </tr>
  <tr>
    <td>PTSU Denied:</td>
    <td><input type=\"text\" name=\"ptsu_denied\" value=\"";
echo $member['ptsu_denied'];
echo "\" /></td>
  </tr>
  <tr>
    <td>Referrals:</td>
    <td><a href=\"./?view=members&do=search&ref1=";
echo $member['username'];
echo "\">";
echo $member['referrals'];
echo "</a></td>
  </tr>
  <tr>
    <td>Rented Referrals:</td>
    <td><a href=\"./?view=members&do=search&rented=";
echo $member['username'];
echo "\">";
echo $member['rented_referrals'];
echo "</a></td>
  </tr>
  <tr>
    <td>Admin notes<br />(for internal use):</td>
    <td><textarea name=\"adminnotes\" style=\"width:100%; height:100px\">";
echo $member['adminnotes'];
echo "</textarea></td>
  </tr>


  <tr>
    <td colspan=\"2\" align=\"center\">
        <input type=\"submit\" name=\"btn\" value=\"Update\" />
    </td>
  </tr>
</table>
</form>";
?>
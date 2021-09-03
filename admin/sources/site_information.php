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

$contrynum = $db->fetchOne("SELECT COUNT(*) AS NUM FROM country");
$statsquery = $db->query("SELECT * FROM statistics");

while ($list = $db->fetch_array($statsquery)) {
	$stats[$list['field']] = $list['value'];
}

$unreferred = $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE ref1='0'");
$rented = $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE rented!='0'");
$upgraded = $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE type!='1'");
$usersbalance = $db->fetchOne("SELECT SUM(money) FROM members");
$totalmembers = $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE username!='BOT'");
$timespaid = $db->fetchOne("SELECT COUNT(*) AS NUM FROM withdraw_history WHERE status='Completed'");
$active_members = $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE status='Active'");

if (!empty($pendingcashout)) {
	$pendingcashout = 1;
}

echo "                <div class=\"widget-title\">General Information</div>
                <div class=\"widget-content corner-all\">

        <table width=\"100%\" class=\"widget-tbl\">
          <tr>
            <td width=\"300\" align=\"right\">
           EvolutionScript Version:            </td>
            <td>
            ";
echo $software['version'];
echo "            </td>
          </tr>
          <tr>
            <td align=\"right\">
            Referrals Available for rent:            </td>
            <td>
             ";
echo rentedreferralsleft();
echo "            </td>
          </tr>
          <tr>
            <td align=\"right\">
             Rented Referrals:            </td>
           <td>
            ";
echo $rented;
echo "            </td>
          </tr>
          <tr>
            <td align=\"right\">
            Total upgraded members:            </td>
            <td>
             ";
echo $upgraded;
echo "            </td>
          </tr>
          <tr>
            <td align=\"right\">
            Total active members:            </td>
            <td>
             ";
echo $active_members;
echo "            </td>
          </tr>
          <tr>
            <td align=\"right\">
            Sum of all account balances:            </td>
            <td>
            \$";
echo round($usersbalance, 3);
echo "            </td>
          </tr>
          <tr>
            <td align=\"right\">
             Sum of all deposits:            </td>
            <td>
             \$";
echo $deposits;
echo "            </td>
          </tr>
          <tr>
            <td align=\"right\">
             Avarage account balance per member:            </td>
            <td>
             \$";

if ($totalmembers == 0) {
	echo 0;
}
else {
	echo round($usersbalance / $totalmembers, 3);
}

echo "            </td>
          </tr>
          <tr>
            <td align=\"right\">
             Total Paid:            </td>
            <td>
            \$";
echo $stats['cashout'];
echo "            </td>
          </tr>
          <tr>
            <td align=\"right\">
            Total Pending:            </td>
            <td>
            \$";
echo $pendingcashout;
echo "            </td>
          </tr>
          <tr>
            <td align=\"right\">
            Total times paid:            </td>
            <td>
            ";
echo $timespaid;
echo " x
            </td>
          </tr>
        </table>


</div>";
?>
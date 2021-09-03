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


if ($settings['payment_proof'] != "yes") {
	header("location: index.php");
	$db->close();
	exit();
}


if ($input->g['get'] == "quickview") {
	echo "<table width=\"100%\" class=\"widget-tbl\">
<tr class=\"titles\">
	<td width=\"25%\" align=\"center\">";
	echo $lang['txt']['username'];
	echo "</td>
    <td width=\"25%\" align=\"center\">";
	echo $lang['txt']['method'];
	echo "</td>
    <td width=\"25%\" align=\"center\">";
	echo $lang['txt']['amount'];
	echo "</td>
    <td width=\"25%\" align=\"center\">";
	echo $lang['txt']['date'];
	echo "</td>
</tr>
";
	$query = $db->query("SELECT * FROM withdraw_history WHERE status='Completed' ORDER BY date DESC LIMIT 10");

	while ($r = $db->fetch_array($query)) {
		$username = $db->fetchOne("SELECT username FROM members WHERE id=" . $r['user_id']);
		echo "    <tr>
    	<td>
       ";
		echo $username;
		echo "        </td>
    	<td align=\"center\">
        <img src=\"images/proofs/";
		echo $r['method'];
		echo ".gif\" />
        </td>
    	<td align=\"center\">
        \$";
		echo $r['amount'];
		echo "        </td>
    	<td align=\"center\">
        ";
		echo date("F jS, Y", $r['date']);
		echo "        </td>
    </tr>
    ";
	}

	echo "    </table>
    <a href=\"./?view=payment_proof\">View more &raquo;</a>
    ";
	$db->close();
	exit();
}

include SMARTYLOADER;
include INCLUDES . "class_pagination.php";
$allowed = array("date", "method", "amount", "user_id");
$paginator = new Pagination("withdraw_history", "status='Completed'");
$paginator->setMaxResult($settings['max_result_page']);
$paginator->setOrders("date", "DESC");
$paginator->setPage($input->gc['p']);
$paginator->allowedfield($allowed);
$paginator->setNewOrders($input->gc['orderby'], $input->gc['sortby']);
$paginator->setLink("./?view=payment_proof&");
$q = $paginator->getQuery();

while ($list = $db->fetch_array($q)) {
	$list['user_id'] = $db->fetchOne("SELECT username FROM members WHERE id=" . $list['user_id']);
	$items[] = $list;
}

$smarty->assign("paginator", $paginator);
$smarty->assign("thelist", $items);
unset($items);
$smarty->display("payment_proof.tpl");
$db->close();
exit();
?>
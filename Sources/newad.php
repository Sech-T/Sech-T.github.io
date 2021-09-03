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


if ($_SESSION['logged'] != "yes") {
	header("location: ./");
	exit();
}

include SMARTYLOADER;
$pages = array("ads", "login_ads", "banner_ads", "featured_ads", "featured_link", "ptsu_offers");
$pages_title = array($lang['txt']['ptcads'], $lang['txt']['loginads'], $lang['txt']['bannerad'], $lang['txt']['featuredad'], $lang['txt']['featuredlink'], $lang['txt']['ptsu']);

if (!empty($_REQUEST['class'])) {
	if (!in_array($_REQUEST['class'], $pages)) {
		header("location: index.php?view=account&page=manageads");
		exit();
	}

	$requested_class = $db->real_escape_string($_REQUEST['class']);
	$ads = $db->query("SELECT * FROM " . $requested_class . " WHERE user_id=" . $user_info['id']);

	while ($list = $db->fetch_array($ads)) {
		$adlist[] = $list;
	}

	$count = 0;

	while ($count < count($pages)) {
		if ($pages[$count] == $_REQUEST['class']) {
			$key = $count;
		}

		++$count;
	}


	if ($_REQUEST['class'] == "ads") {
		$listcountry = $db->query("SELECT country FROM ip2nationCountries ORDER BY country ASC");

		while ($list = $db->fetch_array($listcountry)) {
			$country[] = $list;
		}

		$smarty->assign("countrylist", $country);
		$listvalue = $db->query("SELECT * FROM ad_value ORDER BY value ASC");

		while ($list = $db->fetch_array($listvalue)) {
			$values[] = $list;
		}

		$smarty->assign("listvalue", $values);
	}
	else {
		if ($_REQUEST['class'] == "ptsu_offers") {
			$listcountry = $db->query("SELECT country FROM ip2nationCountries ORDER BY country ASC");

			while ($list = $db->fetch_array($listcountry)) {
				$country[] = $list;
			}

			$smarty->assign("countrylist", $country);
			$listvalue = $db->query("SELECT * FROM ptsu_value ORDER BY value ASC");

			while ($list = $db->fetch_array($listvalue)) {
				$values[] = $list;
			}

			$smarty->assign("listvalue", $values);
		}
	}

	$smarty->assign("referrer", $_SERVER['HTTP_REFERER']);
	$smarty->assign("page_title", $pages_title[$key]);
	$smarty->assign("page_id", $pages[$key]);
	$smarty->assign("pagesid", $pages);
	$smarty->assign("pages", $pages_title);
	$smarty->assign("adlist", $adlist);
	$smarty->assign("file_name", "newad.tpl");
	$smarty->display("account.tpl");
	$db->close();
	exit();
	return 1;
}

header("location: index.php?view=account&page=manageads");
$db->close();
exit();
?>
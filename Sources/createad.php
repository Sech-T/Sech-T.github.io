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
	verifyajax();
	serveranswer(0, "");
}

$pages = array("ads", "login_ads", "banner_ads", "featured_ads", "featured_link", "ptsu_offers");

if ($_REQUEST['a'] == "submit") {
	verifyajax();
	$title = cleanfrm($input->p['title']);
	$subtitle = cleanfrm($input->p['subtitle']);
	$url = trim($input->p['url']);
	$premium = cleanfrm($input->p['premium']);
	$country = $input->p['country'];
	$terms = $input->p['terms'];
	$banner = trim($input->p['banner']);
	$featuredad = nl2br(cleanfrm($input->p['featuredad']));
	$imgurl = trim($input->p['imgurl']);
	$advalue = $db->real_escape_string($input->p['advalue']);
	$instructions = cleanfrm($input->p['instructions']);

	if ($_REQUEST['class'] == "ads") {
		if (((empty($title) || empty($url)) || empty($premium)) || empty($terms)) {
			serveranswer(0, $lang['txt']['fieldsempty']);
		}


		if ($terms != "on") {
			serveranswer(0, $lang['txt']['acceptourtos']);
		}


		if (80 < strlen($subtitle)) {
			serveranswer(0, $lang['txt']['maximum_char_subtitle']);
		}


		if ($premium == "yes") {
			$memlist = $db->query("SELECT id FROM membership WHERE id!=1 ORDER BY id DESC");
			$premiumad .= ",";

			while ($row = $db->fetch_array($memlist)) {
				$premiumad .= $row['id'] . ",";
			}
		}
		else {
			$memlist = $db->query("SELECT id FROM membership ORDER BY id DESC");
			$premiumad .= ",";

			while ($row = $db->fetch_array($memlist)) {
				$premiumad .= $row['id'] . ",";
			}
		}


		if ($url == "http://" || $url == "") {
			serveranswer(0, $lang['txt']['enterurl']);
		}
		else {
			if (filter_var($url, FILTER_VALIDATE_URL) === false) {
				serveranswer(0, "Invalid url");
			}
		}


		if ($imgurl == "http://" || $imgurl == "") {
			$imgurl = "";
		}
		else {
			if (filter_var($imgurl, FILTER_VALIDATE_URL) === false) {
				serveranswer(0, "Invalid image");
			}
		}


		if (empty($country)) {
			serveranswer(0, $lang['txt']['selectcountry']);
		}

		$verifyvalue = $db->fetchOne("SELECT COUNT(*) AS NUM FROM ad_value WHERE id=" . $advalue);

		if ($verifyvalue == 0) {
			serveranswer(0, $lang['txt']['selectadvalue']);
		}
		else {
			$advalue = $db->fetchRow("SELECT id, value, time FROM ad_value WHERE id=" . $advalue);
		}

		$token = md5(time() . $user_info['id'] . $title);
		foreach ($country as $k => $v) {
			$countries .= stripslashes($v) . ",";
		}

		$set = array("user_id" => $user_info['id'], "token" => $token, "title" => $title, "descr" => $subtitle, "img" => $imgurl, "url" => $url, "time" => $advalue['time'], "value" => $advalue['value'], "category" => $advalue['id'], "membership" => $premiumad, "click_pack" => 0, "clicks" => 0, "outside_clicks" => 0, "country" => $countries, "clicks_day" => $input->p['clicks_day']);
		$insert = $db->insert("ads", $set);
		serveranswer(1, "");
		return 1;
	}


	if ($_REQUEST['class'] == "ptsu_offers") {
		if ((((empty($title) || empty($subtitle)) || empty($url)) || empty($premium)) || empty($terms)) {
			serveranswer(0, $lang['txt']['fieldsempty']);
		}


		if ($terms != "on") {
			serveranswer(0, $lang['txt']['acceptourtos']);
		}


		if ($premium == "yes") {
			$memlist = $db->query("SELECT id FROM membership WHERE id!=1 ORDER BY id DESC");
			$premiumad .= ",";

			while ($row = $db->fetch_array($memlist)) {
				$premiumad .= $row['id'] . ",";
			}
		}
		else {
			$memlist = $db->query("SELECT id FROM membership ORDER BY id DESC");
			$premiumad .= ",";

			while ($row = $db->fetch_array($memlist)) {
				$premiumad .= $row['id'] . ",";
			}
		}


		if ($url == "http://") {
			serveranswer(0, $lang['txt']['enterurl']);
		}


		if ($imgurl == "http://") {
			$imgurl = "";
		}


		if (empty($country)) {
			serveranswer(0, $lang['txt']['selectcountry']);
		}

		$verifyvalue = $db->fetchOne("SELECT COUNT(*) AS NUM FROM ptsu_value WHERE id=" . $advalue);

		if ($verifyvalue == 0) {
			serveranswer(0, $lang['txt']['selectadvalue']);
		}
		else {
			$advalue = $db->fetchOne("SELECT value FROM ptsu_value WHERE id=" . $advalue);
		}


		if ($settings['ptsu_approval'] == "yes") {
			$ptsustatus = "Pending";
		}
		else {
			$ptsustatus = "Inactive";
		}

		foreach ($country as $k => $v) {
			$countries .= $v . ",";
		}

		$set = array("user_id" => $user_info['id'], "title" => $title, "descr" => $subtitle, "instructions" => $instructions, "url" => $url, "value" => $advalue, "membership" => $premiumad, "country" => $countries, "status" => $ptsustatus);
		$insert = $db->insert("ptsu_offers", $set);
		serveranswer(1, "");
		return 1;
	}


	if ($_REQUEST['class'] == "banner_ads") {
		if (((empty($title) || empty($url)) || empty($banner)) || empty($terms)) {
			serveranswer(0, $lang['txt']['fieldsempty']);
		}


		if ($terms != "on") {
			serveranswer(0, $lang['txt']['acceptourtos']);
		}


		if ($url == "http://" || $banner == "http://") {
			serveranswer(0, $lang['txt']['fieldsempty']);
		}


		if ($settings['bannerads_approval'] != "yes") {
			$status = "Inactive";
		}
		else {
			$status = "Pending";
		}

		$set = array("user_id" => $user_info['id'], "title" => $title, "img" => $banner, "url" => $url, "credits" => 0, "status" => $status);
		$insert = $db->insert("banner_ads", $set);
		serveranswer(1, "");
		return 1;
	}


	if ($_REQUEST['class'] == "featured_ads") {
		if (((empty($title) || empty($url)) || empty($featuredad)) || empty($terms)) {
			serveranswer(0, $lang['txt']['fieldsempty']);
		}


		if ($terms != "on") {
			serveranswer(0, $lang['txt']['acceptourtos']);
		}


		if ($url == "http://") {
			serveranswer(0, $lang['txt']['fieldsempty']);
		}


		if ($settings['fads_approval'] != "yes") {
			$status = "Inactive";
		}
		else {
			$status = "Pending";
		}

		$set = array("user_id" => $user_info['id'], "title" => $title, "url" => $url, "ad" => $featuredad, "status" => $status);
		$insert = $db->insert("featured_ads", $set);
		serveranswer(1, "");
		return 1;
	}


	if ($_REQUEST['class'] == "featured_link") {
		if ((empty($title) || empty($url)) || empty($terms)) {
			serveranswer(0, $lang['txt']['fieldsempty']);
		}


		if ($terms != "on") {
			serveranswer(0, $lang['txt']['acceptourtos']);
		}


		if ($url == "http://") {
			serveranswer(0, $lang['txt']['fieldsempty']);
		}


		if ($settings['flinks_approval'] != "yes") {
			$status = "Inactive";
		}
		else {
			$status = "Pending";
		}

		$set = array("user_id" => $user_info['id'], "title" => $title, "url" => $url, "status" => $status);
		$insert = $db->insert("featured_link", $set);
		serveranswer(1, "");
		return 1;
	}


	if ($_REQUEST['class'] == "login_ads") {
		if (((empty($title) || empty($url)) || empty($terms)) || empty($banner)) {
			serveranswer(0, $lang['txt']['fieldsempty']);
		}


		if ($terms != "on") {
			serveranswer(0, $lang['txt']['acceptourtos']);
		}


		if ($url == "http://") {
			serveranswer(0, $lang['txt']['fieldsempty']);
		}


		if ($banner == "http://") {
			serveranswer(0, $lang['txt']['fieldsempty']);
		}


		if ($settings['loginads_approval'] != "yes") {
			$status = "Inactive";
		}
		else {
			$status = "Pending";
		}

		$set = array("user_id" => $user_info['id'], "title" => $title, "url" => $url, "image" => $banner, "status" => $status);
		$insert = $db->insert("login_ads", $set);
		serveranswer(1, "");
		return 1;
	}

	serveranswer(0, $lang['txt']['invalidrequest']);
	return 1;
}

serveranswer(0, $lang['txt']['invalidrequest']);
?>
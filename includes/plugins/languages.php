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

$language = $cache->get("languages");

if ($language == null) {
	$lq = $db->query("SELECT * FROM language WHERE version='" . $software['version'] . "' ORDER BY name DESC");

	while ($r = $db->fetch_array($lq)) {
		if ($r['default_lang'] == 1) {
			$default_language = $r['id'];
		}

		$langlist[$r['id']] = $r;
	}


	if (!is_array($langlist)) {
		$langlist[1] = array("id" => 1, "name" => "English (US)", "version" => $software['version'], "filename" => "english.php", "default_lang" => 1);
		$default_language = 1;
	}

	$language = array("default" => $default_language, "data" => $langlist);
	$cache->set("language", $language, 604800);
}


if (($settings['allowchangelanguage'] == "yes" && is_numeric($_GET['lang'])) || isset($_SESSION['language'])) {
	$current_lang = $language['default'];

	if (isset($input->g['lang'])) {
		$lang_id = $input->gc['lang'];
	}
	else {
		$lang_id = $_SESSION['language'];
	}


	if (!array_key_exists($lang_id, $language['data'])) {
		$filename = "languages/english.php";
		unset($lang_id);
		unset($_SESSION['language']);
	}
	else {
		$lang_data = $language['data'][$lang_id];
		$filename = "languages/" . $lang_data['filename'];
		$_SESSION['language'] = $lang_data['id'];
		$current_lang = $_SESSION['language'];
	}


	if (isset($input->g['lang'])) {
		header("location: ./");
		exit();
	}
}
else {
	$default_id = $language['default'];
	$lang = $language['data'][$default_id];
	$filename = "languages/" . $lang['filename'];

	if (!file_exists($filename)) {
		$filename = "languages/english.php";
	}

	$current_lang = $language['default'];
}

include $filename;

if ($settings['allowchangelanguage'] == "yes") {
	$langlist = array();
	foreach ($language['data'] as $k => $v) {
		$langlist[] = $v;
	}
}

?>
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


if (!$admin->permissions['utilities']) {
	header("location: ./");
	exit();
}

$modulepath = "../modules/admin";

if (is_dir($modulepath) !== true) {
	$show_error = "yes";
}
else {
	$handle = opendir($modulepath);
	$addonlist = array();

	while (($file = readdir($handle)) !== false) {
		if ((is_dir($modulepath . "/" . $file) === true && $file != ".") && $file != "..") {
			$addonlist[$file] = ucwords(str_replace("_", " ", $file));
		}
	}
}


if ($input->g['module']) {
	if (array_key_exists($input->g['module'], $addonlist)) {
		$module = cleanfrm($_GET['module']);
		$modulelink = "?view=addon_modules&module=" . $module;
		include SOURCES . "header.php";
		echo "
		<div class=\"site_title\">Modules Installed</div>
		<div class=\"site_content\">
        <div class=\"widget-main-title\">";
		echo $addonlist[$module];
		echo "</div>
		";
		include $modulepath . "/" . $module . "/" . $module . ".php";
		echo "		</div>
";
		include SOURCES . "footer.php";
		exit();
	}
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Modules Installed</div>
<div class=\"site_content\">
";

if ($show_error == "yes") {
	echo "<div class=\"errorbox\">Module directoy does not exist</div>";
}
else {
	if (is_array($addonlist)) {
		echo "<ul>";
		foreach ($addonlist as $k => $v) {
			echo "<li><a href=\"./?view=addon_modules&module=" . $k . "\">" . $v . "</a></li>";
		}

		echo "</ul>";
	}
}

echo "</div>

        ";
include SOURCES . "footer.php";
echo " ";
?>
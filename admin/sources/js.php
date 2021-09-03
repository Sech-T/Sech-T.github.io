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


if ($input->g['callback']) {
	$callback = $input->gc['callback'];
}
else {
	$callback = "c";
}

header("content-type: application/javascript");

if ($input->g['type'] == "map") {
	$q = $db->query("SELECT * FROM country ORDER BY users ASC");
	echo $callback . "([
";

	while ($r = $db->fetch_array($q)) {
		if ($r['name'] != "" && $r['users'] != 0) {
			$code = $db->fetchOne(("SELECT code FROM ip2nationCountries WHERE country='" . $r['name'] . "'"));
			$code = strtoupper($code);
			$data_country = array("code" => $code, "value" => $r['users'], "name" => $r['name']);
			echo "	{
";
			echo "		\"code\": \"" . $code . "\",
";
			echo "		\"value\": " . $r['users'] . ",
";
			echo "		\"name\": \"" . $r['name'] . "\",
";
			echo "	},
";
		}
	}

	echo "
]);";
}

?>
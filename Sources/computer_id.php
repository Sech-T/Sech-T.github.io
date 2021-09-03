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
	header("location:index.php");
}


if ($_REQUEST['action'] == "save" && $_SESSION['user_verified'] != 1) {
	$detected_id = $db->real_escape_string($input->p['detectedid']);
	$computer_id = $db->real_escape_string($input->p['computerid']);

	if (($computer_id != "undefined" && !empty($computer_id)) && $detected_id != "undefined") {
		if ($computer_id != $detected_id) {
			$verifydetected = $db->fetchOne(("SELECT COUNT(*) AS NUM FROM members WHERE computer_id='" . $detected_id . "'"));

			if ($verifydetected != 0) {
				$cheatersq = $db->query(("SELECT username FROM members WHERE computer_id='" . $detected_id . "'"));

				while ($usrcheater = $db->fetch_array($cheatersq)) {
					$cheaterlist .= "Username: <strong>" . $usrcheater['username'] . "</strong><br>";
				}

				$typecheat = 1;
				$message = "User was detected using multiaccounts and all multiaccounts were blocked:<br>" . $cheaterlist;
				$datstored = array("date" => TIMENOW, "type" => $typecheat, "log" => $message, "user_id" => $user_info['id']);
				$inset = $db->insert("cheat_log", $datstored);
				$block = $db->query(("UPDATE members SET status='Suspended' WHERE computer_id='" . $detected_id . "'"));
				$block = $db->query(("UPDATE members SET status='Suspended' WHERE computer_id='" . $computer_id . "'"));
				$db->close();
				exit();
			}

			$db->close();
			exit();
		}
	}
	else {
		if ($user_info['computer_stored'] == "no") {
			$upd = $db->query("UPDATE members SET computer_stored='yes' WHERE id=" . $user_info['id']);
		}
	}

	$_SESSION['user_verified'] = 1;
	$db->close();
	exit();
}

header("location:index.php");
$db->close();
exit();
?>
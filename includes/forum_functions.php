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

function verify_category($cat_id) {
	global $db;

	$verify_cat = $db->fetchOne("SELECT COUNT(*) AS NUM FROM forum_categories WHERE id=" . $cat_id);

	if ($verify_cat != 0) {
		return true;
	}

	return false;
}

function verify_board($board_id) {
	global $db;

	$verify_board = $db->fetchOne("SELECT COUNT(*) AS NUM FROM forum_boards WHERE id=" . $board_id);

	if ($verify_board != 0) {
		return true;
	}

	return false;
}

function verify_topic($topic_id) {
	global $db;

	$verify_topic = $db->fetchOne("SELECT COUNT(*) AS NUM FROM forum_posts WHERE id=" . $topic_id);

	if ($verify_topic != 0) {
		return true;
	}

	return false;
}

function get_category($cat_id) {
	global $db;

	$board = $db->fetchRow("SELECT * FROM forum_categories WHERE id=" . $cat_id);
	return $board;
}

function get_board($board_id) {
	global $db;

	$board = $db->fetchRow("SELECT * FROM forum_boards WHERE id=" . $board_id);
	return $board;
}

function get_topic($topic_id) {
	global $db;

	$board = $db->fetchRow("SELECT * FROM forum_posts WHERE id=" . $topic_id);
	return $board;
}

function board_checked($user_id, $board_id) {
	global $db;

	$verify_userboard = $db->fetchOne("SELECT COUNT(*) AS NUM FROM forum_log_boards WHERE id_member=" . $user_id . " and id_board=" . $board_id);

	if ($verify_userboard == 0) {
		$data = array("id_member" => $user_id, "id_board" => $board_id);
		$db->insert("forum_log_boards", $data);
	}

}

function board_recheck($user_id, $board_id) {
	global $db;

	$db->delete("forum_log_boards", "id_board=" . $board_id);
	$stored = array("id_member" => $user_id, "id_board" => $board_id);
	$db->insert("forum_log_boards", $stored);
}


if (!defined("EvolutionScript")) {
	exit("Hacking attempt...");
}

?>
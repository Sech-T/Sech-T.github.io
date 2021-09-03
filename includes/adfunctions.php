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

function addpoints($userid, $points) {
	global $db;

	$upd = $db->query("UPDATE members SET points=points+" . $points . " WHERE id=" . $userid);
}

function addptccredits($userid, $credits) {
	global $db;

	$upd = $db->query("UPDATE members SET ad_credits=ad_credits+" . $credits . " WHERE id=" . $userid);
}

function addptsucredits($userid, $credits) {
	global $db;

	$upd = $db->query("UPDATE members SET ptsu_credits=ptsu_credits+" . $credits . " WHERE id=" . $userid);
}

function addfadscredits($userid, $credits) {
	global $db;

	$upd = $db->query("UPDATE members SET fads_credits=fads_credits+" . $credits . " WHERE id=" . $userid);
}

function addbannercredits($userid, $credits) {
	global $db;

	$upd = $db->query("UPDATE members SET banner_credits=banner_credits+" . $credits . " WHERE id=" . $userid);
}

function addflinkcredits($userid, $credits) {
	global $db;

	$upd = $db->query("UPDATE members SET flink_credits=flink_credits+" . $credits . " WHERE id=" . $userid);
}

function addloginadcredits($userid, $credits) {
	global $db;

	$upd = $db->query("UPDATE members SET loginads_credits=loginads_credits+" . $credits . " WHERE id=" . $userid);
}

function addmembership($userid, $time, $type) {
	global $db;

	$timeupgrade = 60 * 60 * 24 * $time;
	$date_upg = time() + $timeupgrade;
	$upd = $db->query("UPDATE members SET type=" . $type . ", upgrade_ends='" . $date_upg . "' WHERE id=" . $userid);
}

function extendmembership($userid, $time) {
	global $db;

	$timeupgrade = 60 * 60 * 24 * $time;
	$upd = $db->query("UPDATE members SET upgrade_ends=upgrade_ends+" . $timeupgrade . " WHERE id=" . $userid);
}

function addboughtmembers($userid, $members) {
	global $db;
	global $settings;

	$days = $settings['buyref_days'];
	$clicks = $settings['buyref_clicks'];
	$daysago = TIMENOW - 60 * 60 * 24 * $days;

	if (0 < $days && $settings['buyref_filter'] == "enable") {
		$i = 1;

		while ($i <= $days) {
			if ($i == 1) {
				$dayquery .= "IF(chart_num=0,mc1,IF(chart_num=1,mc2,IF(chart_num=2,mc3,IF(chart_num=3,mc4,IF(chart_num=4,mc5,IF(chart_num=5,mc6,IF(chart_num=6,mc7,mc7)))))))+";
			}
			else {
				if ($i == 2) {
					$dayquery .= "IF(chart_num=0,mc7,IF(chart_num=1,mc1,IF(chart_num=2,mc2,IF(chart_num=3,mc3,IF(chart_num=4,mc4,IF(chart_num=5,mc5,IF(chart_num=6,mc6,mc6)))))))+";
				}
				else {
					if ($i == 3) {
						$dayquery .= "IF(chart_num=0,mc6,IF(chart_num=1,mc7,IF(chart_num=2,mc1,IF(chart_num=3,mc2,IF(chart_num=4,mc3,IF(chart_num=5,mc4,IF(chart_num=6,mc5,mc5)))))))+";
					}
					else {
						if ($i == 4) {
							$dayquery .= "IF(chart_num=0,mc5,IF(chart_num=1,mc6,IF(chart_num=2,mc7,IF(chart_num=3,mc1,IF(chart_num=4,mc2,IF(chart_num=5,mc3,IF(chart_num=6,mc4,mc4)))))))+";
						}
						else {
							if ($i == 5) {
								$dayquery .= "IF(chart_num=0,mc4,IF(chart_num=1,mc5,IF(chart_num=2,mc6,IF(chart_num=3,mc7,IF(chart_num=4,mc1,IF(chart_num=5,mc2,IF(chart_num=6,mc3,mc3)))))))+";
							}
							else {
								if ($i == 6) {
									$dayquery .= "IF(chart_num=0,mc3,IF(chart_num=1,mc4,IF(chart_num=2,mc5,IF(chart_num=3,mc6,IF(chart_num=4,mc7,IF(chart_num=5,mc1,IF(chart_num=6,mc2,mc2)))))))+";
								}
								else {
									$dayquery .= "IF(chart_num=0,mc2,IF(chart_num=1,mc3,IF(chart_num=2,mc4,IF(chart_num=3,mc5,IF(chart_num=4,mc6,IF(chart_num=5,mc7,IF(chart_num=6,mc1,mc1)))))))+";
								}
							}
						}
					}
				}
			}

			++$i;
		}

		$dayquery = "AND (" . substr($dayquery, 0, -1) . ">=" . $clicks . ")";
		$todayis = date("Y-m-d");
		$the_day = strftime("%Y-%m-%d", strtotime($todaysdate . " + " . $days . " days ago"));
		$sqldate = ("AND last_cron>='" . $the_day . "'");
	}

	$res = $db->query(("SELECT id FROM members WHERE ref1=0 AND (status='Active' AND id!=" . $userid . ") " . $dayquery . " ") . $sqldate . " ORDER BY Rand() LIMIT " . $members);

	while ($list = $db->fetch_array($res)) {
		$set = array("ref1" => $userid);
		$upd = $db->update("members", $set, "id=" . $list['id']);
	}

	$upd = $db->query("UPDATE members SET referrals=referrals+" . $members . ", myrefs1=myrefs1+" . $members . " WHERE id=" . $userid);
}

function addpurchasebalance($userid, $amount) {
	global $db;

	$upd = $db->query("UPDATE members SET purchase_balance=purchase_balance+" . $amount . " WHERE id=" . $userid);
}

function addrentreferrals($userid, $members) {
	global $db;
	global $settings;

	$days = $settings['rentref_days'];
	$clicks = $settings['rentref_clicks'];
	$daysago = TIMENOW - 60 * 60 * 24 * $days;

	if (0 < $days && $settings['rentref_filter'] == "enable") {
		$i = 1;

		while ($i <= $days) {
			if ($i == 1) {
				$dayquery .= "IF(chart_num=0,mc1,IF(chart_num=1,mc2,IF(chart_num=2,mc3,IF(chart_num=3,mc4,IF(chart_num=4,mc5,IF(chart_num=5,mc6,IF(chart_num=6,mc7,mc7)))))))+";
			}
			else {
				if ($i == 2) {
					$dayquery .= "IF(chart_num=0,mc7,IF(chart_num=1,mc1,IF(chart_num=2,mc2,IF(chart_num=3,mc3,IF(chart_num=4,mc4,IF(chart_num=5,mc5,IF(chart_num=6,mc6,mc6)))))))+";
				}
				else {
					if ($i == 3) {
						$dayquery .= "IF(chart_num=0,mc6,IF(chart_num=1,mc7,IF(chart_num=2,mc1,IF(chart_num=3,mc2,IF(chart_num=4,mc3,IF(chart_num=5,mc4,IF(chart_num=6,mc5,mc5)))))))+";
					}
					else {
						if ($i == 4) {
							$dayquery .= "IF(chart_num=0,mc5,IF(chart_num=1,mc6,IF(chart_num=2,mc7,IF(chart_num=3,mc1,IF(chart_num=4,mc2,IF(chart_num=5,mc3,IF(chart_num=6,mc4,mc4)))))))+";
						}
						else {
							if ($i == 5) {
								$dayquery .= "IF(chart_num=0,mc4,IF(chart_num=1,mc5,IF(chart_num=2,mc6,IF(chart_num=3,mc7,IF(chart_num=4,mc1,IF(chart_num=5,mc2,IF(chart_num=6,mc3,mc3)))))))+";
							}
							else {
								if ($i == 6) {
									$dayquery .= "IF(chart_num=0,mc3,IF(chart_num=1,mc4,IF(chart_num=2,mc5,IF(chart_num=3,mc6,IF(chart_num=4,mc7,IF(chart_num=5,mc1,IF(chart_num=6,mc2,mc2)))))))+";
								}
								else {
									$dayquery .= "IF(chart_num=0,mc2,IF(chart_num=1,mc3,IF(chart_num=2,mc4,IF(chart_num=3,mc5,IF(chart_num=4,mc6,IF(chart_num=5,mc7,IF(chart_num=6,mc1,mc1)))))))+";
								}
							}
						}
					}
				}
			}

			++$i;
		}

		$dayquery = "AND (" . substr($dayquery, 0, -1) . ">=" . $clicks . ")";
		$todayis = date("Y-m-d");
		$the_day = strftime("%Y-%m-%d", strtotime($todaysdate . " + " . $days . " days ago"));
		$sqldate = ("AND last_cron>='" . $the_day . "'");
		$extraq = $dayquery . " " . $sqldate;
	}


	if ($settings['rentype'] == 2) {
		$addrentedsql = " AND status='Active'";
	}
	else {
		if ($settings['rentype'] == 3) {
			$addrentedsql = " AND ref1=0";
		}
		else {
			if ($settings['rentype'] == 4) {
				$addrentedsql = " AND status='Active' AND ref1=0";
			}
		}
	}

	$countrefs = $db->fetchOne(("SELECT COUNT(*) AS NUM FROM members WHERE rented=0 " . $extraq . " ") . $addrentedsql . " AND id!=" . $userid);

	if ($countrefs < $members) {
		return "no";
	}

	$res = $db->query(("SELECT id FROM members WHERE rented=0 " . $extraq . " ") . $addrentedsql . " AND id!=" . $userid . " ORDER BY Rand() LIMIT " . $members);
	$onemonth = time() + 2592000;

	while ($list = $db->fetch_array($res)) {
		$set = array("rented" => $userid, "rented_time" => time(), "rented_expires" => $onemonth);
		$upd = $db->update("members", $set, "id=" . $list['id']);
	}

	$db->query("UPDATE members SET rented_referrals=rented_referrals+" . $members . " WHERE id=" . $userid);
	return "yes";
}

function rentedreferralsleft($userid = null) {
	global $settings;
	global $db;

	$days = $settings['rentref_days'];
	$clicks = $settings['rentref_clicks'];
	$daysago = TIMENOW - 60 * 60 * 24 * $days;

	if (0 < $days && $settings['rentref_filter'] == "enable") {
		$i = 1;

		while ($i <= $days) {
			if ($i == 1) {
				$dayquery .= "IF(chart_num=0,mc1,IF(chart_num=1,mc2,IF(chart_num=2,mc3,IF(chart_num=3,mc4,IF(chart_num=4,mc5,IF(chart_num=5,mc6,IF(chart_num=6,mc7,mc7)))))))+";
			}
			else {
				if ($i == 2) {
					$dayquery .= "IF(chart_num=0,mc7,IF(chart_num=1,mc1,IF(chart_num=2,mc2,IF(chart_num=3,mc3,IF(chart_num=4,mc4,IF(chart_num=5,mc5,IF(chart_num=6,mc6,mc6)))))))+";
				}
				else {
					if ($i == 3) {
						$dayquery .= "IF(chart_num=0,mc6,IF(chart_num=1,mc7,IF(chart_num=2,mc1,IF(chart_num=3,mc2,IF(chart_num=4,mc3,IF(chart_num=5,mc4,IF(chart_num=6,mc5,mc5)))))))+";
					}
					else {
						if ($i == 4) {
							$dayquery .= "IF(chart_num=0,mc5,IF(chart_num=1,mc6,IF(chart_num=2,mc7,IF(chart_num=3,mc1,IF(chart_num=4,mc2,IF(chart_num=5,mc3,IF(chart_num=6,mc4,mc4)))))))+";
						}
						else {
							if ($i == 5) {
								$dayquery .= "IF(chart_num=0,mc4,IF(chart_num=1,mc5,IF(chart_num=2,mc6,IF(chart_num=3,mc7,IF(chart_num=4,mc1,IF(chart_num=5,mc2,IF(chart_num=6,mc3,mc3)))))))+";
							}
							else {
								if ($i == 6) {
									$dayquery .= "IF(chart_num=0,mc3,IF(chart_num=1,mc4,IF(chart_num=2,mc5,IF(chart_num=3,mc6,IF(chart_num=4,mc7,IF(chart_num=5,mc1,IF(chart_num=6,mc2,mc2)))))))+";
								}
								else {
									$dayquery .= "IF(chart_num=0,mc2,IF(chart_num=1,mc3,IF(chart_num=2,mc4,IF(chart_num=3,mc5,IF(chart_num=4,mc6,IF(chart_num=5,mc7,IF(chart_num=6,mc1,mc1)))))))+";
								}
							}
						}
					}
				}
			}

			++$i;
		}

		$dayquery = "AND (" . substr($dayquery, 0, -1) . ">=" . $clicks . ")";
		$todayis = date("Y-m-d");
		$the_day = strftime("%Y-%m-%d", strtotime($todaysdate . " + " . $days . " days ago"));
		$sqldate = ("AND last_cron>='" . $the_day . "'");
		$extraq = $dayquery . " " . $sqldate;
	}


	if ($settings['rentype'] == 2) {
		$addrentedsql = " AND status='Active'";
	}
	else {
		if ($settings['rentype'] == 3) {
			$addrentedsql = " AND ref1=0";
		}
		else {
			if ($settings['rentype'] == 4) {
				$addrentedsql = " AND status='Active' AND ref1=0";
			}
		}
	}


	if ($userid != null) {
		$refs_available = $db->fetchOne(("SELECT COUNT(*) AS NUM FROM members WHERE rented=0 " . $extraq . " ") . $addrentedsql . " AND id!=" . $userid);
	}
	else {
		$refs_available = $db->fetchOne(("SELECT COUNT(*) AS NUM FROM members WHERE rented=0 " . $extraq . " ") . $addrentedsql);
	}

	return $refs_available;
}

function referralsleft($userid = null) {
	global $db;
	global $settings;

	$days = $settings['buyref_days'];
	$clicks = $settings['buyref_clicks'];
	$daysago = TIMENOW - 60 * 60 * 24 * $days;

	if (0 < $days && $settings['buyref_filter'] == "enable") {
		$i = 1;

		while ($i <= $days) {
			if ($i == 1) {
				$dayquery .= "IF(chart_num=0,mc1,IF(chart_num=1,mc2,IF(chart_num=2,mc3,IF(chart_num=3,mc4,IF(chart_num=4,mc5,IF(chart_num=5,mc6,IF(chart_num=6,mc7,mc7)))))))+";
			}
			else {
				if ($i == 2) {
					$dayquery .= "IF(chart_num=0,mc7,IF(chart_num=1,mc1,IF(chart_num=2,mc2,IF(chart_num=3,mc3,IF(chart_num=4,mc4,IF(chart_num=5,mc5,IF(chart_num=6,mc6,mc6)))))))+";
				}
				else {
					if ($i == 3) {
						$dayquery .= "IF(chart_num=0,mc6,IF(chart_num=1,mc7,IF(chart_num=2,mc1,IF(chart_num=3,mc2,IF(chart_num=4,mc3,IF(chart_num=5,mc4,IF(chart_num=6,mc5,mc5)))))))+";
					}
					else {
						if ($i == 4) {
							$dayquery .= "IF(chart_num=0,mc5,IF(chart_num=1,mc6,IF(chart_num=2,mc7,IF(chart_num=3,mc1,IF(chart_num=4,mc2,IF(chart_num=5,mc3,IF(chart_num=6,mc4,mc4)))))))+";
						}
						else {
							if ($i == 5) {
								$dayquery .= "IF(chart_num=0,mc4,IF(chart_num=1,mc5,IF(chart_num=2,mc6,IF(chart_num=3,mc7,IF(chart_num=4,mc1,IF(chart_num=5,mc2,IF(chart_num=6,mc3,mc3)))))))+";
							}
							else {
								if ($i == 6) {
									$dayquery .= "IF(chart_num=0,mc3,IF(chart_num=1,mc4,IF(chart_num=2,mc5,IF(chart_num=3,mc6,IF(chart_num=4,mc7,IF(chart_num=5,mc1,IF(chart_num=6,mc2,mc2)))))))+";
								}
								else {
									$dayquery .= "IF(chart_num=0,mc2,IF(chart_num=1,mc3,IF(chart_num=2,mc4,IF(chart_num=3,mc5,IF(chart_num=4,mc6,IF(chart_num=5,mc7,IF(chart_num=6,mc1,mc1)))))))+";
								}
							}
						}
					}
				}
			}

			++$i;
		}

		$dayquery = "AND (" . substr($dayquery, 0, -1) . ">=" . $clicks . ")";
		$todayis = date("Y-m-d");
		$the_day = strftime("%Y-%m-%d", strtotime($todaysdate . " + " . $days . " days ago"));
		$sqldate = ("AND last_cron>='" . $the_day . "'");
	}


	if ($userid != null) {
		$refs_available = $db->fetchOne((("SELECT COUNT(*) AS NUM FROM members WHERE ref1='0' AND status='Active' AND username!='BOT' AND id!=" . $userid . " ") . $dayquery . " ") . $sqldate);
	}
	else {
		$refs_available = $db->fetchOne(("SELECT COUNT(*) AS NUM FROM members WHERE ref1='0' AND status='Active' AND username!='BOT' " . $dayquery . " ") . $sqldate);
	}

	return $refs_available;
}

function recycle($userid, $refid) {
	global $db;

	$rented_expires = $db->fetchOne("SELECT rented_expires FROM members WHERE id=" . $refid);
	$newref = $db->fetchOne("SELECT id FROM members WHERE rented=0 AND id!='" . $userid . "' ORDER BY Rand() LIMIT 1");
	$data = array("rented" => $userid, "rented_time" => time(), "rented_expires" => $rented_expires);
	$upd = $db->update("members", $data, "id=" . $newref);
	$data = array("rented" => 0, "rented_time" => 0, "rented_expires" => 0, "rented_clicks" => 0, "rented_lastclick" => 0, "rented_earned" => 0, "rented_autopay" => 0);
	$upd = $db->update("members", $data, "id=" . $refid);
}


if (!defined("EvolutionScript")) {
	exit("Hacking attempt...");
}

?>
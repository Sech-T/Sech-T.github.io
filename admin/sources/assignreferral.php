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


if ($input->p['do'] == "update") {
	verifyajax();
	verifydemo();
	$userid = $db->fetchOne(("SELECT id FROM members WHERE username='" . $input->pc['username'] . "'"));
	$refs2buy = referralsleft($userid);
	$refs2rent = rentedreferralsleft($userid);

	if (!$userid) {
		serveranswer(0, "Invalid username");
	}


	if (!is_numeric($input->p['refs'])) {
		serveranswer(0, "Enter an amount of referrals to assign");
	}

	switch ($input->p['dothings']) {
		case "direct":
			if ($refs2buy < $input->pc['refs']) {
				serveranswer(0, "There are not enough referrals to assign.");
			}
			else {
				addboughtmembers($userid, $input->pc['refs']);
				serveranswer(1, $input->pc['refs'] . " direct referral(s) were added to " . $input->pc['username']);
			}
			break;

		case "rented":
			if ($refs2rent < $input->pc['refs']) {
				serveranswer(0, "There are not enough referrals to assign.");
			}
			else {
				addrentreferrals($userid, $input->pc['refs']);
				serveranswer(1, $input->pc['refs'] . " rented referral(s) were added to " . $input->pc['username']);
			}
			break;

		default:
			serveranswer(0, "Select a Referral Type");
			break;
	}
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Assign Referrals</div>
<div class=\"site_content\">
	<div class=\"info_box\">
    <strong>Referrals available sell:</strong> ";
echo referralsleft();
echo "<br />
<strong>Referrals available to rent:</strong> ";
echo rentedreferralsleft();
echo "</div>
<form method=\"post\" id=\"frm1\" onsubmit=\"return submitform(this.id);\">
<input type=\"hidden\" name=\"do\" value=\"update\" />
<table class=\"widget-tbl\" width=\"100%\">
  <tr>
    <td width=\"150\">Username</td>
    <td><input type=\"text\" name=\"username\" id=\"username\" /></td>
  </tr>
  <tr>
    <td>Referrals</td>
    <td><input type=\"text\" name=\"refs\" id=\"refs\" /></td>
  </tr>
  <tr>
    <td>Referrals Type</td>
    <td><select name=\"dothings\">
    		<option value=\"\">Select One</option>
            <option value=\"direct\">Direct Referral</option>
            <option value=\"rented\">Rented Referral</option>
            </select></td>
  </tr>
  <tr>
  	<td></td>
    <td>
  		<input type=\"submit\" name=\"save\" value=\"Send\" class=\"orange\" />
     </td>
  </tr>
</table>
</form>

</div>


        ";
include SOURCES . "footer.php";
echo " ";
?>
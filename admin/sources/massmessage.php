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


if (!$admin->permissions['send_messages']) {
	header("location: ./");
	exit();
}


if ($input->p['a'] == "sendmessage") {
	verifyajax();
	verifydemo();
	$required_fields = array("subject", "message", "receiverlist");
	foreach ($required_fields as $k) {

		if (!$input->p[$k]) {
			serveranswer(0, "One of the required field(s) is empty.");
			continue;
		}
	}


	if ($input->p['receiverlist'] == "single") {
		$userid = getuserid($input->pc['username']);

		if ($userid == 0) {
			serveranswer(0, "Username <strong>" . $username . "</strong> was not found");
		}

		$userdetails = $db->fetchRow("SELECT id, fullname, username, money, purchase_balance, pending_withdraw, email FROM members WHERE id=" . $userid);
		$oldphrase = array("%fullname%", "%username%", "%balance%", "%purchase_balance%", "%pending_withdrawal%");
		$newphrase = array($userdetails['fullname'], $userdetails['username'], $userdetails['money'], $userdetails['purchase_balance'], $userdetails['pending_withdraw']);
		$message = str_replace($oldphrase, $newphrase, $input->pc['message']);
		$data = array("user_from" => 0, "user_to" => $userdetails['id'], "subject" => $input->pc['subject'], "message" => $message, "date" => TIMENOW);
		$insert = $db->insert("messages", $data);
		serveranswer(2, "Message was sent to <strong>" . $input->pc['username'] . "</strong>");
	}
	else {
		if (!$input->p['page'] || !is_numeric($input->p['page'])) {
			$page = 1;
		}
		else {
			$page = $input->pc['page'];
		}


		if (!is_numeric($input->p['massamount'])) {
			$max_display = 5;
		}
		else {
			$max_display = $input->p['massamount'];
		}

		$from = $max_display * $page - $max_display;
		$countmember = $db->fetchOne("SELECT COUNT(*) AS NUM FROM members WHERE status='Active' AND username!='BOT'");
		$usersquery = $db->query("SELECT id, fullname, username, money, purchase_balance, pending_withdraw, email FROM members WHERE status='Active' AND username!='BOT' ORDER BY id ASC LIMIT " . $from . ", " . $max_display);
		$total_pages = ceil($countmember / $max_display);

		while ($userdetails = $db->fetch_array($usersquery)) {
			$oldphrase = array("%fullname%", "%username%", "%balance%", "%pending_withdrawal%", "%purchase_balance%");
			$newphrase = array($userdetails['fullname'], $userdetails['username'], $userdetails['money'], $userdetails['pending_withdraw'], $userdetails['purchase_balance']);
			$message = str_replace($oldphrase, $newphrase, $input->pc['message']);
			$data = array("user_from" => 0, "user_to" => $userdetails['id'], "subject" => $input->pc['subject'], "message" => $message, "date" => TIMENOW);
			$insert = $db->insert("messages", $data);
			$textsent .= "<i>Message sent to " . $userdetails['username'] . ".</i><br>";
		}

		$textsent .= "<br><strong>Please wait...</strong>";

		if ($page == $total_pages) {
			serveranswer(2, "Messages were sent to all members.");
		}
		else {
			$nextpage = $page + 1;
			serveranswer(4, "$(\"#sendmessage\").l2success(\"" . $textsent . "\"); $(\"#pagenum\").val(" . $nextpage . "); setTimeout('$(\"#sendmessage\").l2unblock(); submitform(\"sendmessage\");', 5000)");
		}
	}
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">On-Site Messages</div>
<div class=\"site_content\">
     <form method=\"post\" onsubmit=\"$('#pagenum').val(1); return submitform(this.id);\" id=\"sendmessage\">
    <input type=\"hidden\" name=\"a\" value=\"sendmessage\" />
    <input type=\"hidden\" name=\"page\" id=\"pagenum\" value=\"1\" />
    <table cellpadding=\"4\" width=\"100%\" class=\"widget-tbl\">
  <tr>
    <td width=\"150\">Receiver List</td>
    <td>
    <select name=\"receiverlist\" id=\"receiverlist\" onchange=\"receivertype();\">
    	<option value=\"\"></option>
        <option value=\"all\">All members</option>
        <option value=\"single\" ";

if ($input->g['member']) {
	echo "selected";
}

echo ">A single member</option>
    </select>
    </td>
  </tr>
  <tbody id=\"singlemember\" ";

if (!$input->g['member']) {
	echo "style=\"display:none\"";
}

echo ">
  <tr>
    <td width=\"150\">Username:</td>
    <td>
    <input name=\"username\" type=\"text\" id=\"username\" value=\"";
echo $input->gc['member'];
echo "\" />
      </td>
  </tr>
  </tbody>
      <tr>
        <td>Subject:</td>
        <td><input name=\"subject\" type=\"text\" /></td>
      </tr>
      <tr>
        <td>Message</td>
        <td><textarea name=\"message\" id=\"message\" class=\"messagearea\" style=\"width:90%; height:150px\"></textarea></td>
      </tr>
       <tbody id=\"maxperpage\" ";

if ($input->gc['member']) {
	echo "style=\"display:none\"";
}

echo ">
      <tr>
        <td>Max messages per page</td>
            <td>
            <select name=\"massamount\">
                <option value=\"5\">5</option>
                <option value=\"10\">10</option>
                <option value=\"25\">25</option>
                <option value=\"50\">50</option>
                <option value=\"100\">100</option>
                <option value=\"500\">500</option>
            </select>        </td>
      </tr>
      </tbody>
      <tr>
        <td>Available Merge Fields</td>
        <td><table width=\"100%\">
          <tr>
            <td width=\"120\">Full Name:</td>
            <td>%fullname%</td>
          </tr>
          <tr>
            <td>Username:</td>
            <td>%username%</td>
          </tr>
          <tr>
            <td>Balanace:</td>
            <td>%balance%</td>
          </tr>
          <tr>
            <td>Pending Withdrawal:</td>
            <td>%pending_withdrawal%</td>
          </tr>
          <tr>
          	<td>Purchase Balance:</td>
            <td>%purchase_balance%</td>
          </tr>
        </table>      </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type=\"submit\" name=\"send\" value=\"Send\" />        </td>
        </tr>
    </table>
    </form>
</div>
        ";
include SOURCES . "footer.php";
echo " ";
?>
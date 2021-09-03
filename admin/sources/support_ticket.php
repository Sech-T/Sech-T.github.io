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

$ticket_info = $db->fetchRow("SELECT * FROM helpdesk_ticket WHERE id=" . $input->gc['showt']);

if ($input->p['do'] == "update") {
	verifyajax();
	verifydemo();
	$newmsg = $input->pc['newmsg'];
	$msgid = $input->pc['msgid'];

	if (empty($newmsg)) {
		serveranswer(0, "Message can not be empty.");
	}


	if ($msgid == 0) {
		$data = array("message" => $newmsg);
		$db->update("helpdesk_ticket", $data, "id=" . $ticket_info['id']);
	}
	else {
		$data = array("message" => $newmsg);
		$db->update("helpdesk_replies", $data, "id=" . $msgid);
	}

	serveranswer(6, "hideeditmsg(" . $msgid . "); $('#msgtxt-" . $msgid . "').html('" . addslashes($newmsg) . "');");
}
else {
	if ($input->p['do'] == "delete") {
		verifyajax();
		verifydemo();
		$msgid = $input->pc['msgid'];

		if ($msgid == 0) {
			$db->delete("helpdesk_ticket", "id=" . $ticket_info['id']);
			$db->delete("helpdesk_replies", "ticket_id=" . $ticket_info['id']);
			serveranswer(4, "location.href=\"./?view=support\";");
		}
		else {
			$db->delete("helpdesk_replies", "id=" . $msgid);
			serveranswer(6, "$(\"#conversation-" . $msgid . "\").remove();");
		}
	}
	else {
		if ($input->p['do'] == "reply") {
			if ($settings['demo'] == "yes") {
				$error_msg = "This is not possible in this demo version";
			}
			else {
				if (empty($input->pc['replymsg'])) {
					$error_msg = "Enter a message to reply.";
				}
				else {
					if ($input->p['sesion_id'] != $_SESSION['sesion_id']) {
						$error_msg = "Invalid token try again please";
					}
					else {
						$replymsg = $input->pc['replymsg'];
						$stored = array("ticket_id" => $ticket_info['id'], "user_reply" => 0, "message" => $replymsg, "date" => TIMENOW);
						$db->insert("helpdesk_replies", $stored);
						$tstatus = ($input->p['close_ticket'] ? 4 : 2);
						$db->query("UPDATE helpdesk_ticket SET last_update='" . TIMENOW . ("', status=" . $tstatus . " WHERE id=" . $ticket_info['id']));
						$str2find = array("%site_name%", "%site_url%", "%ticket_id%");
						$str2change = array($settings['site_name'], $settings['site_url'], $ticket_info['ticket']);
						$data_mail = array("mail_id" => "support_ticket_answer", "str2find" => $str2find, "str2change" => $str2change, "receiver" => $ticket_info['email']);
						$mail = new MailSystem($data_mail);
						$mail->send();
						$success_msg = 1;
					}
				}
			}
		}
	}
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Ticket #";
echo $ticket_info['ticket'];
echo "</div>
<div class=\"site_content\">
	<div class=\"widget-title\">Ticket Information</div>
    <div class=\"widget-content\">
    <table width=\"100%\" class=\"widget-tbl\">
      <tr>
        <td width=\"150\"><strong>Ticket ID</strong></td>
        <td style=\"color:#000099\">";
echo $ticket_info['ticket'];
echo "</td>
      </tr>
      ";

if ($ticket_info['user_id'] != 0) {
	echo "      <tr>
        <td  ><strong>Username</strong></td>
        <td  >
        ";
	$username = $db->fetchOne("SELECT username FROM members WHERE id=" . $ticket_info['user_id']);
	echo "<a href='./?view=members&edit=" . $ticket_info['user_id'] . "'><strong>" . $username . "</strong></a>";
	echo "        </td>
      </tr>
      ";
}
else {
	echo "      <tr>
        <td  ><strong>Name</strong></td>
        <td  >";
	echo $ticket_info['name'];
	echo "</td>
      </tr>
      <tr>
        <td  ><strong>E-mail</strong></td>
        <td  >";
	echo $ticket_info['email'];
	echo "</td>
      </tr>
      ";
}

echo "      <tr>
        <td ><strong>Ticket Added</strong></td>
        <td >";
echo date('dS M, Y \a\t H:i', $ticket_info['date']);
echo "</td>
      </tr>
      <tr>
        <td ><strong>Ticket Status</strong></td>
        <td  >";
echo "<span style='color:" . $statuscolours[$ticket_info['status']] . ";'>" . $ticketstatus[$ticket_info['status']] . "</span>";
echo "</td>
      </tr>
      <tr>
        <td ><strong>Ticket Subject</strong></td>
        <td  >";
echo $ticket_info['subject'];
echo "</td>
      </tr>
    </table>
    </div>
    <div class=\"widget-title\">Conversation</div>
    <fieldset class=\"ticket-user\" id=\"conversation-0\">
    <legend>Member, ";
echo date('l, F j, Y \a\t h:i a', $ticket_info['date']);
echo "</legend>
        <form id=\"formsg-0\" method=\"post\" onsubmit=\"return submitform(this.id)\">
        <input type=\"hidden\" name=\"msgid\" value=\"0\">
        <input type=\"hidden\" name=\"do\" value=\"\" id=\"action0\" />
        <div  id=\"msg-0\">
        	<span id=\"msgtxt-0\">";
echo nl2br($ticket_info['message']);
echo "</span>
        	<div style=\"margin-top:5px\">
                <a href=\"javascript:void(0)\" onclick=\"showeditmsg(0)\">Edit</a> |
                <a href=\"javascript:void(0)\" onclick=\"updfrmvars({'action0': 'delete'}); submitform('formsg-0');\">Delete</a>
          	</div>
        </div>
        <div style=\"margin-top:5px; display:none\" id=\"edit-0\">
        	<textarea style=\"width:90%; height:60px\" id=\"msgtxt-0\" name=\"newmsg\">";
echo $ticket_info['message'];
echo "</textarea>
        	<div style=\"margin-top:5px\">
            <input type=\"submit\" value=\"Save\" onclick=\"updfrmvars({'action0': 'update'});\" />
            <input type=\"button\" class=\"cancel\" value=\"Cancel\" onclick=\"hideeditmsg(0)\">
            </div>
        </div>
        </form>
    </fieldset>
    ";
$q = $db->query("SELECT * FROM helpdesk_replies WHERE ticket_id=" . $ticket_info['id'] . " ORDER BY date ASC");

while ($r = $db->fetch_array($q)) {
	echo "    <fieldset class=\"";
	echo $r['user_reply'] == 0 ? "ticket-admin" : "ticket-user";
	echo "\" id=\"conversation-";
	echo $r['id'];
	echo "\">
    <legend>";
	echo $r['user_reply'] == 0 ? "You" : "Member";
	echo ", ";
	echo date('l, F j, Y \a\t h:i a', $r['date']);
	echo "</legend>
        <form id=\"formsg-";
	echo $r['id'];
	echo "\" method=\"post\" onsubmit=\"return submitform(this.id)\">
        <input type=\"hidden\" name=\"msgid\" value=\"";
	echo $r['id'];
	echo "\">
        <input type=\"hidden\" name=\"do\" value=\"\" id=\"action";
	echo $r['id'];
	echo "\" />
        <div  id=\"msg-";
	echo $r['id'];
	echo "\">
        	<span id=\"msgtxt-";
	echo $r['id'];
	echo "\">";
	echo nl2br($r['message']);
	echo "</span>
        	<div style=\"margin-top:5px\">
                <a href=\"javascript:void(0)\" onclick=\"showeditmsg(";
	echo $r['id'];
	echo ")\">Edit</a> |
                <a href=\"javascript:void(0)\" onclick=\"updfrmvars({'action";
	echo $r['id'];
	echo "': 'delete'}); submitform('formsg-";
	echo $r['id'];
	echo "');\">Delete</a>
          	</div>
        </div>
        <div style=\"margin-top:5px; display:none\" id=\"edit-";
	echo $r['id'];
	echo "\">
        	<textarea style=\"width:90%; height:60px\" id=\"msgtxt-";
	echo $r['id'];
	echo "\" name=\"newmsg\">";
	echo $r['message'];
	echo "</textarea>
        	<div style=\"margin-top:5px\">
            <input type=\"submit\" value=\"Save\" onclick=\"updfrmvars({'action";
	echo $r['id'];
	echo "': 'update'});\" />
            <input type=\"button\" class=\"cancel\" value=\"Cancel\" onclick=\"hideeditmsg(";
	echo $r['id'];
	echo ")\">
            </div>
        </div>
        </form>
    </fieldset>

    ";
}

echo "    		";

if ($error_msg) {
	echo "<div class=\"error_box\">" . $error_msg . "</div>";
}


if ($success_msg) {
	echo "<div class=\"success_box\">Message was added.</div>";
}

echo "	<form method=\"post\" name=\"reply\" id=\"reply\" action=\"./?view=support&showt=";
echo $ticket_info['id'];
echo "#reply\">
	<input type=\"hidden\" name=\"do\" value=\"reply\">
    <input type=\"hidden\" name=\"sesion_id\" value=\"";
echo sesion_id();
echo "\" />
	<div align=\"center\" style=\"padding-top:5px\">
    <table width=\"100%\">
    	<tr>
        	<td colspan=\"2\"><textarea name=\"replymsg\" style=\"height:100px; width:90%\">";
echo $input->p['replymsg'] == "" ? "


" . $admin->getSignature() : $input->p['replymsg'];
echo "</textarea>
            </td>
        </tr>
        <tr>
        	<td align=\"right\"><input type=\"submit\" name=\"send\" value=\"Answer\"></td>
        	<td width=\"50%\"><label><input type=\"checkbox\" name=\"close_ticket\" /> Close this ticket after reply</label></td>

        </tr>
    </table>


    </div>
	</form>
</div>
";
include SOURCES . "footer.php";
echo " ";
?>
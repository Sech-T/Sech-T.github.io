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


if (!$admin->permissions['support']) {
	header("location: ./");
	exit();
}


if ($input->p['do'] == "save") {
	verifyajax();
	verifydemo();
	$helpdesk_enable = $input->pc['helpdesk_enable'];
	$members_only = $input->pc['members_only'];
	$upd = $db->query("UPDATE helpdesk_settings SET value='" . $helpdesk_enable . "' WHERE field='helpdesk_enable'");
	$upd = $db->query("UPDATE helpdesk_settings SET value='" . $members_only . "' WHERE field='members_only'");
	$cache->delete("members_support");
	serveranswer(1, "Settings where saved.");
}
else {
	if ($input->p['do'] == "create") {
		$department_name = $input->pc['department_name'];

		if ($settings['demo'] == "yes") {
			$error_msg = "This is not possible in this demo version";
		}
		else {
			if (empty($department_name)) {
				$error_msg = "Please enter a department name";
			}
			else {
				$stored = array("name" => $department_name);
				$db->insert("helpdesk_department", $stored);
				$success_msg = 1;
			}
		}
	}
	else {
		if ($input->p['do'] == "delete") {
			verifyajax();
			verifydemo();
			$department_id = $input->pc['depid'];
			$ticketdpts = $db->query("SELECT id FROM helpdesk_ticket WHERE department=" . $department_id);

			while ($row = $db->fetch_array($ticketdpts)) {
				$db->delete("helpdesk_replies", "ticket_id=" . $row['id']);
			}

			$db->delete("helpdesk_ticket", "department=" . $department_id);
			$db->delete("helpdesk_department", "id=" . $department_id);
			serveranswer(6, "$(\"#dep" . $department_id . "\").remove();");
		}
		else {
			if ($input->p['do'] == "update") {
				verifyajax();
				verifydemo();
				$department_id = $input->pc['depid'];
				$depname = $input->p['name'][$input->pc['depid']];
				$data = array("name" => $depname);
				$db->update("helpdesk_department", $data, "id=" . $department_id);
				serveranswer(1, "Department name was updated.");
			}
		}
	}
}

$query = $db->query("SELECT * FROM helpdesk_settings");

while ($result = $db->fetch_array($query)) {
	$support[$result['field']] = $result['value'];
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Support Settings</div>
<div class=\"site_content\">
<div id=\"tabs\">
	<ul>
    	<li><a href=\"#tabs-1\">General Settings</a></li>
        <li><a href=\"#tabs-2\">Departments Manager</a></li>
    </ul>
    <div id=\"tabs-1\">
        <form method=\"post\" id=\"supportsettings\" onsubmit=\"return submitform(this.id)\">
        <input type=\"hidden\" name=\"do\" value=\"save\" />
        <table class=\"widget-tbl\" width=\"100%\">
          <tr>
            <td>Helpdesk Enable</td>
            <td valign=\"top\"><input type=\"checkbox\" name=\"helpdesk_enable\" value=\"yes\" ";

if ($support['helpdesk_enable'] == "yes") {
	echo "checked";
}

echo " />
        Tick to enable - you can turn off your helpdesk unchecked this option</td>
          </tr>
          <tr>
            <td>Members only</td>
            <td valign=\"top\"><input type=\"checkbox\" name=\"members_only\" value=\"yes\" ";

if ($support['members_only'] == "yes") {
	echo "checked";
}

echo " />
        Tick to enable - helpdesk will be enable for members only, no-members can not contact to your site staff</td>
          </tr>
          <tr>
          	<td></td>
            <td>
            <input type=\"submit\" name=\"support_settings\" value=\"Save\" />
            </td>
          </tr>
        </table>
        </form>
    </div>
    <div id=\"tabs-2\">
    	<div class=\"widget-title\">Add new department</div>
        <div class=\"widget-content\">
    		";

if ($error_msg) {
	echo "<div class=\"error_box\">" . $error_msg . "</div>";
}


if ($success_msg) {
	echo "<div class=\"success_box\">New department was added.</div>";
}

echo "        <form method=\"post\" action=\"./?view=support_settings#tabs-2\">
        <input type=\"hidden\" name=\"do\" value=\"create\" />
        <table class=\"widget-tbl\" width=\"100%\">
          <tr>
            <td width=\"150\">Add a New Department:</td>
            <td valign=\"top\" width=\"150\"><input name=\"department_name\" id=\"department_name\" type=\"text\" /></td>
            <td>
                <input type=\"submit\" name=\"send\" value=\"Create\" class=\"orange\" />
            </td>
          </tr>
        </table>
        </form>
        </div>

        <div class=\"widget-title\">Manage Departments</div>
        <form method=\"post\" id=\"frm3\" onsubmit=\"return submitform(this.id);\">
        <input type=\"hidden\" name=\"depid\" id=\"depid\" value=\"0\" />
        <input type=\"hidden\" name=\"do\" id=\"depaction\" value=\"\" />
        <table width=\"100%\" class=\"widget-tbl\">
            <tr class=\"titles\">
                <td>Department name</td>
                <td>Tickets Open</td>
                <td>Tickets Answered</td>
                <td>Tickets Awaiting Reply</td>
                <td>Tickets Closed</td>
                <td></td>
            </tr>
            ";
$query = $db->query("SELECT * FROM helpdesk_department ORDER BY id ASC");

while ($r = $db->fetch_array($query)) {
	$tr = ($tr == "tr1" ? "tr2" : "tr1");
	echo "            <tr class=\"";
	echo $tr;
	echo "\" id=\"dep";
	echo $r['id'];
	echo "\">
                <td><input type=\"text\" name=\"name[";
	echo $r['id'];
	echo "]\" value=\"";
	echo $r['name'];
	echo "\" /></td>
                <td>";
	echo $db->fetchOne("SELECT COUNT(*) AS NUM FROM helpdesk_ticket WHERE status='1' AND department=" . $r['id']);
	echo "</td>
                <td>";
	echo $db->fetchOne("SELECT COUNT(*) AS NUM FROM helpdesk_ticket WHERE status='2' AND department=" . $r['id']);
	echo "</td>
                <td>";
	echo $db->fetchOne("SELECT COUNT(*) AS NUM FROM helpdesk_ticket WHERE status='3' AND department=" . $r['id']);
	echo "</td>
                <td>";
	echo $db->fetchOne("SELECT COUNT(*) AS NUM FROM helpdesk_ticket WHERE status='4' AND department=" . $r['id']);
	echo "</td>
                <td><input type=\"submit\" name=\"btn\" value=\"Save\" onclick=\"updfrmvars({'depid': '";
	echo $r['id'];
	echo "', 'depaction': 'update'});\" /> <input type=\"submit\" name=\"btn\" value=\"Delete\" class=\"cancel\"onclick=\"updfrmvars({'depid': '";
	echo $r['id'];
	echo "', 'depaction': 'delete'});\"  /></td>
            </tr>
            ";
}

echo "        </table>
        </form>


    </div>
</div>
</div>

        ";
include SOURCES . "footer.php";
echo " ";
?>
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


if (!$admin->permissions['site_content']) {
	header("location: ./");
	exit();
}


if ($input->g['edit']) {
	$template_id = $db->real_escape_string($input->gc['edit']);
	$chk = $db->fetchOne(("SELECT COUNT(id) AS NUM from email_template WHERE id='" . $template_id . "'"));

	if ($chk != 0) {
		include "edit_email_template.php";
		$db->close();
		exit();
	}
}

include SOURCES . "header.php";
$q = $db->query("SELECT id, name, type FROM email_template");
echo "<div class=\"site_title\">Email Templates</div>
<div class=\"site_content\">
<table class=\"widget-tbl\" width=\"100%\">
	<tr class=\"titles\">
	    <td align=\"center\" width=\"400\">Template Name</td>
    	<td align=\"center\">Active</td>
    	<td align=\"center\">Action</td>
	</tr>
    ";

while ($r = $db->fetch_array($q)) {
	echo "    <tr>
    	<td><strong>";
	echo $r['name'];
	echo "</strong></td>
    	<td align=\"center\">";
	echo $r['type'] == "plain" ? "<span style=\"color:blue\">Plain Format</span>" : "<span style=\"color:green\">HTML Format</span>";
	echo "</td>
    	<td align=\"center\"><input type=\"submit\" name=\"button\" value=\"Edit Template\" onclick=\"location.href='./?view=email_template&edit=";
	echo $r['id'];
	echo "';\" /></td>
    </tr>
    ";
}

echo "</table>
</div>


";
include SOURCES . "footer.php";
echo " ";
?>
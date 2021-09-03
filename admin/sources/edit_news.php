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

$data = $db->fetchRow("SELECT * FROM news WHERE id=" . $input->gc['edit']);

if ($input->p['do'] == "edit") {
	verifyajax();
	verifydemo();

	if ($input->p['title'] == "" || $input->p['news'] == "") {
		serveranswer(0, "One of the required field(s) is empty.");
	}

	$loginads = ($input->p['loginads'] == 1 ? 1 : 0);
	$date = $input->p['date'];

	if ($loginads == 1) {
		$db->query("UPDATE news SET loginads=0");
	}


	if ($date == 1) {
		$set = array("title" => $input->pc['title'], "message" => $input->p['news'], "date" => TIMENOW, "loginads" => $loginads);
	}
	else {
		$set = array("title" => $input->pc['title'], "message" => $input->p['news'], "loginads" => $loginads);
	}

	$db->update("news", $set, "id=" . $data['id']);
	$cache->delete("news_list");
	serveranswer(3, "News was updated.");
}

include SOURCES . "header.php";
echo "<script type=\"text/javascript\">
function save_form(id){
	tinyMCE.get('txthtml').save();
	submitform(id);
	return false;
}
</script>
<script type=\"text/javascript\" src=\"./js/tinymce/tinymce.min.js\"></script>
<script type=\"text/javascript\">
tinymce.init({
    selector: \"textarea#txthtml\",
	theme: \"modern\",
	height: 200,
    plugins: [
         \"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker\",
         \"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking\",
         \"save table contextmenu directionality emoticons template paste textcolor\"
   ],
	toolbar: \"insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | preview media fullpage | forecolor backcolor emoticons\",
 });
</script>

<div class=\"site_title\">Edit News</div>
<div class=\"site_content\">
<form method=\"post\" onsubmit=\"return save_form(this.id);\" id=\"newsform\">
<input type=\"hidden\" name=\"do\" value=\"edit\" />
<table width=\"100%\" class=\"widget-tbl\">
  <tr>
    <td width=\"150\" align=\"right\">Title:</td>
    <td ><input name=\"title\" type=\"text\" style=\"width:80%\" value=\"";
echo $data['title'];
echo "\" /></td>
    </tr>
  <tr>
    <td colspan=\"2\" align=\"center\">
    <textarea name=\"news\" id=\"txthtml\">";
echo $data['message'];
echo "</textarea>
    </td>
  </tr>
  <tr>
    <td  align=\"right\">Update to current date?</td>
    <td  >
    	<select name=\"date\">
        	<option value=\"1\">Yes</option>
            <option value=\"2\" selected=\"selected\">No</option>
       </select>
    </td>
  </tr>
  <tr>
    <td align=\"right\">Add this news to login ads:</td>
    <td ><input type=\"checkbox\" name=\"loginads\" value=\"1\" ";
echo $data['loginads'] == 1 ? "checked" : "";
echo " /></td>
    </tr>
  <tr>
  <tr>
  	<td></td>
    <td >
<input type=\"submit\" name=\"create\" value=\"Send\" />
<input type=\"button\" onclick=\"location.href='./?view=news';\" value=\"Return\" />
    </td>
  </tr>
</table>
</form>
</div>

 ";
include SOURCES . "footer.php";
echo " ";
?>
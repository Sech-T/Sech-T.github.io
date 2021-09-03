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


if ($input->p['do'] == "update") {
	verifyajax();
	verifydemo();
	$stored = array("content" => $input->p['terms']);
	$db->update("site_content", $stored, "id='terms'");
	$cache->delete("terms_content");
	serveranswer(1, "Terms of Service were updated.");
}

$terms = $db->fetchOne("SELECT content FROM site_content WHERE id='terms'");
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

<div class=\"site_title\">Terms of Service</div>
<div class=\"site_content\">
<form method=\"post\" onsubmit=\"return save_form(this.id);\" id=\"terms\">
<input type=\"hidden\" name=\"do\" value=\"update\" />
<table class=\"widget-tbl\" width=\"100%\">
    <td align=\"center\">
    <textarea name=\"terms\" id=\"txthtml\">";
echo $terms;
echo "</textarea>
    </td>
  </tr>
  <tr>
    <td align=\"center\">
<input type=\"submit\" name=\"create\" value=\"Update\" />

<input type=\"button\" name=\"btn\" value=\"Return\" onclick=\"history.back();\" />
    </td>
  </tr>
</table>
</form>
</div>

";
include SOURCES . "footer.php";
echo " ";
?>
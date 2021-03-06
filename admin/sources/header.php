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

require_once SOURCES . "adminmenu.php";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>EvolutionScript - Admin Control Panel</title>


<link href=\"./css/site.css\" rel=\"stylesheet\" type=\"text/css\" />
<link href=\"./css/global.css\" rel=\"stylesheet\" type=\"text/css\" />
<script type=\"text/javascript\" src=\"./js/jquery.min.js\"></script>
<script type=\"text/javascript\" src=\"./js/jquery-ui-1.9.1.custom.min.js\"></script>
<script type=\"text/javascript\" src=\"./js/l2blockit.js\"></script>
<script type=\"text/javascript\" src=\"./js/admin.js\"></script>
    <link rel=\"stylesheet\" href=\"./js/jquery.wysiwyg.css\" type=\"text/css\" />
    <link rel=\"stylesheet\" href=\"./js/jquery.wysiwyg.modal.css\" type=\"text/css\" />
    <link rel=\"stylesheet\" href=\"./js/jquery.simplemodal.css\" type=\"text/css\" />

<link href=\"./css/evolutionscript/jquery-ui-1.9.2.custom.css\" rel=\"stylesheet\">



    <script type=\"text/javascript\">
	$(function(){
		$('ul li:has(ul)').hover(
		  function(e)
		  {
			 $(this).find('div').css({display: \"block\"});
			 $(this).find('ul').first().css({display: \"block\"});
		  },
		  function(e)
		  {
			 $(this).find('div').css({display: \"none\"});
			 $(this).find('ul').first().css({display: \"none\"});
		  }
	  );
	  });
   </script>

</head>
<body>
<div class=\"notes\" id=\"mynotes\">
<form method=\"post\" onsubmit=\"return savenotes();\" id=\"savenotesform\">
<input type=\"hidden\" name=\"do\" value=\"savenotes\" />
<textarea name=\"mynotes\" style=\"width:400px; height:200px\" id=\"notes\">";
echo $admin->getNotes();
echo "</textarea>
<div align=\"center\">
<input type=\"submit\" name=\"save\" value=\"Save\">
</div>
</form>
</div>


<div class=\"wrapper\">
    <div id=\"header\">
        <div id=\"logo\">
        <a href=\"./\"></a>
        </div>
        <div class=\"top-box\">
        Logged in as <strong>";
echo $admin->getUsername();
echo "</strong> -
        <a href=\"javascript:void(0);\" onclick=\"shownotes();\">My Notes</a> &nbsp; &bull; &nbsp;
        <a href=\"./?view=account\">My Account</a> &nbsp; &bull; &nbsp;
        <a href=\"./?view=logout\">Logout</a>
        </div>
        <div class=\"clear\"></div>
        <div class=\"navbar\">
            <ul>
                ";
foreach ($adminnavmenu as $mainname => $val) {
	echo "<li><a href=\"" . $val['link'] . "\" class=\"" . $val['class'] . "\">" . $mainname . "</a>";
	echo "<div class=\"divnavul\"><ul>";
	$n = 0;
	foreach ($val['menu'] as $submenu => $sublink) {

		if (!is_array($sublink)) {
			echo "<li " . ($n == 0 ? "class=\"first\"" : "") . "><a href=\"" . $sublink . "\">" . $submenu . "</a></li>";
		}
		else {
			echo "<li " . ($n == 0 ? "class=\"first\"" : "") . "><a href=\"javascript:void(0);\" class=\"leftrow\">" . $submenu . "</a>";
			echo "<ul style=\"display:none\">";
			foreach ($sublink as $submenu2 => $sublink2) {
				echo "<li><a href=\"" . $sublink2 . "\">" . $submenu2 . "</a></li>";
			}

			echo "</ul>";
			echo "</li>";
		}

		$n = $n + 1;
	}

	echo "</ul></div>";
	echo "</li> ";
}

echo "            </ul>
            <div class=\"clear\"></div>
        </div>
    </div>


    <div class=\"main_content\">";
?>
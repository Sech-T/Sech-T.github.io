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


if ($input->p['do'] == "create_language") {
	verifyajax();
	verifydemo();
	$language_name = $input->pc['language_name'];

	if (!$language_name) {
		serveranswer(0, "Enter your language name.");
	}

	$language_vars = $input->p['var'];

	if (!is_array($language_vars) || count($language_vars) <= 0) {
		serveranswer(0, "Complete the translation vars.");
	}

	$content = "<?php\n";
	foreach ($language_vars as $k => $v) {
		$content .= "\$lang['txt']['" . $k . "'] = '" . html_entity_decode(mb_convert_encoding($v, "utf-8", "auto"), "'") . "';\n";
	}

	$content .= "\n?>";
	$file_name = TIMENOW . ".php";
	$file_path = ROOTPATH . "languages/" . $file_name;
	$file = fopen($file_path, "w");
	fwrite($file, $content);
	fclose($file);
	$datastored = array("name" => $language_name, "version" => $software['version'], "filename" => $file_name);
	$insert = $db->insert("language", $datastored);
	$success_msg = $language_name . "  was sucessfully installed! <a href=\"./?view=language_settings\">Click here to manage installed languages</a>";
	serveranswer(5, $success_msg);
}


if ($input->p['do'] == "install") {
	if ($settings['demo'] == "yes") {
		$error_msg = "This is not possible in demo version";
	}
	else {
		if ($input->p['sesion_id'] != $_SESSION['sesion_id']) {
			$error_msg = "Invalid token try again please";
		}
		else {
			if ($_FILES['file']['type'] != "text/xml") {
				$error_msg = "Invalid File";
			}
			else {
				if (0 < $_FILES['file']['error']) {
					$error_msg = "Invalid File";
				}
				else {
					move_uploaded_file($_FILES['file']['tmp_name'], "../upload/" . $_FILES['file']['name']);
					$doc = new DOMDocument();
					$doc->load("../upload/" . $_FILES['file']['name']);
					$langnames = $doc->getElementsByTagName("name");
					$langname = $langnames->item(0)->nodeValue;
					$langversions = $doc->getElementsByTagName("ptcevolution");
					$langversion = $langversions->item(0)->nodeValue;
					$langfiles = $doc->getElementsByTagName("filename");
					$langfile = $langfiles->item(0)->nodeValue;

					if ((empty($langname) || empty($langversion)) || empty($langfile)) {
						$error_msg = "Invalid File";
					}
					else {
						if ($langversion != $software['version']) {
							$error_msg = $langname . " is not configured for PTCEvolution " . $software['version'];
						}
						else {
							$verifylang = $db->fetchOne(("SELECT COUNT(*) AS NUM FROM language WHERE name='" . $langname . "' and version='" . $software['version'] . "'"));

							if ($verifylang == 0) {
								$datastored = array("name" => $langname, "version" => $langversion, "filename" => $langfile);
								$insert = $db->insert("language", $datastored);
								$success_msg = $langname . "  was sucessfully installed! <a href=\"./?view=language_settings\">Click here to manage installed languages</a>";
							}
							else {
								$error_msg = $langname . " is already installed on this site.";
							}
						}
					}

					@unlink("../upload/" . $_FILES['file']['name']);
					$cache->delete("languages");
				}
			}
		}
	}
}

include SOURCES . "header.php";
echo "<div class=\"site_title\">Install a New Language</div>
<div class=\"site_content\">
	";

if ($error_msg) {
	echo "    <div class=\"error_box\">";
	echo $error_msg;
	echo "</div>
    ";
}

echo "	";

if ($success_msg) {
	echo "    <div class=\"success_box\">";
	echo $success_msg;
	echo "</div>
    ";
}

echo "        <form method=\"post\" enctype=\"multipart/form-data\">
        <input type=\"hidden\" name=\"sesion_id\" value=\"";
echo sesion_id();
echo "\" />
        <input type=\"hidden\" name=\"do\" value=\"install\" />
        <table class=\"widget-tbl\" width=\"100%\">
          <tr>
            <td width=\"300\" align=\"right\">Upload the XML file from your computer:</td>
            <td><input type=\"file\" name=\"file\" id=\"file\" /> </td>
          </tr>
          <tr>
          	<td></td>
            <td><input type=\"submit\" name=\"save\" value=\"Install\" /></td>
          </tr>
        </table>
        </form>

</div>

<div class=\"site_title\">Create a New Language</div>
<div class=\"site_content\">
";
$language_dir = ROOTPATH . "languages/";

if (is_writable($language_dir)) {
	include $language_dir . "english.php";
	echo "<form method=\"post\" id=\"newlangfrm\" onsubmit=\"return submitform(this.id);\">
<input type=\"hidden\" name=\"do\" value=\"create_language\" />
	<div class=\"widget-main-title\">New language</div>
    	<table class=\"widget-tbl\" width=\"100%\">
        	<tr>
            	<td align=\"right\" width=\"300\">Language name:</td>
                <td><input type=\"text\" name=\"language_name\" /></td>
            </tr>
        </table>

    <div class=\"widget-title\">Translate variables</div>
    	<table class=\"widget-tbl\" width=\"100%\">
			";
	foreach ($lang['txt'] as $k => $v) {
		echo "                <tr>
                    <td align=\"right\" width=\"300\">
                    \$lang['txt']['";
		echo $k;
		echo "'] =
                    </td>
                    <td>
                    <input type=\"text\" name=\"var[";
		echo $k;
		echo "]\" value=\"";
		echo $v;
		echo "\" style=\"width:400px\" />
                    </td>
                </tr>
            ";
	}

	echo "            <tr>
            	<td></td>
                <td><input type=\"submit\" name=\"btn\" value=\"Create\" /></td>
            </tr>
        </table>
</form>
";
}
else {
	echo "<div class=\"error_box\">Set CHMOD 777 to language directory (" . $language_dir . ") to be writable</div>";
}

echo "</div>
        ";
include SOURCES . "footer.php";
echo " ";
?>
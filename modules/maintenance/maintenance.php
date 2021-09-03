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

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>";
echo $settings['site_name'];
echo " - Under Maintenance</title>
</head>
<style>
body{
background:#ffffff;
font-family:Arial, Helvetica, sans-serif;
color:#3f3f3b;
}
</style>
<body>
<div style=\"padding-top:100px; width:500px; margin:0 auto;\">
	<div><img src=\"./modules/maintenance/logo.png\" /></div>
    <h2>Sorry, We are Currently Performing Maintenance!</h2>
    <div>";
echo $settings['maintenance_msg'];
echo "</div>
	";

if ($settings['copyright'] != "0") {
	echo "    <div style=\"font-size:13px; padding-top:20px;\">Powered by <a href=\"http://www.evolutionscript.com\" style=\"color:#37b6bd; text-decoration:none;\">EvolutionScript</a> ";
	echo $software['version'];
	echo "</div>
    ";
}

echo "</div>


</div>
</body>
</html>
";
?>
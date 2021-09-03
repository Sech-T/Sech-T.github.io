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

function validate_captcha($field1, $field2) {
	global $lang;

	if ($field1 != $_SESSION['captcha'] || $field1 == "") {
		unset($_SESSION['captcha']);
		$stored = array("status" => 0, "msg" => $lang['txt']['invalidimageverification']);
		echo json_encode($stored);
		exit();
	}

}


if (!defined("EvolutionScript")) {
	exit("Hacking attempt...");
}

$captcha_html .= "<div style=\"padding:5px 0px\"><a href='javascript:void(0);' onclick='captchareload();'><img src=\"modules/captcha/captcha.php\" id=\"captchaimg\" border=0 /></a></div>
";
$captcha_html .= "<div><input type=\"text\" name=\"captcha\" id=\"captcha\" /></div>
";
$captcha_html .= "<script>function captchareload(){
";
$captcha_html .= "$(\"#captchaimg\").attr('src','modules/captcha/captcha.php?x=34&y=75&z=119&?newtime=' + (new Date()).getTime());
";
$captcha_html .= "}</script>";
$smarty->assign("captcha", $captcha_html);
?>
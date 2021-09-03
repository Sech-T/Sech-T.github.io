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
	global $privatekey;
	global $lang;

	$resp = recaptcha_check_answer($privatekey, $_SERVER['REMOTE_ADDR'], $field1, $field2);

	if (!$resp->is_valid) {
		$stored = array("status" => 0, "msg" => $lang['txt']['invalidimageverification']);
		echo json_encode($stored);
		exit();
	}

}


if (!defined("EvolutionScript")) {
	exit("Hacking attempt...");
}

require_once "modules/reCAPTCHA/recaptchalib.php";

if (empty($settings['recaptcha_publickey']) || empty($settings['recaptcha_privatekey'])) {
	$publickey = "6LdJeAsAAAAAAFZthRFYeAD6RxjrCCoBpCS2we5i";
	$privatekey = "6LdJeAsAAAAAAD28os9SE5hvY7ZUidS9Xm-NQqdb";
}
else {
	$publickey = $settings['recaptcha_publickey'];
	$privatekey = $settings['recaptcha_privatekey'];
}

$resp = null;
$error = null;

if (!empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "on") {
	$use_ssl = true;
}
else {
	$use_ssl = false;
}

$captcha_html .= "<script>var RecaptchaOptions = {
";
$captcha_html .= "theme : '" . $settings['recaptcha_theme'] . "',
";
$captcha_html .= "tabindex : 2};</script>";
$captcha_html .= recaptcha_get_html($publickey, $error, $use_ssl);
$captcha_html .= "<script>function captchareload(){ Recaptcha.reload(); }</script>
";
$smarty->assign("captcha", $captcha_html);
?>
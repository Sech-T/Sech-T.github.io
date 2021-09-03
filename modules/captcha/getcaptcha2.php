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

function flip($im) {
	$wid = imagesx($im);
	$hei = imagesy($im);
	$im2 = imagecreatetruecolor($wid, $hei);
	$i = 0;

	while ($i < $wid) {
		$j = 0;

		while ($j < $hei) {
			$ref = imagecolorat($im, $i, $j);
			imagesetpixel($im2, $i, $hei - $j, $ref);
			++$j;
		}

		++$i;
	}

	return $im2;
}


if ($_REQUEST['show'] == "captcha") {
	$my_img = imagecreate(300, 50);
	$background = imagecolorallocate($my_img, 255, 255, 255);
	$number = array();
	$keys = array();
	$count = 0;
	$n = 0;
	$c = 0;
	$my_img = imagecreatetruecolor(300, 50);

	if (!is_array($_SESSION['vnumbers'])) {
		exit();
	}

	foreach ($_SESSION['vnumbers'] as $k => $v) {
		$c = $c + 1;

		if ($k == $_SESSION['the_number']) {
			$_SESSION['valid_key'] = $c;
			$num1 = imagecreatefromjpeg(ROOTPATH . "images/numbers/" . $v . ".jpeg");
			list($width,$height) = getimagesize(ROOTPATH . "images/numbers/" . $v . ".jpeg");
			$num1 = flip($num1);
		}
		else {
			$num1 = imagecreatefromjpeg(ROOTPATH . "images/numbers/" . $v . ".jpeg");
			list($width,$height) = getimagesize(ROOTPATH . "images/numbers/" . $v . ".jpeg");
		}

		imagecopyresized($my_img, $num1, $n, 0, 0, 0, 50, 50, $width, $height);
		$n = $n + 50;
	}

	header("Content-type: image/png");
	imagepng($my_img);
	imagedestroy($my_img);
	exit();
}

?>
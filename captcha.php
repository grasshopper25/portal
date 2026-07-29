<?php
session_start();

header('Content-Type: image/png');

$width = 100;
$height = 30;

$image = imagecreatetruecolor($width, $height);

$background_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
$line_color = imagecolorallocate($image, 120, 120, 120);

imagefilledrectangle($image, 0, 0, $width, $height, $background_color);

// captcha code
$captcha_code = '';

for ($i = 0; $i < 4; $i++) {
    $captcha_code .= rand(0, 9);
}

$_SESSION['captcha_code'] = $captcha_code;

// noise lines
for ($i = 0; $i < 5; $i++) {
    imageline(
        $image,
        rand(0, $width),
        rand(0, $height),
        rand(0, $width),
        rand(0, $height),
        $line_color
    );
}

// font path
$font = __DIR__ . '/ARIAL.ttf';

// print text
imagettftext(
    $image,
    16,
    0,
    20,
    22,
    $text_color,
    $font,
    $captcha_code
);

imagepng($image);

imagedestroy($image);
?>
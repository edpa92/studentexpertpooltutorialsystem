<?php

session_start();

// Store the random string in a session variable

// Create an image with the random string
$image = imagecreate(100, 30);
$background_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
imagestring($image, 5, 20, 10, $_SESSION['captcha'], $text_color);

// Add noise to the image
for ($i = 0; $i < 100; $i++) {
    imagesetpixel($image, rand(0, 99), rand(0, 29), $text_color);
}

// Output the image as a PNG file
header('Content-type: image/png');
imagepng($image);

// Free up memory
imagedestroy($image);
?>
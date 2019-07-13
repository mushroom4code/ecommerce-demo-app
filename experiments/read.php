<?php

// $file = fopen('file.txt', 'w');
// $text = "CHota\n";
// fwrite($file, $text);
// $text = "Chota2\n";
// fwrite($file, $text);
// fclose($file);
$file = fopen('file.txt', 'r');
echo fgets($file);
?>
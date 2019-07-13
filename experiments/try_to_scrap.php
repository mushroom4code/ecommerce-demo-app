<?php
include('simple_html_dom.php');
ini_set('max_execution_time', 600);
$html = file_get_html('https://www.kupivip.ru/catalog/muzhchinam/verhnyaya-odezhda?page=3&quantity_per_page=60');
$images = [];
foreach ($html->find('img') as $img) {
	$images[] = $img->src;
}
foreach ($images as $img) {
	echo '<img src="'.$img.'">';
}
exit();
?>
<?php
$index_page = 'http://localhost/ecommerce/index.php';
session_start();
session_destroy();
header('Location: '.$index_page);
?>
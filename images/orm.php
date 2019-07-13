<?php

require_once('rb.php');

R::setup('mysql:host=localhost;dbname=redstoneshop', 'root', 'lolecmetalece666');

for ($i = 1; $i <= 8; $i++) {

    $image = R::dispense('image');
    $image->src = "images/image$i.jpg";
    $image->type = "Футболка";
    $image->brand = "Billionare";
    R::store($image);

}

for ($i = 9; $i <= 16; $i++) {

    $image = R::dispense('image');
    $image->src = "images/image$i.jpg";
    $image->type = "Джинсы";
    $image->brand = "Tommy Jeans";
    R::store($image);

}

for ($i = 17; $i <= 24; $i++) {

    $image = R::dispense('image');
    $image->src = "images/image$i.jpg";
    $image->type = "Часы";
    $image->brand = "Burgermeister";
    R::store($image);

}
for ($i = 25; $i <= 32; $i++) {

    $image = R::dispense('image');
    $image->src = "images/image$i.jpg";
    $image->type = "Футболка";
    $image->brand = "MANGO";
    R::store($image);

}

for ($i = 33; $i <= 40; $i++) {

    $image = R::dispense('image');
    $image->src = "images/image$i.jpg";
    $image->type = "Джинсы";
    $image->brand = "Diesel";
    R::store($image);

}

for ($i = 41; $i <= 48; $i++) {

    $image = R::dispense('image');
    $image->src = "images/image$i.jpg";
    $image->type = "Ботинки";
    $image->brand = "Tamaris";
    R::store($image);

}

for ($i = 49; $i <= 56; $i++) {

    $image = R::dispense('image');
    $image->src = "images/image$i.jpg";
    $image->type = "Часы";
    $image->brand = "Burgy";
    R::store($image);

}

for ($i = 57; $i <= 64; $i++) {

    $image = R::dispense('image');
    $image->src = "images/image$i.jpg";
    $image->type = "Джинсы";
    $image->brand = "Pepe Jeans";
    R::store($image);

}

for ($i = 65; $i <= 72; $i++) {

    $image = R::dispense('image');
    $image->src = "images/image$i.jpg";
    $image->type = "Ботинки";
    $image->brand = "Ricosta";
    R::store($image);

}

for ($i = 73; $i <= 80; $i++) {

    $image = R::dispense('image');
    $image->src = "images/image$i.jpg";
    $image->type = "Ботинки";
    $image->brand = "Milana";
    R::store($image);

}
?>
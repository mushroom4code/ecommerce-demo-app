<?php
// This script performs an INSERT query to add a record to the users table.
$index_page = 'http://localhost/ecommerce/index.php';
session_start();
// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize an error   array.
    $errors = [];

    require('../../mysqli_connect.php');

    // Check for an email address:
    if (empty($_POST['email'])) {
        $errors[] = 'Вы забыли ввести почту.';
    }
    else {
        $e = mysqli_real_escape_string($dbc, trim($_POST['email']));
    }

    // Check for a password and match against the confirmed password:
    if (empty($_POST['pass'])) {
        $errors[] = 'Вы забыли ввести пароль.';
    }
    else {
        $p = mysqli_real_escape_string($dbc, trim($_POST['pass']));
    }

    if (empty($errors)) {
        $query = "SELECT user_id, first_name FROM users WHERE email='$e' AND pass=SHA2('$p', 512)";
        $result = mysqli_query($dbc, $query);
        if ($result) { //mysqli_num_rows($result) == 1
            while($row = mysqli_fetch_row($result)) {
                $_SESSION['id'] = $row['0'];
                $_SESSION['first_name'] = $row['1'];
            }
        // header('Refresh:0');
        // die();
        }
        else{
            echo "Неаправильный адрес электронной почты или пароль";
        }
    }
    else {
            echo '<h1>Error!</h1>
            <p class="error">The following error(s) occured:<br>';
            // Print each error.
            foreach ($errors as $msg) {
                echo " - $msg<br>\n";
            }
            echo '</p><p>Please try again.</p><p><br></p>';
        // End of if (empty($errors)) IF.
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Red stone shop</title>
    <link rel="icon" href="images/ecommerce_icon.png" type="image/ico">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <style>
    #dropel:active {
    background-color: #800000;
    }
    </style>
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top" id="navbar">
        <div class="container-fluid">
            <a style="margin-left: 60px;" href="/ecommerce/index.php" class="navbar-brand" id="text">Red Stone Shop</a>
            <ul class="nav navbar-nav mr-auto mt-2 mt-lg-0">
            <?php $counter = 3;
            while ($counter > 0) : ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="text"><?php if ($counter === 3) {
                        echo 'Мужчинам';
                    } elseif ($counter === 2) {
                        echo 'Женщинам';
                    } elseif ($counter === 1) {
                        echo 'Детям';
                    }?><span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" style="background-color: black">
                        <?php if ($counter != 1) { echo '<li id="dropel"><a href="';if ($counter === 3) {
                        echo 't-shirts_male.php';
                    } elseif ($counter === 2) {
                        echo 't-shirts_female.php';
                    } echo '" id="text">Футболки</a></li>';}?>
                        <?php if ($counter != 1) { echo '<li id="dropel"><a href="'; if ($counter === 3) {
                        echo 'pants_male.php';
                    } elseif ($counter === 2) {
                        echo 'pants_female.php';
                    }echo '"id="text">Штаны</a></li>'; } ?>
                    <?php if ($counter == 1) { echo
                    '<li id="dropel"><a href="clothes_child.php
                    " id="text">Одежда</a></li>';
                    } ?>
                        <li id="dropel"><a href="<?php if ($counter === 3) {
                        echo 'shoes_male.php';
                    } elseif ($counter === 2) {
                        echo 'shoes_female.php';
                    } elseif ($counter === 1) {
                        echo 'shoes_child.php';
                    }?>" id="text">Обувь</a></li>
                        <?php if($counter != 1) { echo '<li id="dropel"><a href="';
                        if ($counter === 3) {
                        echo 'accessories_male.php';
                    } elseif ($counter === 2) {
                        echo 'accessories_female.php';
                    }echo '" id="text">Аксессуары</a></li>';}?>
                    </ul>
                </li>
                <?php $counter--; ?>
            <?php endwhile; ?>
            </ul>
            <?php if (empty($_SESSION['id'])) {
            echo '<form action="register.php" class="navbar-form navbar-right">
                    <input style="background-color: black; border-color: black; color: white" type="submit" class="btn btn-default" value="Регистрация">
            </form>
            <form class="navbar-form navbar-right" action="index.php" method="POST" style="margin-right: -27px">
                    <div class="form-group">
                        <input style="width: 150px" type="email" name="email" class="form-control" placeholder="Почта">
                        <input style="width: 150px" type="password" name="pass" class="form-control" placeholder="Пароль">
                    </div>
                    <input style="background-color: black; border-color: black; color: white" type="submit" class="btn btn-default" value="Вход">
            </form>';
            } else {
            echo '<ul class="nav navbar-right mr-auto mt-2 mt-lg-0">
                    <li class="dropdown" style="background-color: black; height: 50px;">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="position: relative; top: 5px" id="text">Аккаунт<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu" style="background-color: black; margin-top: -0.5px; border-radius: 0px">
                            <li><a href="account.php?id='.$_SESSION['id'].'" id="text">Изменить данные аккаунта</a></li>
                            <li><a href="password_reset.php?id='.$_SESSION['id'].'" id="text">Изменить пароль</a></li>';
                            if ($_SESSION['first_name'] == 'Max') {
                                echo '<li><a href="admin_panel.php" id="text">Панель администратора</a></li>';
                            }
            echo           '<li><a href="logout.php" id="text">Выйти</a></li>
                        </ul>
                    </li>
                </ul>';
            }?>
        </div>
    </nav>
    <div id="background-image">
        <div id="image1"></div>
        <div id="image2"></div>
    </div>
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="row">
            <h2 class="text-center">Рекомендуемые товары</h2>
            <div class="col-md-3" id="images">
                <h4>Джинсы Levis</h4><br>
                <img src="images/levis_jeans.jpg" alt="Джинсы Levis" id="list_images">
                <p class="list-price text-danger">Обычная Цена: <s>$24.99</s></p>
                <p class="price">Наша Цена: $19.50</p>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#details-1" style="background-color: #800000; border-color:  #800000">Подробнее</button>
            </div>
            <div class="col-md-3">
                <h4>Куртка Frankie Morrelo</h4>
                <img src="images/franikie_morello.jpg" alt="Куртка Frankie Morello" id="list_images">
                <p class="list-price text-danger">Обычная Цена: <s>$30.99</s></p>
                <p class="price">Наша Цена: $25.99</p>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#details-2" style="background-color: #800000; border-color:  #800000">Подробнее</button>
            </div>
            <div class="col-md-3">
                <h4>Сумка Billionare</h4><br>
                <img src="images/billionare.jpg" alt="Сумка Billionare" id="list_images">
                <p class="list-price text-danger">Обычная Цена: <s>$15.99</s></p>
                <p class="price">Наша Цена: $10.99</p>
                <button type="button"  class="btn btn-danger" data-toggle="modal" data-target="#details-3" style="background-color: #800000; border-color:  #800000">Подробнее</button>
            </div>
            <div class="col-md-3" >
                <h4>Часы Lancasters</h4><br>
                <img src="images/lancasters.jpg" alt="Часы Lancasters" id="list_images">
                <p class="list-price text-danger">Обычная Цена: <s>$50.99</s></p>
                <p class="price">Наша Цена: $30.99</p>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#details-4" style="background-color: #800000; border-color:  #800000">Подробнее</button>
            </div>
            <div class="col-md-3" >
                <h4>Часы Burgermeister</h4><br>
                <img src="images/burgermeister.jpg" alt="Часы Burgermeister" id="list_images">
                <p class="list-price text-danger">Обычная Цена: <s>$45.60</s></p>
                <p class="price">Наша Цена: $28.10</p>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#details-5" style="background-color: #800000; border-color:  #800000">Подробнее</button>
            </div>
            <div class="col-md-3" >
                <h4>Джинсы MARCIANO Los Angeles</h4>
                <img src="images/MARCIANO_Los_Angeles.jpg" alt="Джинсы MARCIANO Los Angeles" id="list_images">
                <p class="list-price text-danger">Обычная Цена: <s>$16.35</s></p>
                <p class="price">Наша Цена: $11.22</p>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#details-6" style="background-color: #800000; border-color:  #800000">Подробнее</button>
            </div>
            <div class="col-md-3" >
                <h4>Джинсы ICE&BERRY</h4><br>
                <img src="images/ICE&BERRY.jpg" alt="Джинсы ICE&BERRY" id="list_images">
                <p class="list-price text-danger">Обычная Цена: <s>$18.11</s></p>
                <p class="price">Наша Цена: $15.50</p>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#details-7" style="background-color: #800000; border-color:  #800000">Подробнее</button>
            </div>
            <div class="col-md-3" >
                <h4>Кроссовки Liu Jo</h4><br>
                <img src="images/Liu_Jo.jpg" alt="Кроссовки Liu Jo" id="list_images">
                <p class="list-price text-danger">Обычная Цена: <s>$10.99</s></p>
                <p class="price">Наша Цена: $5.99</p>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#details-8" style="background-color: #800000; border-color:  #800000">Подробнее</button>
            </div>
        </div>
        <footer class="text-center" id="f">&copy; Все права защищены 2017-2019 Red Stone Shop</footer>
    </div>
    <?php
    include 'details-modal-levis_jeans.php';
    include 'details-modal-frankie_morello_jacket.php';
    include 'details-modal-billionare_handbag.php';
    include 'details-modal-lancasters_watches.php';
    include 'details-modal-burgermeister_watches.php';
    include 'details-modal-marciano_los_angeles_jeans.php';
    include 'details-modal-ice_and_berry_jeans.php';
    include 'details-modal-liu_jo_sneakers.php';
    ?>
</body>
</html>
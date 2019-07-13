<?php

if (!empty($_GET['id']) && is_numeric($_GET['id'])) {

    $id = $_GET['id'];

} elseif (!empty($_POST['id']) && is_numeric($_POST['id']) ) {

    $id = $_POST['id'];

} else {

    echo "<h1>Произошла ошибка</h1>";
    exit();

}

require_once('../../mysqli_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if($_POST['sure'] == 'Yes') {

        $query = "DELETE FROM users WHERE user_id=$id LIMIT 1";
        $result = mysqli_query($dbc, $query);

        if (mysqli_affected_rows($dbc) == 1) {

            echo "Пользователь успешно удален.";
            echo '<a href="index.php">На главную</a>&nbsp<a href="admin_panel.php">К панели администратора</a>';

        } else {

            echo "Пользователь не может быть удален из-за системной ошибки";
            echo '<a href="index.php">На главную</a>&nbsp<a href="admin_panel.php">К панели администратора</a>';

        }

    } else {

        echo "Пользователь НЕ удален";

    }

} else {

    $query = "SELECT CONCAT(last_name, ' ', first_name) FROM users WHERE user_id=$id";
    $result = mysqli_query($dbc, $query);

    if (mysqli_num_rows($result) == 1) {

    $row = mysqli_fetch_row($result);


    echo "<h3>Имя: $row[0]</h3>
    <p>Вы уверены что хотите удалить этого пользователя?</p><br>";


    echo '
        <div class="login-page">
            <div class="form">
                <form action="delete_user.php" method="POST">
                    <input type="radio" name="sure" value="Yes"> Да
                    <input type="radio" name="sure" value="No" checked="checked"> Нет
                    <input type="hidden" name="id" value="'.$id.'">
                    <button type="submit">Подтвердить</button>
                </form>
            </div>
        </div><br><br>
        <a href="admin_panel.php">Вернуться назад</a>';

    } else {

        echo 'Произошла ошибка2';

    }

}

mysqli_close($dbc);

?>
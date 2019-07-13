<?php

echo '<link rel="stylesheet" href="css/bootstrap.min.css">';
echo '<style> body { margin: 30px; }</style>';

echo '<h1 class="h1">Панель администратора</h1>';
require_once('../../mysqli_connect.php');

$query = "SELECT user_id, last_name, first_name, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr, user_id FROM users ORDER BY registration_date ASC";
$result = mysqli_query($dbc, $query);

$num = mysqli_num_rows($result);

if ($num > 0) {


    echo "<p><strong>Сейчас зарегестрировано $num пользователей(я).</strong></p>\n";

    echo '<table class="table" width="50%">
    <thead class="">
        <tr>
            <th scope="col"><strong>ID</strong></th>
            <th scope="col"><strong>Фамилия</strong></th>
            <th scope="col"><strong>Имя</strong></th>
            <th scope="col"><strong>Дата регистрации</strong></th>
            <th scope="col"><strong>Изменить</strong></th>
            <th scope="col"><strong>Удалить</strong></th>
        </tr>
    </thead>
    <tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>
        <th scope="row">'.$row['user_id'].'</th>
        <td align="left">'.$row['last_name'].'</td>
        <td align="left">'.$row['first_name'].'</td>
        <td align="left">'.$row['dr'].'</td>
        <td align="left"><a href="account.php?id='.$row['user_id'].'">Изменить</a></td>
        <td align="left"><a href="delete_user.php?id='.$row['user_id'].'">Удалить</a></td>
        <tr>';
    }
    
    echo '</tbody></table><br><br><a href="index.php"><strong>На главную</h3></strong></a>';
    mysqli_free_result($result);

} else {

    echo "На сайте еще ни кто не зарегестрировался.";

}

mysqli_close($dbc);

?>
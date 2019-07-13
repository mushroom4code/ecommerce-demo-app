<?php

// If id sended through URL with GET method from main page is set
if (!empty($_GET['id'])) {
    $user_id = $_GET['id'];
}
// Or if id sended through form on this page is set
elseif (!empty($_POST['id'])) {
    $user_id = $_POST['id'];
}
// If no id is passed to page
else {
    echo "Произошла ошибка";
    echo '<br><a href="index.php">На главную</a>';
    exit();
}

// If form on this page was submited
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Declaring array for errors
    $_errors = [];

    require_once('../../mysqli_connect.php');
    // If old_password field in form is not empty then assign it
    // to a variable
    if (!empty($_POST['old_password'])) {
        $old_pass = mysqli_real_escape_string($dbc, trim($_POST['old_password']));
    }
    // Else fill array with error
    else {
        $errors[] = "Вы забыли ввести старый пароль";
    }

    if (!empty($_POST['new_password'])) {
        $new_pass = mysqli_real_escape_string($dbc, trim($_POST['new_password']));
    }
    else {
        $errors[] = "Вы забыли ввести новый пароль";
    }

    if (!empty($_POST['new_password_confirm'])) {
        $new_pass_confirm = mysqli_real_escape_string($dbc, trim($_POST['new_password_confirm']));
        if (!empty($new_pass)) {
            if ($new_pass == $new_pass_confirm) {
                $new_pass_ok = $new_pass;
            }
            else {
                $errors[] = "Пароли не совпадают";
            }
        }
    }
    else {
        $errors[] = "Вы забыли ввести подтверждающий пароль";
    }

    if (empty($errors)) {

        $query = "SELECT user_id FROM users WHERE user_id=$user_id LIMIT 1";
        $result = mysqli_query($dbc, $query);

        if (mysqli_num_rows($result) == 1) {

            $query = "UPDATE users SET pass=SHA2('$new_pass_ok', 512) WHERE user_id=$user_id";
            $result = mysqli_query($dbc, $query);

            if(mysqli_affected_rows($dbc) == 1) {

                echo "Пароль успешно заменен";
                mysqli_close($dbc);
            }
            else {
                echo "Пароль не может быть заменен из-за системной ошибки.
                Мы извеняемся за неудобства.";
            }
        }
        else {

            echo "Ваш аккаунт не зарегестрирован";
        }
    }
    else {
       echo "<h1>Следующие ошибки возникли</h1>";
       echo "<ul>";
       foreach ($errors as $error) {
           echo "<li>$error</li>";
       }
       echo "</ul>";
    }
}



?>
<!--Form for changing the password-->
<style>
    @import url(https://fonts.googleapis.com/css?family=Roboto:300);

    .login-page {
    width: 360px;
    padding: 8% 0 0;
    margin: auto;
    }
    .form {
    position: relative;
    z-index: 1;
    background: #800000;
    max-width: 360px;
    margin: 0 auto 100px;
    padding: 45px;
    text-align: center;
    box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
    }
    .form input {
    font-family: "Roboto", sans-serif;
    outline: 0;
    background: #f2f2f2;
    width: 100%;
    border: 0;
    margin: 0 0 15px;
    padding: 15px;
    box-sizing: border-box;
    font-size: 14px;
    }
    .form button {
    font-family: "Roboto", sans-serif;
    text-transform: uppercase;
    outline: 0;
    background: black;
    width: 100%;
    border: 0;
    padding: 15px;
    color: #FFFFFF;
    font-size: 14px;
    -webkit-transition: all 0.3 ease;
    transition: all 0.3 ease;
    cursor: pointer;
    }
    .form button:hover,.form button:active,.form button:focus {
    background: #43A047;
    }
    .form .message {
    margin: 15px 0 0;
    color: #b3b3b3;
    font-size: 12px;
    }
    .form .message a {
    color: black;
    text-decoration: none;
    }
    .form .login-form {
    display: none;
    }
    .container {
    position: relative;
    z-index: 1;
    max-width: 300px;
    margin: 0 auto;
    }
    .container:before, .container:after {
    content: "";
    display: block;
    clear: both;
    }
    .container .info {
    margin: 50px auto;
    text-align: center;
    }
    .container .info h1 {
    margin: 0 0 15px;
    padding: 0;
    font-size: 36px;
    font-weight: 300;
    color: #1a1a1a;
    }
    .container .info span {
    color: #4d4d4d;
    font-size: 12px;
    }
    .container .info span a {
    color: #000000;
    text-decoration: none;
    }
    .container .info span .fa {
    color: #EF3B3A;
    }
    body {
    background: white; /* fallback for old browsers */
    background: -webkit-linear-gradient(right, white, white);
    background: -moz-linear-gradient(right, white, white);
    background: -o-linear-gradient(right, white, white);
    background: linear-gradient(to left, white, white);
    font-family: "Roboto", sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    }
    </style>
    <div class="login-page">
    <div class="form">
    <form class="register-form" action="password_reset.php" method="POST">
        <input type="password" name="old_password" value="" placeholder="Старый пароль">
        <input type="password" name="new_password" placeholder="Новый пароль">
        <input type="password" name="new_password_confirm" placeholder="Подтверждение нового пароля">
        <input type="hidden" name="id" value="<?php echo $user_id; ?>">
        <button type="submit">Подтвердить</button>
        <p class="message" name="submit"><a href="index.php" style="color: white">Вернуться на главную</a></p>
    </form>
    </div>
    </div>

    <script>
    $(".message a").click(function(){
    $("form").animate({height: "toggle", opacity: "toggle"}, "slow");
    });
    </script>';
 <?php
 // This page is for editing a user record.
 // This page is accessed through view_users.php.

 echo '<h1>Изменить данные аккаунта</h1>';

 // Check for a valid user ID, through GET or POST:
 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From view_users.php
    $id = $_GET['id'];
 } elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
    $id = $_POST['id'];
 } else { // No valid ID, kill the script.
    echo '<p class="error">Произошла ошибка.</p>';
    exit();
 }

 require('../../mysqli_connect.php');
 session_start();

 // Check if the form has been submitted:
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $errors = [];

    // Check for a first name:
    if (empty($_POST['first_name'])) {
        $errors[] = 'Вы забыли ввести имя.';
    } else {
        $fn = mysqli_real_escape_string($dbc, trim($_POST ['first_name']));
    }

    // Check for a last name:
    if (empty($_POST['last_name'])) {
        $errors[] = 'Вы забыли ввести фамилию.';
    } else {
        $ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
    }

    // Check for an email address:
    if (empty($_POST['email'])) {
        $errors[] = 'Вы забыли ввести почту.';
    } else {
        $e = mysqli_real_escape_string($dbc, trim($_POST['email']));
    }

    if (empty($errors)) { // If everything's OK.

        // Test for unique email address:
        $q = "SELECT user_id FROM users WHERE email='$e' AND user_id != $id";
        $r = @mysqli_query($dbc, $q);
        if (mysqli_num_rows($r) == 0) {

            // Make the query:
            $q = "UPDATE users SET first_name='$fn', last_name='$ln', email='$e' WHERE user_id=$id LIMIT 1";
            $r = @mysqli_query($dbc, $q);
            if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
                $_SESSION['first_name'] = $fn;
                // Print a message:
                 echo '<p>Данные аккаунта изменены.</p>';

            } else { // If it did not run OK.
                echo '<p class="error">Данные аккаунта не могут быть изменены из-за системной ошибки. Мы извеняемся за неудобства.</p>'; // Public message.
                echo '<p>' . mysqli_error($dbc) . '<br>Query: ' . $q . '</p>';
                // Debugging message.
            }

        } else { // Already registered.
            echo '<p class="error">Почтовый адрес уже зарегестрирован.</p>';
        }

    } else { // Report the errors.

        echo '<p class="error">Следующие ошибки возникли:<br>';
        foreach ($errors as $msg) { // Print each error.
            echo " - $msg<br>\n";
        }
        echo '</p><p>Пожалуйста попробуйте снова.</p>';

    } // End of if (empty($errors)) IF.

 } // End of submit conditional.


 // Always show the form...

 // Retrieve the user's information:
 $q = "SELECT first_name, last_name, email FROM users WHERE user_id=$id";
 $r = @mysqli_query($dbc, $q);

 if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

    // Get the user's information:
    $row = mysqli_fetch_array($r, MYSQLI_NUM);

    // Create the form:
    echo '<style>
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
    <form class="register-form" action="account.php" method="POST">
        <input type="text" name="first_name" size="15" maxlength="15" value="' . $row[0] .'" placeholder="Имя">
        <input type="text" name="last_name" size="15" maxlength="30" value="' . $row[1] .'" placeholder="Фамилия">
        <input type="email" name="email" size="20" maxlength="60" value="' . $row[2] . '" placeholder="Почта">
        <input type="hidden" name="id" value="'. $id . '">
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
    echo '<form action="account.php" method="post">
            <p>Имя: <input type="text" name="first_name" size="15" maxlength="15"value="' . $row[0] .'"></p>
            <p>Вагаткин: <input type="text" name="last_name" size="15" maxlength="30" value="' . $row[1] .'"></p>
            <p>Почта: <input type="email" name="email" size="20" maxlength="60"value="' . $row[2] . '"> </p>
            <p><input type="submit" name="submit"value="Подтвердить"></p>
            <input type="hidden" name="id" value="'. $id . '">
        </form>';
    echo '<a href="index.php">На главную</a>';

 } else { // Not a valid user ID.
    echo '<p class="error">Произошла ошибка.</p>';
    echo '<a href="index.php">На главную</a>';
 }

 mysqli_close($dbc);
?>
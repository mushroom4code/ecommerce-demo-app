<?php
// This script performs an INSERT query to add a record to the users table.
$index_page = 'http://localhost/ecommerce/index.php';
// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize an error   array.
    $errors = [];

    require('../../mysqli_connect.php');

    // Chek for a first name:
    if (empty($_POST['first_name'])){
        $errors[] = 'Вы забыли ввести имя.';
    }
    else {
        $fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
    }

    // Check for a last name:
    if (empty($_POST['last_name'])) {
        $errors[] = 'Вы забали ввести фамилию.';
    }
    else {
        $ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
    }

    // Check for an email address:
    if (empty($_POST['email'])) {
        $errors[] = 'Вы забыли ввести почту.';
    }
    else {
        $e = mysqli_real_escape_string($dbc, trim($_POST['email']));
    }

    // Check for a password and match against the confirmed password:
    if (!empty($_POST['pass1'])) {
        if ($_POST['pass1'] != $_POST['pass2']) {
            $errors[] = 'Пароли не совпадают.';
        }
        else {
            $p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
        }
    }
    else {
        $errors[] = 'Вы забыли ввести пароль.';
    }

    if (empty($errors)) { //If everything's OK.
        // Register the user in the database...


        // Make the query:
        $q = "INSERT INTO users (first_name, last_name, email, pass, registration_date) VALUES ('$fn', '$ln', '$e', SHA2('$p', 512), NOW())";
         // Run the query.
        $r = @mysqli_query($dbc, $q);
        // If it ran OK.
        if ($r) {
            header('Location: '.$index_page);
            die();
            // Print a message:
            echo '<h1>Спасибо</h1>
            <p>Вы зарегестрированы</p>
            <p><br></p>';
        }
        // If it did not run OK.
        else {
            // Public message:
            echo '<h1>Системная ошибка</h1>
            <p class="error">Вы не можете зарегистрироваться из-зи системной ошибки. Мы извеняемся за неудобства.</p>';

            // Debuging message:
            echo '<p>'.mysqli_error($dbc).'<br><br>Query: '.$q.'</p>';

        // End of if ($r) IF.
        }

        // Close the database connection.
        mysqli_close($dbc);

        exit();
    }
    // Report the errors
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
// End of the main Submit conditional.
}
?>
<style>
    @import url(https://fonts.googleapis.com/css?family=Roboto:300);

.login-page {
  width: 360px;
  padding: 8% 0 0;
  margin: auto;
  margin-top: -70px;
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
<!-- <h1>Регистрация</h1>
<form action="register.php" method="POST">
    <p>Имя: <input type="text" name="first_name" size="15" maxlength="20" value="<?php
    if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>"></p>
    <p>Фамилия: <input type="text" name="last_name" size="15" maxlength="40" value="<?php
    if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>"></p>
    <p>Почта: <input type="email" name="email" size="20" maxlength="60" value="<?php
    if (isset($_POST['email'])) echo $_POST['email']; ?>"></p>
    <p>Пароль: <input type="password" name="pass1" size="10" maxlength="20" value="<?php
    if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>"></p>
    <p>Подтверждение пароля: <input type="password" name="pass2" size="10" maxlength="20" value="<?php
    if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>"></p>
    <p><input type="submit" name="submit" value="Register"></p>
</form> -->

<div class="login-page">
  <h1>Регистрация</h1>
  <div class="form">
    <form class="register-form" action="register.php" method="POST">
      <input type="text" placeholder="Имя" name="first_name" value="<?php
        if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>"/>
      <input type="text" placeholder="Фамилия" name="last_name" value="<?php
        if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>"/>
      <input type="email" placeholder="Почта" name="email" value="<?php
        if (isset($_POST['email'])) echo $_POST['email']; ?>"/>
      <input type="password" placeholder="Пароль" name="pass1" value="<?php
        if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>"/>
      <input type="password" placeholder="Подтверждение пароля" name="pass2" value="<?php
        if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>"/>
      <button type="submit">Зарегистрироваться</button>
      <p class="message" name="submit">Уже зарегистрированы? <a href="index.php" style="color: white">Войти</a></p>
    </form>
    <form class="login-form">
      <input type="text" placeholder="username"/>
      <input type="password" placeholder="password"/>
      <button>login</button>
      <p class="message">Not registered? <a href="#">Create an account</a></p>
    </form>
  </div>
</div>

<script>
$('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});
</script>
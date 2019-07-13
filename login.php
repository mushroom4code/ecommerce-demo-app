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
                $_SESSION['email'] = $e;
            }
        header('Location: '.$index_page);
        die();
        }
        else{
            echo "error in select";
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
<h1>Вход</h1>
<form action="login.php" method="POST">
    <p>Почта: <input type="email" name="email" size="20" maxlength="60" value="<?php
    if (isset($_POST['email'])) echo $_POST['email']; ?>"></p>
    <p>Пароль: <input type="password" name="pass" size="10" maxlength="20" value="<?php
    if (isset($_POST['pass'])) echo $_POST['pass']; ?>"></p>
    <p><input type="submit" name="submit" value="Вход"></p>
</form>
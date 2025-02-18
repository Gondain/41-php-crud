<?php 
include "includes/header.php";
require_once "connexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = strip_tags($_POST['login']);
    $email = strip_tags($_POST['email']);
    $password = strip_tags($_POST['pass']);
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $checkEmail = $db->prepare('SELECT email FROM users WHERE email = :email');
    $checkEmail->bindParam(":email", $email, PDO::PARAM_STR);
    $checkEmail->execute();

    if ($checkEmail->rowCount() > 0) {
        echo 'Email ID already exists';
        exit;
    } else {
        $statement = $db->prepare("INSERT INTO users (login, email, password) VALUES (:login, :email, :hashedPassword)");
        $statement->bindParam(":login", $login, PDO::PARAM_STR);
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->bindParam(":hashedPassword", $hashedPassword, PDO::PARAM_STR);

        if(!$statement->execute()) {
            die("The form was not sent to the db");
          }
    }

    header("location: index.php");
    exit;
}



?>
<div class='center'>
<h1>User subscription</h1>

    <form method="post" action="subscription.php">
        <div class='login'>
            <label for="login">Login :</label>
            <input type="text" name="login" required>
        </div>
        <div class='login'>
            <label for="email">Email :</label>
            <input type="email" name="email" required>
        </div>
        <div class='login'>
            <label for="pass">Password :</label>
            <input type="password" name="pass" class='pwd' required>
        </div>
        <button type="submit" class='boutton'>Subscribe</button>
    </form>
</div>


<?php
    include "includes/footer.php";
?>
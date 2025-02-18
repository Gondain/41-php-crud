<?php
session_start();

if(!empty($_POST)) {
    // 1. Check all the inputs exist
    // 2. We check also if the $_POST are not empty because we load the page, the form is empty
    if(isset($_POST['email'], $_POST['pass'])
        && !empty($_POST['email'])
        && !empty($_POST['pass'])) {
        
        //Sanitize the inputs
        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['pass']);

        //SQL part
        try {
          require_once "connexion.php";
          //1. Prepare the query
            $query = $db->prepare('SELECT * FROM users WHERE email = :email');
          //2. BindParam
            $query->bindParam(':email', $email, PDO::PARAM_STR);
          //3. Execute
            $query->execute();
          //4. Store the datas in a variable
            $user = $query->fetch(PDO::FETCH_ASSOC);
          //5. check the password input with the password in db
            if ($user) {
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_login'] = $user['login'];

                    header("Location: index.php");
                    exit;
                } else {
                    echo 'Invalid password';
                }
            } else {
                echo 'No user found with this email';
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    } else {
        echo 'Please fill in both fields';
    }
}

include "includes/header.php";

?>
<div class='center'>
    <h1>User Login:</h1>

    <form method="post" action="login.php">
        <div class='login'>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
        </div>
        <div class='login'>
            <label for="pass">Password:</label>
            <input type="password" name="pass" class='pwd' required>
        </div>
        <button type="submit" class='boutton'>Login</button>
    </form>
</div>
    
<?php
include "includes/footer.php";
?>
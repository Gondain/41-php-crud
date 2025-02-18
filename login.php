<?php


if(!empty($_POST)) {
    // 1. Check all the inputs exist
    // 2. We check also if the $_POST are not empty because we load the page, the form is empty
    if(isset($_POST)
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
            

        } catch(PDOException $e) {
            echo $e->getMessage();
            exit;
        }

        // store data of user in $_SESSION


    }
}

include "includes/header.php";

?>

    <h1>User Login</h1>

    <form method="post" action="login.php">
        <div>
            <label for="email">Email :</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label for="pass">Password</label>
            <input type="password" name="pass" required>
        </div>
        <button type="submit">Login</button>
    </form>



<?php
include "includes/footer.php";
?>
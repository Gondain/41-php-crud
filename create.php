<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// open the $_SESSION

// 1. Check all the inputs exist
// 2. We check also if the $_POST are not empty because we load the page, the form is empty
if($_SERVER["REQUEST_METHOD"] === "POST" 
    && !empty($_POST["name"]) 
    && !empty($_POST["location"])
    && !empty($_POST["selection"])) {

    //Sanitize the inputs
    $name = strip_tags($_POST["name"]);
    $location = strip_tags($_POST["location"]);
    $selection = strip_tags($_POST["selection"]);

    //SQL part
    try {
      require_once "connexion.php";

      //1. We prepare the request, because we will use user input
      // By doing that we protect against SQL injection
      $query = $db->prepare("INSERT INTO student (name, location, selection) VALUES (:name, :location, :selection)");
      
      //2. To ensure safe and secure database interactions by preventing SQL injection, use bindParam()
      // bindParam() only accepts a variable that is interpreted at the time of execute()
      // NB: I prefer bindParam() to bindValue(), because you can define parameter types. 
      $query->bindParam(":name", $name, PDO::PARAM_STR);
      $query->bindParam(":location", $location, PDO::PARAM_STR);
      $query->bindParam(":selection", $selection, PDO::PARAM_STR);
      
      //3. We execute the query. execute() return a boolean
      // NB: with the code below, we implicitly execute the query
      if(!$query->execute()) {
        die("The form was not sent to the db");
      }
      
    } catch (PDOException $e) {
      // We catch the error from PDO
      echo $e->getMessage();
      exit;
    }
      
    //4. Once is done, redirect to the index.php
    header("location: index.php");
    exit;

}


// HTML part
include "includes/header.php";

?>


<h1>Add a new student:</h1>

    <form method="post" action="create.php">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required> <br>
        <label for="location">Location:</label>
        <input type="text" name="location" id="location" required> <br>
        <label for="selection">Selection:</label>
        <input type="text" name="selection" id="selection" required> <br>
        <button type="submit">Send</button>
    </form>



<?php
    include "includes/footer.php";
?>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once "connexion.php";

// open the $_SESSION


// check if $_GET is empty
if(empty($_GET["id"])) {
  echo "The id doesn't exist";
  exit;
}

if(isset($_GET['id'])) {

  // Interact with the database
  try {
    //1. Prepare the query
    $statement = $db->prepare("SELECT * FROM student WHERE id = :id");

    //2. BindParam
    $statement->bindParam(':id', $_GET['id'],PDO::PARAM_INT);
    //3. Execute
    $statement->execute();
    //4. Store data in a $variable
    $student = $statement->fetch(PDO::FETCH_ASSOC);

  } catch (PDOException $e) {
    // We catch the error from PDO
    echo $e->getMessage();
    exit;
  }
}

// HTML part
include "includes/header.php";

?>

<h1><?=$student['name']?></h1>
<p>Campus: <?=$student['location']?></p>
<p>Sélection: <?=$student['selection']?></p>

<?php
    include "includes/footer.php";
?>

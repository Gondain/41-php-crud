<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


require_once "connexion.php";

// open the $_SESSION
session_start();

// Interact with the database
try {
  // 1. We can use a direct query, because we admit we will not use data from "outside" (GET or POST)
  $statement = $db->query("SELECT * FROM student");

} catch (PDOException $e) {
  // We catch the error from PDO
  echo $e->getMessage();
  exit;
}

// 2. We store the datas from the DB in an Associative Array
$students = $statement->fetchAll(PDO::FETCH_ASSOC);

include "includes/header.php";
?>

<!-- The HTML begins here -->
<main>
		<h1>Students of BeCode:</h1>
    <ol>
        <?php
            //display the datas
            foreach($students as $student) : ?>
                
            <li class='student'>
                <a href="single.php?id=<?=$student['id']?>">
                    <h3><?=$student['name']?></h3>
                </a>
            </li>

        <?php
            endforeach;
        ?>
    </ol>

</main>

<?php
    include "includes/footer.php";
?>
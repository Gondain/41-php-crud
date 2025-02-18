<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once "connexion.php";

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $query = $db->prepare("DELETE FROM student WHERE id = :id");

        $query->bindParam(':id', $id,PDO::PARAM_INT);
        
        if(!$query->execute()) {
          die("The form was not sent to the db");
        }
  
      } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
      }
        
      header("location: index.php");
      exit;
  }

?>
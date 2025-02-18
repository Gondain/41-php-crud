<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once "connexion.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID is missing.");
}

$id = (int)$_GET['id'];

try {
    $query = $db->prepare("SELECT name, location, selection FROM student WHERE id = :id");
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    $query->execute();
    
    $student = $query->fetch(PDO::FETCH_ASSOC);
    if (!$student) {
        die("Student not found.");
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}


if($_SERVER["REQUEST_METHOD"] === "POST" 
    && !empty($_POST["name"]) 
    && !empty($_POST["location"])
    && !empty($_POST["selection"])) {

    $name = strip_tags($_POST["name"]);
    $location = strip_tags($_POST["location"]);
    $selection = strip_tags($_POST["selection"]);

    try {
      $query = $db->prepare("UPDATE student SET name = :name, location = :location, selection = :selection WHERE id = :id");
      
      $query->bindParam(":name", $name, PDO::PARAM_STR);
      $query->bindParam(":location", $location, PDO::PARAM_STR);
      $query->bindParam(":selection", $selection, PDO::PARAM_STR);
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

<h1>Edit this student:</h1>

    <form method="post" action="edit.php?id=<?= htmlspecialchars($id) ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($student['name']) ?>" required> <br>
        <label for="location">Location:</label>
        <input type="text" name="location" id="location" value="<?= htmlspecialchars($student['location']) ?>" required> <br>
        <label for="selection">Selection:</label>
        <input type="text" name="selection" id="selection" value="<?= htmlspecialchars($student['selection']) ?>" required> <br>
        <button type="submit">Edit</button>
    </form>

<?php include "includes/footer.php";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your title</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>

<header>
    <nav>
        <ul>
            <li ><a href="./" class="nav">Home</a></li>
            <li><a href="subscription.php" class="nav">Register</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="create"><a href="create.php" class="nav">Add student</a></li>
                <li><a href="logout.php" class="nav">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php" class="nav">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
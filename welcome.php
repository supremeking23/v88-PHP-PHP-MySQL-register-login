<?php 
session_start();
if(!isset($_SESSION["first_name"])){
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1> welcome <?= $_SESSION["first_name"];?></h1>
        <a href="login.php">Logout</a>
    </div>
</body>
</html>
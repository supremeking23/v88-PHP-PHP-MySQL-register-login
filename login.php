<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- <div div class="dim">
        error
    </div> -->
    <div class="container">

        <?php 
        if(isset($_SESSION["errors"])){
                foreach($_SESSION["errors"] as $errors):?>
                <div class="alert alert-danger">
                    <?= $errors;?>
                </div>
                <?php endforeach;
        }

        ?>
       
        
       
       <div class="cta">
           <h1>Learn to code</h1>
           <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Laudantium voluptate quo, dolorem rem nostrum harum earum unde alias omnis officia adipisci, amet consequuntur quasi suscipit facere dolor repudiandae magnam? Voluptas.</p>
       </div>

       <div class="form">
            <h2>Login Form</h2>

            <form action="process.php" method="POST">
                <input type="hidden" name="process_type" value="login">
                <input type="text" name="email" placeholder="Email" class=<?= (isset($_SESSION["error"]["error-email"]) ? "error-field" :"")?> value="">
                <input type="password" name="password" placeholder="Password" class=<?= (isset($_SESSION["error"]["error-password"]) ? "error-field" :"")?>   value="">
               
                <input type="submit" name="submit" value="Login">
                <p>Dont have an account ? <a href="index.php">Register here</a></p>
            </form>

        </div>

        <p class="created_by">Created By: Ivan Christian Jay Funcion</p>
    </div>
    
</body>
</html>
<?php 
unset($_SESSION["errors"]);
unset($_SESSION["error"]);
unset($_SESSION["first_name"]);
unset($_SESSION["email"]);

?>
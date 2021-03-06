<?php 
session_start();
require_once("connection.php");
date_default_timezone_set('Asia/Manila');
if(isset($_POST["process_type"]) AND $_POST["process_type"] === "register") {

    function checkForNumericCharacter($str){
        $strArray = str_split($str);
        // $has_error = false;
        for($i = 0; $i < count($strArray); $i++){
            if(is_numeric($strArray[$i])){
                // $has_error = true;
                return TRUE;
                // break;
            }
        }
    }
    
    if(empty($_POST["first_name"])){
        $_SESSION["errors"][] = "First Name cannot be blank";
        $_SESSION["error"]["error-first-name"] = TRUE;
    }
    if(empty($_POST["last_name"])){
        $_SESSION["errors"][] = "Last Name cannot be blank";
        $_SESSION["error"]["error-last-name"] = TRUE;
    }
    if(empty($_POST["email"])){
        $_SESSION["errors"][] = "Email cannot be blank";
        $_SESSION["error"]["error-email"] = TRUE;
    }
    if(empty($_POST["password"])){
        $_SESSION["errors"][] = "Password cannot be blank";
        $_SESSION["error"]["error-password"] = TRUE;
    }
    if(empty($_POST["confirm_password"])){
        $_SESSION["errors"][] = "Confirm Password cannot be blank";
        $_SESSION["error"]["error-confirm-password"] = TRUE;
    }

    
    if(checkForNumericCharacter($_POST["first_name"])){
        $_SESSION["errors"][] = "First name cannot have a number";
    }

    if(checkForNumericCharacter($_POST["last_name"])){
        $_SESSION["errors"][] = "Last name cannot have a number";
    }

    if(!empty($_POST["first_name"]) AND !(strlen($_POST["first_name"]) > 2)){
        $_SESSION["errors"][] = "First name must be atleast 2 characters long";
    }

    if(!empty($_POST["last_name"]) AND !(strlen($_POST["last_name"]) > 2)){
        $_SESSION["errors"][] = "Last name must be atleast 2 characters long";
    }

    $email = escape_this_string($_POST["email"]);
    if(!empty($_POST["email"]) AND !(filter_var($email,FILTER_VALIDATE_EMAIL))){
        $_SESSION["errors"][] = "Email must be valid";
    }

    // 
    if((!empty($_POST["password"]) AND !empty($_POST["confirm_password"])) AND (strlen($_POST["password"]) !== strlen($_POST["confirm_password"]))) {
        $_SESSION["errors"][] = "password and confirm password does not match";
    }

    if((!empty($_POST["password"]) AND !(strlen($_POST["password"]) > 8))){
        $_SESSION["errors"][] = "password must be atleast 8 characters long";
    }


    if(isset($_SESSION["errors"]) AND count($_SESSION["errors"]) > 0){
        header("Location: index.php");
        die();
    }


    //sanitize field
    $first_name = escape_this_string($_POST["first_name"]);
    $last_name = escape_this_string($_POST["last_name"]);
    $email = escape_this_string($_POST["email"]);
    $password = escape_this_string($_POST["password"]);
    $confirm_password = escape_this_string($_POST["confirm_password"]);

    $salt = bin2hex(openssl_random_pseudo_bytes(22));
    $encrypted_password = md5($password . '' . $salt);

    //check if email is exist
    $query = "SELECT * FROM users WHERE email = '$email'";
    $run_query = fetch_record($query);
    if($run_query){
        
        
        // $_SESSION["errors"][] = "Email already exist";
        header("Location: index.php");
    }else {

        $query = "INSERT INTO users(first_name,last_name,email,password,salt,created_at) VALUES ('$first_name','$last_name','$email','$encrypted_password', '$salt',NOW())";
        $run_query = run_mysql_query($query);
        if($run_query){
            echo $run_query;
            $_SESSION["first_name"] = $first_name;
            $_SESSION["email"] = $email;
            header("Location: welcome.php");
            //success
        }

    }



}else if(isset($_POST["process_type"]) AND $_POST["process_type"] === "login") {
    $email = escape_this_string($_POST["email"]);
    $password = escape_this_string($_POST["password"]);

    if(empty($_POST["email"])){
        $_SESSION["errors"][] = "Email cannot be blank";
        $_SESSION["error"]["error-email"] = TRUE;
    }
    if(empty($_POST["password"])){
        $_SESSION["errors"][] = "Password cannot be blank";
        $_SESSION["error"]["error-password"] = TRUE;
    }

    if(isset($_SESSION["errors"]) AND count($_SESSION["errors"]) > 0){
        header("Location: login.php");
        die();
    }

     //check email if exist
     $query = "SELECT * FROM users WHERE email = '$email'";
     $user = fetch_record($query);
     if(!empty($user)){
        $encrypted_password = md5($password . '' . $user["salt"]);
        if($user["password"] == $encrypted_password){
            $_SESSION["first_name"] = $user["first_name"];
            header("Location: welcome.php");
        }else{
            $_SESSION["errors"][] = "Incorrect Password";
            header("Location: login.php");
        }
     }else {
        $_SESSION["errors"][] = "Incorrect Email";
        header("Location: login.php");
     }


}else {
    header("Location: index.php");
}

?>
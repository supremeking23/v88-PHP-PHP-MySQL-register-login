<?php 
$salt = bin2hex(openssl_random_pseudo_bytes(22));
echo $salt;
?>
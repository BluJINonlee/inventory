<?php
    $password = "totally";
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    echo $hashedPassword."<br/>";
    if(password_verify("totally",$hashedPassword)) {
        echo "The Password word worked!";
    } else {
        echo "failure!";
    }
?>
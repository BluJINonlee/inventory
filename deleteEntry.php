<?php
    include_once("connectDatabase.php");
    mysqli_autocommit($con,false);
    $sql = "DELETE FROM {$_REQUEST['deviceType']} WHERE id = {$_REQUEST['id']}";
    mysqli_query($con, $sql);
    
    if ($e = mysqli_errno($con)){
        echo $e;
    } else {
        mysqli_commit($con);
        echo "Success!";
        header("Location: index.php");
    }
?>
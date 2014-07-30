<?php
    include_once "connectDatabase.php";
    mysqli_autocommit($con,false);
    $deviceType = $_REQUEST['deviceType'];
    $id = $_REQUEST['id'];
    $site = $_REQUEST['site'];
    $location = $_REQUEST['location'];
    $model = $_REQUEST['model'];
    $asset = $_REQUEST['asset'];
    $serial = $_REQUEST['serial'];
    
    if ($deviceType != 'netPrinters') {
        $sid = $_REQUEST['sid'];
        $sql = "UPDATE {$_REQUEST['deviceType']} SET sid=$sid, site='$site', location='$location', model='$model', asset=$asset, serial='$serial' WHERE id=$id";
    } else {
        $sql = "UPDATE {$_REQUEST['deviceType']} SET site='$site', location='$location', model='$model', asset=$asset, serial='$serial' WHERE id=$id";
    }
    
    mysqli_query($con,$sql);
    
    if (mysqli_error($con)) {
        echo "error";
    } else {
        mysqli_commit($con);
        header("Location: index.php");
        echo "Success!";
    }
?>
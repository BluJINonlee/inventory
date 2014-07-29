<?php
    include_once "connectDatabase.php";
    mysqli_autocommit($con,false);
    $deviceType = $_REQUEST['deviceType'];
    $id = $_REQUEST['id'];
    $site = $_REQUEST['site'];
    $location = $_REQUEST['location'];
    $sid = $_REQUEST['sid'];
    $model = $_REQUEST['model'];
    $asset = $_REQUEST['asset'];
    $serial = $_REQUEST['serial'];
    
    if ($deviceType != 'netPrinters') {
        $sql = "UPDATE {$_REQUEST['deviceType']} SET sid=$sid, site='$site', location='$location', model='$model', asset=$asset, serial='$serial' WHERE id=$id";
    }
    
    mysqli_query($con,$sql);
    
    if (mysqli_error($con)) {
        echo "error";
    } else {
        echo "Success!";
    }
?>

<?php
session_start();
$_SESSION["site"] = $_REQUEST["site"];

foreach ($_REQUEST as $name => $value){
	echo $name . ": " . $value. "<br/>";
} 

$asset = $_REQUEST["asset"];
$serial = $_REQUEST["serial"];
$model = $_REQUEST["model"];


$con = mysqli_connect("localhost","root","","inventory");
$sql;
$asset;
$serial;
$model;

if ($_REQUEST["scanType"] != "pc"){

	$asset = $_REQUEST["asset"];
	$serial = $_REQUEST["serial"];
	$model = $_REQUEST["model"];
	$site = $_REQUEST["site"];
	$location = $_REQUEST["location"];
	$table;
	//if the type is a monitor scan
	if ($_REQUEST["scanType"]=="monitor"){
		$table = "Monitors";

	} else if ($_REQUEST["scanType"]=="printer"){
		$table = "Printers";

	} else if ($_REQUEST["scanType"]=="netPrinter"){
		$table = "NetPrinters";

	}
	$sql = "INSERT INTO $table (asset, serial, model, site, location) VALUES ('$asset', '$serial', '$model', '$site', '$location')";
} else {
	//if scanType is pc
}

mysqli_query($con, $sql);

if($error = mysqli_error($con)) {
	echo $error;
} else {
echo "Success!";
}
?>
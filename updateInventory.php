
<?php
session_start();
$_SESSION["site"] = $_REQUEST["site"];
$_SESSION["location"] = $_REQUEST["location"];

foreach ($_REQUEST as $name => $value){
	echo $name . ": " . $value. "<br/>";

} 
echo "\$_SESSION: ".$_SESSION["site"];


$con = mysqli_connect("localhost","root","","inventory");
mysqli_autocommit($con, false);
$sql;
$asset;
$serial;
$model;
$site = $_REQUEST["site"];
$location = $_REQUEST["location"];

$setCount = mysqli_query($con, "SELECT count(*)");

if ($_REQUEST["scanType"] != "pc"){

	$asset = $_REQUEST["asset"];
	$serial = $_REQUEST["serial"];
	$model = $_REQUEST["model"];
	
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
	mysqli_query($con, $sql);
} else {
	//if scanType is pc
	$table = "pcs";
	$results = mysqli_query($con, "SELECT COUNT(*) FROM pcs");
	$setCount = mysqli_fetch_array($results);
	$newSID = $setCount[0]+1;
	$asset1 = $_REQUEST["asset1"];
	$serial1 = $_REQUEST["serial1"];
	$model1 = $_REQUEST["model1"];
	$asset2 = $_REQUEST["asset2"];
	$serial2 = $_REQUEST["serial2"];
	$model2 = $_REQUEST["model2"];
	$asset3 = $_REQUEST["asset3"];
	$serial3 = $_REQUEST["serial3"];
	$model3 = $_REQUEST["model3"];




	$sql = "INSERT INTO $table (sid, asset, serial, model, site, location) VALUES ($newSID,'$asset1', '$serial1', '$model1', '$site', '$location') ";
	mysqli_query($con, $sql);
	if ($_REQUEST["asset2"] != null || $_REQUEST["asset2"] != "") {
		$table = "monitors";
		$sql = "INSERT INTO $table (sid, asset, serial, model, site, location) VALUES ($newSID,'$asset2', '$serial2', '$model2', '$site', '$location'); ";
		mysqli_query($con, $sql);
	}
	if ($_REQUEST["asset3"] != null || $_REQUEST["asset3"] != "") {
		if($_REQUEST["misc1"] == "monitor"){
			$table = "Monitors";
		} else {
			$table = "Printers";
		}
		
		$sql = "INSERT INTO $table (sid, asset, serial, model, site, location) VALUES ($newSID,'$asset3', '$serial3', '$model3', '$site', '$location'); ";
		mysqli_query($con, $sql);
	}

	if ($_REQUEST["asset4"] != null || $_REQUEST["asset4"] != "") {
		if($_REQUEST["misc2"] == "monitor"){
			$table = "Monitors";
		} else {
			$table = "Printers";
		}
		
		$sql = "INSERT INTO $table (sid, asset, serial, model, site, location) VALUES ($newSID,'$asset3', '$serial3', '$model3', '$site', '$location'); ";
		mysqli_query($con, $sql);
	}
}



if($error = mysqli_error($con)) {
	echo $error;
} else {
	//mysqli_commit($con);
echo "Success!";
//header("Location: index.php");
}
?>
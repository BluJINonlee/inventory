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

function ifNull ($data) {
	if ($data == "" || $data == null){
		return "NULL";
	} else {
		return "'".$data."'";
	}
}


$setCount = mysqli_query($con, "SELECT max(*) from pcs");

if ($_REQUEST["scanType"] != "pc"){

	$asset = ifNull($_REQUEST["asset"]);
	$serial = ifNull($_REQUEST["serial"]);
	$model;
	if ($_REQUEST["newModel"]){
		$model = $_REQUEST["newModel"];
	} else {
		$model = $_REQUEST["model"];
	}
	
	
	$table;
	//if the type is a monitor scan
	if ($_REQUEST["scanType"]=="monitor"){
		$table = "Monitors";

	} else if ($_REQUEST["scanType"]=="printer"){
		$table = "Printers";

	} else if ($_REQUEST["scanType"]=="netPrinter"){
		$table = "NetPrinters";

	}
	//to-do: after changing MySQL's lastUpdate to DATE type, either make the default in MySQL curdate(), or make every new entry curdate() when inserting in PHP
	$sql = "INSERT INTO $table (asset, serial, model, site, location) VALUES ($asset, $serial, '$model', '$site', '$location')";
	mysqli_query($con, $sql);
} else {
	//if scanType is pc
	$table = "pcs";
	$results = mysqli_query($con, "SELECT COUNT(*) FROM pcs");
	$setCount = mysqli_fetch_array($results);
	$newSID = $setCount[0]+1;
	$asset1 = ifNull($_REQUEST["pcAsset"]);
	$serial1 = ifNull($_REQUEST["pcSerial"]);
	$model1;
	if ($newPCModel = $_REQUEST["newPCModel"]){
		$model1 = $newPCModel;
	} else {
		$model1 = $_REQUEST["pcModel"];
	}
	$asset2 = $_REQUEST["monitorAsset"];
	$serial2 = $_REQUEST["monitorSerial"];
	$model2;
	if ($newMonitorModel = $_REQUEST["newMonitorModel"]){
		$model2 = ifNull($newMonitorModel);
	} else {
		$model2 = $_REQUEST["monitorModel"];
	}
	$asset3 = ifNull($_REQUEST["asset3"]); //first misc item
	$serial3 = ifNull($_REQUEST["serial3"]);
	$model3 = ifNull($_REQUEST["model3"]);
	$asset4 = ifNull($_REQUEST["asset4"]);//second misc item
	$serial4 = ifNull($_REQUEST["serial4"]);
	$model4 = ifNull($_REQUEST["model4"]);



	//inserts pc info into DB
	$sql = "INSERT INTO $table (sid, asset, serial, model, site, location) VALUES ($newSID,$asset1, $serial1, '$model1', '$site', '$location') ";
	mysqli_query($con, $sql);
	echo $sql."<br/>";
	//if any, inserts monititor info into DB
	if ($asset2 != null || $asset2 != "") {
		$table = "monitors";
		$sql = "INSERT INTO $table (sid, asset, serial, model, site, location) VALUES ($newSID,$asset2, $serial2, '$model2', '$site', '$location'); ";
		mysqli_query($con, $sql);
		echo $sql."<br/>";
	}
	//if any, inserts first misc item into DB
	if (($_REQUEST["asset3"] != null || $_REQUEST["asset3"] != "") || ($_REQUEST["serial3"] != null || $_REQUEST["serial3"] != "")) {
		if($_REQUEST["misc1"] == "monitor"){
			$table = "Monitors";
		} else {
			$table = "Printers";
		}
		
		$sql = "INSERT INTO $table (sid, asset, serial, model, site, location) VALUES ($newSID,$asset3, $serial3, $model3, '$site', '$location'); ";
		mysqli_query($con, $sql);
		echo $sql."<br/>";
	}
	//if any, inserts second misc itme into DB
	if (($_REQUEST["asset4"] != null || $_REQUEST["asset4"] != "") || ($_REQUEST["serial4"] != null || $_REQUEST["serial4"] != "")) {
		if($_REQUEST["misc2"] == "monitor"){
			$table = "Monitors";
		} else {
			$table = "Printers";
		}
		$sql = "INSERT INTO $table (sid, asset, serial, model, site, location) VALUES ($newSID,$asset4, $serial4, $model4, '$site', '$location'); ";
		mysqli_query($con, $sql);
		echo $sql."<br/>";
	}
}



if($error = mysqli_error($con)) {
	echo $error;
} else {
	mysqli_commit($con);
	echo "Success!";
	header("Location: index.php");
}
?>
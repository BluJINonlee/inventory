<?php
session_start();
$_SESSION["site"] = $_REQUEST["site"];
$_SESSION["location"] = ( $_REQUEST["newLocation"] ? $_REQUEST["newLocation"] : $_REQUEST["location"]) ;
//include_once("connectDatabase.php");
include_once("ifNull.php");
include_once("entry.php");

if (isset($_REQUEST['model'])) {
	$_SESSION['model'] = $_REQUEST['model'];
}
foreach ($_REQUEST as $name => $value){
	echo $name . ": " . $value. "<br/>";

} 
echo "\$_SESSION: ".$_SESSION["site"];
$sql;
$asset;
$serial;
$model;
$site = $_REQUEST["site"];
//$location = $_REQUEST["location"];
if ($newLocation = $_REQUEST["newLocation"]){
		$location = $newLocation;
	} else {
		$location = $_REQUEST["location"];
	}
$table;
$sid = null;
echo $sid;



if ($_REQUEST["scanType"] != "pc"){
	$asset = $_REQUEST["asset"];
	$serial = $_REQUEST["serial"];
	$model;
	if (isset($_REQUEST["newModel"])){
		$model = $_REQUEST["newModel"];
	} else {
		$model = $_REQUEST["model"];
	}
	//determines what table the entry is inserted into
	if ($_REQUEST["scanType"]=="monitor"){
		$table = "monitors";
	} else if ($_REQUEST["scanType"]=="printer"){
		$table = "printers";
	} else if ($_REQUEST["scanType"]=="netPrinter"){
		$table = "netPrinters";
	}
	//create new entry class with the $_REQUEST variables
	$item = New Entry($table,$site,$location,$model,$asset,$serial,null,null,$sid);
	$item->submit();
	
} else {
	//if scanType is pc
	$item1;
	$item2;
	$item3;
	$item4;
	$items = [];
	$table = "pcs";
	$sid = Entry::getSID();
	$asset1 = $_REQUEST["pcAsset"];
	$serial1 = $_REQUEST["pcSerial"];
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
	$asset3 = $_REQUEST["asset3"]; //first misc item
	$serial3 = $_REQUEST["serial3"];
	$model3 = $_REQUEST["model3"];
	$asset4 = $_REQUEST["asset4"];//second misc item
	$serial4 = $_REQUEST["serial4"];
	$model4 = $_REQUEST["model4"];



	//inserts pc info into DB
	array_push($items, new Entry($table,$site,$location,$model1,$asset1,$serial1,$lastName,$firstName,$sid));
	//if any, inserts monititor info into DB
	if ($asset2 != null || $asset2 != "") {
		$table = "monitors";
		array_push($items, new Entry($table, $site, $location, $model2, $asset2, $serial2, $lastName, $firstName, $sid));
	}
	//if any, inserts first misc item into DB
	if (($_REQUEST["asset3"] != null || $_REQUEST["asset3"] != "") || ($_REQUEST["serial3"] != null || $_REQUEST["serial3"] != "")) {
		if($_REQUEST["misc1"] == "monitor"){
			$table = "Monitors";
		} else {
			$table = "Printers";
		}
		
		array_push($items, new Entry($table, $site, $location, $model3, $asset3, $serial3, $lastName, $firstName, $sid));
	}
	//if any, inserts second misc itme into DB
	if (($_REQUEST["asset4"] != null || $_REQUEST["asset4"] != "") || ($_REQUEST["serial4"] != null || $_REQUEST["serial4"] != "")) {
		if($_REQUEST["misc2"] == "monitor"){
			$table = "Monitors";
		} else {
			$table = "Printers";
		}
		array_push($items, new Entry($table, $site, $location, $model4, $asset4, $serial4, $lastName, $firstName, $sid));
	}
}

try{
	for ($i = 0; $i < sizeof($items); $i++) {
		//$items[$i]->submit();
	}
	header("Location: index.php?$e");
} catch (Exception $e) {
	echo $e; 
}


?>
<?php
//start session
session_start();

//sets session variable that holds the last values entered
$_SESSION["site"] = $_REQUEST["site"];
$_SESSION["location"] = ( $_REQUEST["newLocation"] ? $_REQUEST["newLocation"] : $_REQUEST["location"]) ;

// include_once("connectDatabase.php");
// Import method to check values for NULL values.
include_once("ifNull.php");

//
include_once("entry.php");

// Set session variable to remember last input model.
if (isset($_REQUEST['model'])) {
	$_SESSION['model'] = $_REQUEST['model'];
}

// Lists all request variables for debugging purposes.
foreach ($_REQUEST as $name => $value){
	echo $name . ": " . $value. "<br/>";

} 
// List site in Session variable
echo "\$_SESSION: ".$_SESSION["site"];

// Declare local variables to hold request variables.
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
	// Determine what table the entry is inserted into
	if ($_REQUEST["scanType"]=="monitor"){
		$table = "monitors";
	} else if ($_REQUEST["scanType"]=="printer"){
		$table = "printers";
	} else if ($_REQUEST["scanType"]=="netPrinter"){
		$table = "netPrinters";
	}
	// Create new entry class with the $_REQUEST variables. (OOP Implementation)
	$item = New Entry($table,$site,$location,$model,$asset,$serial,null,null,$sid);
	$item->submit();
	
} else {
	// If scan type is pc, create variables to hold PC and its peripherals
	$item1;
	$item2;
	$item3;
	$item4;
	// Create array to hold entry objects created for the set.
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



	// Create new Entry for PC and add to the item array.
	array_push($items, new Entry($table,$site,$location,$model1,$asset1,$serial1,$lastName,$firstName,$sid));
	// If any, create new Entry for monitors and add to the item array.
	if ($asset2 != null || $asset2 != "") {
		$table = "monitors";
		array_push($items, new Entry($table, $site, $location, $model2, $asset2, $serial2, $lastName, $firstName, $sid));
	}
	// If any, create new Entry for first extra peripheral and add to the item array.
	if (($_REQUEST["asset3"] != null || $_REQUEST["asset3"] != "") || ($_REQUEST["serial3"] != null || $_REQUEST["serial3"] != "")) {
		if($_REQUEST["misc1"] == "monitor"){
			$table = "Monitors";
		} else {
			$table = "Printers";
		}
		
		array_push($items, new Entry($table, $site, $location, $model3, $asset3, $serial3, $lastName, $firstName, $sid));
	}
	// If any, create new Entry for second extra peripheral and add to the item array.
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
	// Submit all items in the $items array.
	for ($i = 0; $i < sizeof($items); $i++) {
		$items[$i]->submit();
	}
	// Return to the form.
	header("Location: index.php?$e");
} catch (Exception $e) {
	echo $e; 
}


?>
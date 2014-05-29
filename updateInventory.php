<?php
	

	if (!$_REQUEST) {
		//header("location: index.html");
	} 
	



	$con = mysqli_connect("localhost","root","","toy");

	if($error=mysqli_connect_errno()) {
		echo "Database didn't connect: {$error}";
	} else {
		echo "Everything is fine.";
	}

	$counter = 0;
	echo "This is what has been submitted: </br>";
	foreach ($_POST as $key => $value) {
		echo  $key . " = " . $value . "</br>";
	}
	$sizeOfPost = sizeof($_POST);
	echo "\$_POST has $sizeOfPost items </br>";

	if($sizeOfPost < 1) {
		//redirect back to the page.
	} elseif ($sizeOfPost == 1) {
		$sql = "INSERT INTO Inventory (computer) VALUES ({$_POST['1']})";
	} elseif ($sizeOfPost == 2) {
		$sql = "INSERT INTO Inventory (computer, monitor) VALUES ({$_POST['1']}, {$_POST['2']})";
	} else {
		$sql = "INSERT INTO Inventory (computer, monitor, printer) VALUES ({$_POST['1']}, {$_POST['2']}, {$_POST['3']})";
	}

	mysqli_query($con,$sql);

	if($error=mysqli_error($con)){
		echo "<br/> $error";
	} else {
		echo "<br/> Success!";
		header("Location: index.html");
	}
	echo $sql;
?>
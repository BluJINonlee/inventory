<?php

$con = mysqli_connect("localhost","root", "", "inventory");

$results = mysqli_query($con, "SELECT COUNT(*) FROM pcs");

$setCount = mysqli_fetch_array($results);
echo $setCount[0];


?>
<?php

	// DB Parameters
	$servername = "127.0.0.1";
	$username = "root";
	$password = "";
	$database = "test";
	$table = "products";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $database);
	
	
	$id = $_GET['id'];
	
	$sql = "SELECT count(*) FROM $table WHERE product_id = $id ";
	$result = $conn->query($sql);
	$row = mysqli_fetch_array($result, MYSQLI_BOTH);
	echo $row[0];
?>
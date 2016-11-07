<?php
	/////////////////////////////////////////////////////////////////////////////////   Functions:  ///////////////////////////////////////////////////////////////////
	function GetIP()
	{
		if ( getenv("HTTP_CLIENT_IP") ) {
			$ip = getenv("HTTP_CLIENT_IP");
		} elseif ( getenv("HTTP_X_FORWARDED_FOR") ) {
			$ip = getenv("HTTP_X_FORWARDED_FOR");
			if ( strstr($ip, ',') ) {
				$tmp = explode(',', $ip);
				$ip = trim($tmp[0]);
			}
		} else {
			$ip = getenv("REMOTE_ADDR");
		}
		return $ip;
	}

	function print_nice($variable_name, $sql) {
		echo "<br>------------------------------------------------------------------------------------------------------------------------";
		echo "<br>$variable_name: |$sql|<br>";
		echo "------------------------------------------------------------------------------------------------------------------------<br>";
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	

	$ip = GetIP();
	$id = $_GET['id'];
	//print_nice("IP", $ip);
	
	// DB Parameters
	$servername = "127.0.0.1";
	$username = "root";
	$password = "";
	$database = "test";
	$table = "products";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $database);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	//echo "Connected successfully";
	
	// Check connection
	if (mysqli_connect_errno()) {
		echo 'NOT_OK';
		//echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	

		
	$sql = "SELECT count(*) FROM $table WHERE product_id = $id and  ip =  '" . $ip . "'  ";
	$result = $conn->query($sql);
	$row = mysqli_fetch_array($result, MYSQLI_BOTH);


	
	if ($row[0] < 1) {
		$insert = "insert into products values ($id, '" . $ip . "' ) ";
		//echo "<br>" . $insert;
		
		if ($conn->query($insert) === TRUE) {
			//echo "New record created successfully";
		} else {//if(!result) echo mysql_error();
			echo "Error: " . $insert . "<br>" . $conn->error;
		}
		
		$sql = "SELECT count(*) FROM $table WHERE product_id = $id ";
		$result = $conn->query($sql);
		$row = mysqli_fetch_array($result, MYSQLI_BOTH);
		//print_nice("Current count for Product 1", $row[0]);
		echo $row[0];
		
	} else {
		echo $row[0];
		echo "<script> alert('You already voted for this product.') </script>";
		
		$sql = "SELECT count(*) FROM $table WHERE product_id = $id ";
		$result = $conn->query($sql);
		$row = mysqli_fetch_array($result, MYSQLI_BOTH);
		//print_nice("Current count for Product 1", $row[0]);
	}
	

	
	
	//$sql = "UPDATE products 
    //SET counter = counter + 1, ips =
    //WHERE product_id = '1'  ";
	//
	//
	//
	//echo "<br>" . $sql;
    //
	//if ($conn->query($sql) === TRUE) {
	//	echo "New record created successfully";
	//} else {
	//	echo "Error: " . $sql . "<br>" . $conn->error;
	//}
    //
    //
	//// Increasing the current value with 1
	//// mysqli_query($connection,"UPDATE articles SET amount = (amount + 1)
	////   WHERE id='1'");

	mysqli_close($conn);

	//echo "<br><b> All Good!";   
  
?>

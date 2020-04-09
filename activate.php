<?php
	$verificationCode = $_GET['code'];
	
	$host = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbname = "ksk";
	//create connection
	$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
	if (mysqli_connect_error()) {
		$msg = "Connection Error!";
		die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
	}
	else {
		// check first if record exists
		$query = "SELECT userid FROM user WHERE verificationcode = '$verificationCode' and verificationstatus = '0'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$stmt->store_result();
		$rnum = $stmt->num_rows;
		 
		if($rnum>0){
			$currentdate = date('Y-m-d');
		 
			// update the 'verified' field, from 0 to 1 (unverified to verified)
			$query = "UPDATE user set verificationstatus = '1', activeflag = '1', verificationdate = '$currentdate', lastpassworddate = '$currentdate' where verificationcode = '$verificationCode'";
		 
			$stmt = $conn->prepare($query);
			if($stmt->execute()){
				// tell the user
				echo "<script type='text/javascript'>alert('Your email is valid, thanks!. You may now login.')</script>";
			}
			else {
				echo "<script type='text/javascript'>alert('Unable to update verification code.')</script>";
			}
		}
		else {
			// tell the user he should not be in this page
			echo "<script type='text/javascript'>alert('We can't find your verification code.')</script>";
		}
		
		header("refresh:2; url=http://localhost/ksk/login.php");
	}
?>
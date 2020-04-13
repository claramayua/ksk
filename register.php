<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Kechara Soup Kitchen</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Monoton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Miss+Fajardose&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>

    <div class="py-1 bg-black top">
    	<div class="container">
    		<div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
	    		<div class="col-lg-12 d-block">
		    		<div class="row d-flex">
		    			<div class="col-md pr-4 d-flex topper align-items-center">
					    	<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
						    <span class="text">+603 2141 6046</span>
					    </div>
					    <div class="col-md pr-4 d-flex topper align-items-center">
					    	<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
						    <span class="text">ksk@kechara.com</span>
					    </div>
					    <div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right justify-content-end">
						    <p class="mb-0 register-link"><span>17, Jalan Barat, 55100 Kuala Lumpur, Malaysia</span></p>
					    </div>
				    </div>
			    </div>
		    </div>
		  </div>
    </div>
	  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="index.php">Kechara Soup Kitchen</a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	        	<li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
            <li class="nav-item active"><a href="about.php" class="nav-link">About</a></li>
            <li class="nav-item active"><a href="services.php" class="nav-link">Services</a></li>
            <li class="nav-item active"><a href="team.php" class="nav-link">Team</a></li>
            <li class="nav-item active"><a href="contact.php" class="nav-link">Contact</a></li>
            <li class="nav-item cta"><a href="login.php" class="nav-link">Login</a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->

<?php
	$msg = "";
	$fullname = "";
	$email = "";
	$role = "";
	$address = "";
	$phone = "";
	$driverlicense = "";
?>

<?php
	// Import PHPMailer classes into the global namespace
	// These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	// Load Composer's autoloader
	require 'vendor/autoload.php';

	//Get the data from the input form
	//Save into the database
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$fullname = $_POST['fullname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$retypePassword = $_POST['retypepassword'];
		$role = $_POST['role'];
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$driverlicense = $_POST['driverlicense'];
		
		//echo "<script type='text/javascript'>alert('" . $password . " and " . $retypePassword . "')</script>";
		
		if($password != $retypePassword) {
			$msg = "Check your password.";
		}
		else {
			// Validate password strength
			$uppercase = preg_match('@[A-Z]@', $password);
			$lowercase = preg_match('@[a-z]@', $password);
			$number    = preg_match('@[0-9]@', $password);

			if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
				$msg = "Password should be at least 8 characters in length and should include at least one upper case letter, and one number.";
			}
			else {	
				$password = md5($password);
				
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
					$SELECT = "SELECT userid From user Where email = ? and verificationstatus = '1'";
					//prepare statement
					$stmt = $conn->prepare($SELECT);
					$stmt->bind_param("s", $email);
					$stmt->execute();
					$stmt->bind_result($email);
					$stmt->store_result();
					$rnum = $stmt->num_rows;
					if ($rnum > 0) {
						$msg = "Your email has already been activated.";
					} 
					else {
						$stmt->close();
						//prepare statement
						$SELECT = "SELECT userid From user Where email = ? and verificationstatus = '0'";
						$stmt = $conn->prepare($SELECT);
						$stmt->bind_param("s", $email);
						$stmt->execute();
						$stmt->bind_result($email);
						$stmt->store_result();
						$rnum = $stmt->num_rows;
						if ($rnum > 0) {
							$msg = "Your email has already been in the system but has not yet verified.";
						} 
						else {
							// now, compose the content of the verification email, it will be sent to the email provided during sign up
							// generate verification code, acts as the "key"
							$verificationCode = md5(uniqid("yourrandomstringyouwanttoaddhere", true));
			 
							// send the email verification
							$verificationLink = "http://localhost/ksk/activate.php?code=" . $verificationCode;
			 
							// Instantiation and passing `true` enables exceptions
							$mail = new PHPMailer(true);
			
							$htmlStr = "";
							$htmlStr .= "Hi " . $email . ",<br /><br />";
			 
							$htmlStr .= "Please click the button below to verify your subscription and have access to the KSK systems.<br /><br /><br />";
							$htmlStr .= "<a href='{$verificationLink}' target='_blank' style='padding:1em; font-weight:bold; background-color:blue; color:#fff;'>VERIFY EMAIL</a><br /><br /><br />";
			 
							$htmlStr .= "Kind regards,<br />";
							$htmlStr .= "KSK Admin<br />";
			 
			 
							$name = "KSK";
							$email_sender = "claramayuagusta@gmail.com";
							$subject = "Verification Link | KSK | Subscription";
			 
							$headers  = "MIME-Version: 1.0\r\n";
							$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
							$headers .= "From: {$name} <{$email_sender}> \n";
			 
							$body = $htmlStr;
			 
							// send email using the mail function, you can also use php mailer library if you want
							
							try {
								//Server settings
								//$mail->SMTPDebug  = SMTP::DEBUG_SERVER;                     // Enable verbose debug output
								$mail->isSMTP();                                            // Send using SMTP
								$mail->CharSet 	  = "utf-8";								// set charset to utf8
								$mail->Host       = 'smtp.gmail.com';                    	// Set the SMTP server to send through
								$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
								$mail->Username   = $email_sender;                     		// SMTP username
								$mail->Password   = 'Apinkbm13';                             // SMTP password
								$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
								$mail->Port       = 587;                                    // TCP port to connect to
								$mail->SMTPOptions = array(
									'ssl' => array(
										'verify_peer' => false,
										'verify_peer_name' => false,
										'allow_self_signed' => true
									)
								);

								//Recipients
								$mail->setFrom($email_sender, $name);
								$mail->addAddress($email, $fullname);     	// Add a recipient
								$mail->addReplyTo($email_sender, $name);

								// Content
								$mail->isHTML(true);                                  		// Set email format to HTML
								$mail->Subject = $subject;
								$mail->Body    = $body;
								
								header("refresh:2; url=http://localhost/ksk/login.php"); 
								
								$stmt->close();
								$INSERT = "INSERT INTO user (role, fullname, email, password, address, phone, driverlicense, verificationcode, verificationstatus, activeflag) VALUES ('$role', '$fullname', '$email', '$password', '$address', '$phone', '$driverlicense', '$verificationCode', '0', '0')";
								$stmt = $conn->prepare($INSERT);
								$stmt->execute();
								
								$mail->send();
								
								echo "<script type='text/javascript'>alert('A verification email were sent to " . $email . ", please open your email inbox and click the given link so you can login.')</script>";
								
							} catch (Exception $e) {
								$msg = "Verification email sending failed.";
								die();
							}
						}
					}
					$stmt->close();
					$conn->close();
				}
			}
		}
	}
?>	
    
    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/background_4.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-2 bread">Register</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Register <i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>
	
		<section class="ftco-section ftco-no-pt ftco-no-pb">
			<div class="container-fluid px-0">
				<div class="row d-flex no-gutters">
          <div class="col-md-6 order-md-last ftco-animate makereservation p-4 p-md-5 pt-5">
          	<div class="py-md-5">
	          	<div class="heading-section ftco-animate mb-5">
		          	<span class="subheading">Welcome to</span>
		            <h2 class="mb-4">Kechara Soup Kitchen</h2>
		          </div>
	            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="was-validated">
	              <div class="row">
                  <div class="col-md-12 mt-3">
                    <div class="form-group">
                      <label for="">Role</label>
                      <div class="select-wrap one-third">
                        <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                          <select name="role" id="role" class="form-control" onchange='CheckRole(this.value);' required>
                            <option <?php echo $role === "Donor" ? "selected" : "" ?> value="Donor">Donor</option>
                            <option <?php echo $role === "Volunteer" ? "selected" : "" ?> value="Volunteer">Volunteer</option>
                          </select>
                        </div>
                      </div>
					</div>
	                <div class="col-md-6">
	                  <div class="form-group">
	                    <label for="">Full Name</label>
	                    <input name="fullname" type="text" class="form-control" value="<?php echo $fullname === "" ? "" : $fullname ?>" required>
	                  </div>
	                </div>
	                <div class="col-md-6">
	                  <div class="form-group">
	                    <label for="">Email</label>
	                    <input name="email" type="email" class="form-control" value="<?php echo $email === "" ? "" : $email ?>" required>
	                  </div>
	                </div>
	                <div class="col-md-6">
	                  <div class="form-group">
	                    <label for="">Password</label>
	                    <input name="password" type="password" class="form-control" required>
	                  </div>
	                </div>
	                <div class="col-md-6">
	                  <div class="form-group">
	                    <label for="">Retype Password</label>
	                    <input name="retypepassword" type="password" class="form-control" required>
	                  </div>
	                </div>
	                <div class="col-md-6">
	                  <div class="form-group">
	                    <label for="">Address</label>
	                    <input name="address" type="text" class="form-control" value="<?php echo $address === "" ? "" : $address ?>" required>
	                  </div>
	                </div>
	                <div class="col-md-6">
					  <div class="form-group">
                        <label for="">Phone</label>
                        <input name="phone" type="text" pattern="[0-9]+" class="form-control" value="<?php echo $phone === "" ? "" : $phone ?>">
                      </div>					
                    </div>
	                <div class="col-md-6">
	                  <div class="form-group">
	                    <label for="">Driver License (Volunteer Only)</label>
	                    <input name="driverlicense" id="driverlicense" type="text" class="form-control" value="<?php echo $driverlicense === "" ? "" : $driverlicense ?>">
	                  </div>
	                </div>
					<div class="col-md-6">
	                  <div class="form-group">
					  </div>					
                    </div>  
				  <div class="col-md-12 mt-3">
	                <div class="form-group">
					  <span class="error" style="color: red; font-family: Courier"><b><?php echo $msg === "" ? "" : "WARNING: " . $msg;?></b></span>
					</div>					
                  </div>
				  <div class="col-md-12 mt-3">
	                <div class="form-group">
	                  <input type="submit" value="Register" class="btn btn-primary py-3 px-5"><br>
					  <p><input type="checkbox" id="gridCheck" required>
			          <span style="color: red">I agree to the Terms of Use of Kechara Soup Kitchen.</span></p>
			          <p><a href="login.php">Already have an account? Login here.</a></p>
	                </div>
	              </div>
	              </div>
	            </form>
	          </div>
          </div>
          <div class="col-md-6 d-flex align-items-stretch pb-5 pb-md-0">
						<div class="mapouter"><div class="gmap_canvas"><iframe width="650" height="1000" id="gmap_canvas" src="https://maps.google.com/maps?q=kechara%20soup%20kitchen&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div><style>.mapouter{position:relative;text-align:right;height:1000px;width:650px;}.gmap_canvas {overflow:hidden;background:none!important;height:1000px;width:650px;}</style></div>
					</div>
        </div>
			</div>
		</section>

<script type="text/javascript">
	function CheckRole(val){
		var element=document.getElementById('driverlicense');
		if(val=='Volunteer')
			element.disabled=false;
		else  
			element.disabled=true;
	}
</script> 

    <footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container-fluid px-md-5 px-3">
        <div class="row mb-5">
          <div class="col-md-6 col-lg-3">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Address</h2>
              <p>17, Jalan Barat, Pudu, 55100 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur</p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-3">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Contact</h2>
              <p>Tel: +603 2141 6046 <br>
              Fax: +603 2141 6049 <br>
              Email: ksk@kechara.com</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Directions</h2>
              <p>At Jalan Imbi, take the second (2nd) left turn after the traffic light in front of the Honda showroom which is on your left. Once turned left, the Kechara Soup Kitchen is situated at the fourth shop lot on your right.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Pictures</h2>
              <div class="thumb d-sm-flex">
                <a href="#" class="thumb-menu img" style="background-image: url(images/picture_1.jpg);">
                </a>
                <a href="#" class="thumb-menu img" style="background-image: url(images/picture_2.jpg);">
                </a>
                <a href="#" class="thumb-menu img" style="background-image: url(images/picture_3.jpg);">
                </a>
              </div>
              <div class="thumb d-flex">
                <a href="#" class="thumb-menu img" style="background-image: url(images/picture_4.jpg);">
                </a>
                <a href="#" class="thumb-menu img" style="background-image: url(images/picture_5.jpg);">
                </a>
                <a href="#" class="thumb-menu img" style="background-image: url(images/picture_6.jpg);">
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> Kechara
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
        </div>
      </div>
    </footer>
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>
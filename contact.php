<?php
  //starting session
  session_start();
?>

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
		$fullname = $_POST['name'];
		$email_sender = $_POST['email'];
		$subject = $_POST['subject'];
		$message = $_POST['message'];
		
		//echo "<script type='text/javascript'>alert('" . $password . " and " . $retypePassword . "')</script>";
		
		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);
			
		$htmlStr = "";
		$htmlStr .= "Hi KSK admin,<br /><br />";
			 
		$htmlStr .= "The following message has been sent:<br />";
		$htmlStr .= "{$message}<br /><br />";
			 
		$htmlStr .= "Kind regards,<br />";
		$htmlStr .= "KSK Admin<br />";
			 
		$origin = "KSK";
		$email = "claramayuagusta@gmail.com";
			 
		$body = $htmlStr;
			 
		// send email using the mail function, you can also use php mailer library if you want
							
		try {
			//Server settings
			//$mail->SMTPDebug  = SMTP::DEBUG_SERVER;                     // Enable verbose debug output
			$mail->isSMTP();                                            // Send using SMTP
			$mail->CharSet 	  = "utf-8";								// set charset to utf8
			$mail->Host       = 'smtp.gmail.com';                    	// Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$mail->Username   = $email;                   		  		// SMTP username
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
			$mail->setFrom($email_sender, $fullname);
			$mail->addAddress($email, $origin);     					// Add a recipient
			$mail->addReplyTo($email_sender, $fullname);

			// Content
			$mail->isHTML(true);                                  		// Set email format to HTML
			$mail->Subject = $subject;
			$mail->Body    = $body;
								
			header("refresh:1; url=http://localhost/ksk/index.php"); 
								
			$mail->send();
								
			echo "<script type='text/javascript'>alert('The message has been sent.')</script>";
								
		} catch (Exception $e) {
			$msg = "Verification email sending failed.";
			die();
		}
	}
?>	
    
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

    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/background_4.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-2 bread">Contact</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Contact <i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>
	
		<section class="ftco-section contact-section bg-light">
      <div class="container">
        <div class="row d-flex contact-info">
          <div class="col-md-12 mb-4">
            <h2 class="h4 font-weight-bold">Contact Information</h2>
          </div>
          <div class="w-100"></div>
          <div class="col-md-3 d-flex">
          	<div class="dbox">
	            <p><span>Address</span></p>
              <p><span>17, Jalan Barat, Pudu, 55100 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur</span></p>
            </div>
          </div>
          <div class="col-md-3 d-flex">
          	<div class="dbox">
	            <p><span>Phone</span></p>
              <p><span>Tel: <a href="tel://0321416046">+603 2141 6046</a></span><br>
                <span>Fax: <a href="tel://0321416049">+603 2141 6049</a></span></p>
            </div>
          </div>
          <div class="col-md-3 d-flex">
          	<div class="dbox">
	            <p><span>Email</span></p>
              <p><span><a href="mailto:ksk@kechara.com">ksk@kechara.com</a></span></p>
            </div>
          </div>
          <div class="col-md-3 d-flex">
          	<div class="dbox">
	            <p><span>Project Director</span></p>
              <p><span>Justin Cheah</span><br>
                <span>Mobile: <br><a href="tel://0103333260">+6010 3333 260</a></span><br>
                <span>Email: <br><a href="mailto:justin.cheah@kechara.com">justin.cheah@kechara.com</a></span></p>
            </div>
          </div>
        </div>
      </div>
    </section>
	
		<section class="ftco-section ftco-no-pt ftco-no-pb contact-section">
			<div class="container">
				<div class="row d-flex align-items-stretch no-gutters">
					<div class="col-md-6 p-5 order-md-last">
						<h2 class="h4 mb-5 font-weight-bold">Contact Us</h2>
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="was-validated">
              <div class="form-group">
                <input name="name" type="text" class="form-control" placeholder="Your Name">
              </div>
              <div class="form-group">
                <input name="email" type="email" class="form-control" placeholder="Your Email">
              </div>
              <div class="form-group">
                <input name="subject" type="text" class="form-control" placeholder="Subject">
              </div>
              <div class="form-group">
                <textarea name="message" id="" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
              </div>
              <div class="form-group">
                <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
              </div>
            </form>
					</div>
					<div class="col-md-6 d-flex align-items-stretch">
						<div class="mapouter"><div class="gmap_canvas"><iframe width="550" height="600" id="gmap_canvas" src="https://maps.google.com/maps?q=kechara%20soup%20kitchen&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div><style>.mapouter{position:relative;text-align:right;height:600px;width:550px;}.gmap_canvas {overflow:hidden;background:none!important;height:600px;width:550px;}</style></div>
					</div>
				</div>
			</div>
		</div>
		
		<section class="ftco-section ftco-no-pt ftco-no-pb">
      <div class="container-fluid px-0">
        <div class="row no-gutters">
          <div class="col-md">
            <a href="#" class="instagram img d-flex align-items-center justify-content-center" style="background-image: url(images/picture_1.jpg);">
              <span class="ion-logo-instagram"></span>
            </a>
          </div>
          <div class="col-md">
            <a href="#" class="instagram img d-flex align-items-center justify-content-center" style="background-image: url(images/picture_2.jpg);">
              <span class="ion-logo-instagram"></span>
            </a>
          </div>
          <div class="col-md">
            <a href="#" class="instagram img d-flex align-items-center justify-content-center" style="background-image: url(images/picture_3.jpg);">
              <span class="ion-logo-instagram"></span>
            </a>
          </div>
          <div class="col-md">
            <a href="#" class="instagram img d-flex align-items-center justify-content-center" style="background-image: url(images/picture_4.jpg);">
              <span class="ion-logo-instagram"></span>
            </a>
          </div>
          <div class="col-md">
            <a href="#" class="instagram img d-flex align-items-center justify-content-center" style="background-image: url(images/picture_5.jpg);">
              <span class="ion-logo-instagram"></span>
            </a>
          </div>
        </div>
      </div>
    </section>

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
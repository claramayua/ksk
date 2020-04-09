<?php
	//Setting up session 
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
	//Check login session whether it is an applicant or officer
	//this to make sure page is accessed manually using its url
	$loginfullname = "";
	if(isset($_SESSION["loginUserID"])) {
		$loginUserID = $_SESSION["loginUserID"];
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
			$SELECT = "SELECT role From user Where userid = '".$loginUserID."' Limit 1";
			$stmt = $conn->query($SELECT);
			if ($stmt->num_rows > 0) {
				while($row = $stmt->fetch_assoc()) {
					if($row["role"] === "Volunteer") {
						$role = $row["role"];
						$loginfullname = $_SESSION["loginFullname"];
					}
					else {
						session_destroy();
						header('Location: http://localhost/ksk/login.php');
					}
				}
			}
		}		
	}
	else {
		session_destroy();
		header('Location: http://localhost/ksk/login.php');
	}
?>

<?php
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
		$link = "https"; 
	else
		$link = "http"; 
  
	// Here append the common URL characters. 
	$link .= "://"; 
  
	// Append the host(domain name, ip) to the URL. 
	$link .= $_SERVER['HTTP_HOST']; 
  
	// Append the requested resource location to the URL 
	$link .= $_SERVER['REQUEST_URI'];
	
	$_SESSION["lasturl"] = $link;
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
			  <li class="nav-item active"><a href="profile.php" class="nav-link">Profile</a></li>
              <li class="nav-item active"><a href="setting.php" class="nav-link">Setting</a></li>
			  <li class="nav-item active"><a href="changepassword.php" class="nav-link">Change Password</a></li>
			  <li class="nav-item active"><a href="logout.php" class="nav-link">Logout</a></li>
			  <li class="nav-item cta"><a href="menuvolunteer.php" class="nav-link">Volunteer Menu</a></li>
            </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->
   
    <section class="home-slider owl-carousel js-fullheight">
      <div class="slider-item js-fullheight" style="background-image: url(images/background_1.jpg);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text js-fullheight justify-content-center align-items-center" data-scrollax-parent="true">

            <div class="col-md-12 col-sm-12 text-center ftco-animate">
              <h1 class="mb-4 mt-5">Food Distribution</h1>
              <a href="#about" class="btn btn-primary p-3 px-xl-4 py-xl-3">Schedule</a>
			  <a href="#about" class="btn btn-primary p-3 px-xl-4 py-xl-3">Family</a>
			  <a href="#about" class="btn btn-primary p-3 px-xl-4 py-xl-3">Inventory</a>
			  <a href="#about" class="btn btn-primary p-3 px-xl-4 py-xl-3">Delivery</a>
			  <a href="#about" class="btn btn-primary p-3 px-xl-4 py-xl-3">Attendance</a>
			  <a href="#about" class="btn btn-primary p-3 px-xl-4 py-xl-3">Certificate</a>
            </div>

          </div>
        </div>
      </div>

      <div class="slider-item js-fullheight" style="background-image: url(images/background_2.jpg);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text js-fullheight justify-content-center align-items-center" data-scrollax-parent="true">

            <div class="col-md-12 col-sm-12 text-center ftco-animate">
              <h1 class="mb-4 mt-5">Soup Kitchen Building</h1>
              <a href="#about" class="btn btn-primary p-3 px-xl-4 py-xl-3">Schedule</a>
			  <a href="#about" class="btn btn-primary p-3 px-xl-4 py-xl-3">Family</a>
			  <a href="#about" class="btn btn-primary p-3 px-xl-4 py-xl-3">Inventory</a>
			  <a href="#about" class="btn btn-primary p-3 px-xl-4 py-xl-3">Delivery</a>
			  <a href="#about" class="btn btn-primary p-3 px-xl-4 py-xl-3">Attendance</a>
			  <a href="#about" class="btn btn-primary p-3 px-xl-4 py-xl-3">Certificate</a>
            </div>

          </div>
        </div>
      </div>

      <div class="slider-item js-fullheight" style="background-image: url(images/background_3.jpg);">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text js-fullheight justify-content-center align-items-center" data-scrollax-parent="true">

            <div class="col-md-12 col-sm-12 text-center ftco-animate">
              <h1 class="mb-4 mt-5">Food Bank</h1>
              <a href="#about" class="btn btn-primary p-3 px-xl-4 py-xl-3">Schedule</a>
			  <a href="#about" class="btn btn-primary p-3 px-xl-4 py-xl-3">Family</a>
			  <a href="#about" class="btn btn-primary p-3 px-xl-4 py-xl-3">Inventory</a>
			  <a href="#about" class="btn btn-primary p-3 px-xl-4 py-xl-3">Delivery</a>
			  <a href="#about" class="btn btn-primary p-3 px-xl-4 py-xl-3">Attendance</a>
			  <a href="#about" class="btn btn-primary p-3 px-xl-4 py-xl-3">Certificate</a>
            </div>

          </div>
        </div>
      </div>
    </section>
	
		
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
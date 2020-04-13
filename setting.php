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
  //Check login session whether it is a valid user or not
  //this to make sure page is accessed manually using its url
  $role = "";
  if(isset($_SESSION["loginUserID"])) {
    $userid = $_SESSION["loginUserID"];
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
		$SELECT = "SELECT role From user Where userid = '".$userid."' Limit 1";
		$stmt = $conn->query($SELECT);
		if ($stmt->num_rows > 0) {
			while($row = $stmt->fetch_assoc()) {
				$role = $row["role"];
			}
		}
		else {
			session_destroy();
			header('Location: http://localhost/ksk/login.php');
		}
	}		
  }
  else {
    session_destroy();
    header('Location: http://localhost/ksk/login.php');
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
	        	<<li class="nav-item active"><a href="showprofile.php" class="nav-link">Profile</a></li>
				<li class="nav-item active"><a href="setting.php" class="nav-link">Setting</a></li>
				<li class="nav-item active"><a href="changepassword.php" class="nav-link">Change Password</a></li>
			    <li class="nav-item active"><a href="logout.php" class="nav-link">Logout</a></li>
				<?php
					echo '<li class="nav-item cta"><a href="menu' . strtolower($role) . '.php" class="nav-link">' . $role . ' Menu</a></li>'
				?>
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
            <h1 class="mb-2 bread">Setting</h1>
            <p class="breadcrumbs">
			  <span class="mr-2"><a href="menu<?php echo strtolower($role); ?>.php"><?php echo $role; ?> Menu <i class="ion-ios-arrow-forward"></i></a></span> 
			  <span>Setting<i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>
	
		<section class="ftco-section ftco-no-pt ftco-no-pb">
			<div class="container-fluid px-0">
				<div class="row d-flex no-gutters">
					<div class="col-md-12 order-md-last ftco-animate makereservation p-4 p-md-5 pt-5">
						<div class="py-md-5">
							<div class="heading-section ftco-animate mb-5">
								<span class="subheading">Welcome to</span>
								<h2 class="mb-4">Kechara Soup Kitchen</h2>
							</div>
	                
<?php
	if ($role === "Staff") {
	    echo '<div class="col-md-24">';
	    echo '  <span>';
	    echo '    <b>User</b>: to manage user of the system. User data can be edited here.';
	    echo '  </span>';
		echo '</div>';
	}
	if ($role === "Staff" || $role === "Volunteer") {
	    echo '<div class="col-md-24">';
	    echo '  <span>';
	    echo '    <b>Family</b>: to manage family registered to the system. Staff can manage family data including adding and editing the data, as well as adding special order by the family.';
	    echo '  </span>';
		echo '</div>';
	}
	if ($role === "Staff") {
	    echo '<div class="col-md-24">';
	    echo '  <span>';
	    echo '    <b>Product</b>: to manage product handled by the project. Staff can manage product data including adding, editing, and deleting the data.';
	    echo '  </span>';
		echo '</div>';
	}
	if ($role === "Staff" || $role === "Volunteer" || $role === "Donor") {
	    echo '<div class="col-md-24">';
	    echo '  <span>';
	    echo '    <b>Inventory</b>: to manage inventory including adding and editing inventory, and returning inventory to donor.';
	    echo '  </span>';
		echo '</div>';
	}
	if ($role === "Staff" || $role === "Volunteer") {
	    echo '<div class="col-md-24">';
	    echo '  <span>';
	    echo '    <b>Delivery</b>: to manage delivery products to family including setup packing per family, adding product in the packing, and setting delivery.';
	    echo '  </span>';
		echo '</div>';
	}
	if ($role === "Volunteer") {
	    echo '<div class="col-md-24">';
	    echo '  <span>';
	    echo '    <b>Schedule</b>: to record volunteer schedule including adding, editing, and deleting schedules.';
	    echo '  </span>';
		echo '</div>';
	}
	if ($role === "Volunteer") {
	    echo '<div class="col-md-24">';
	    echo '  <span>';
	    echo '    <b>Attendance</b>: to record volunteer attendance including adding, editing, and deleting attendance records.';
	    echo '  </span>';
		echo '</div>';
	}
	if ($role === "Staff") {
	    echo '<div class="col-md-24">';
	    echo '  <span>';
	    echo '    <b>Report Setting</b>: to prepare reports produced by the system including processing summary data for reports, creating prediction models, and estimating the inventory needs for each product.';
	    echo '  </span>';
		echo '</div>';
	}
	if ($role === "Staff") {
	    echo '<div class="col-md-24">';
	    echo '  <span>';
	    echo '    <b>Report</b>: to produce reports needed including inventory reports by donors, and products, delivery reports by family, working hour reports for volunteers.';
	    echo '  </span>';
		echo '</div>';
	}
	if ($role === "Volunteer" || $role === "Donor") {
	    echo '<div class="col-md-24">';
	    echo '  <span>';
	    echo '    <b>Certificate</b>: to produce certificate for user.';
	    echo '  </span>';
		echo '</div>';
	}
?>											  
				 
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
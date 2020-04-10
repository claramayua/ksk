<?php
	//Setting up session 
	session_start();
	include_once('paginator.class.php');
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
    $loginuserID = $_SESSION["loginUserID"];
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
		$SELECT = "SELECT role From user Where userid = '".$loginuserID."' Limit 1";
		$stmt = $conn->query($SELECT);
		if ($stmt->num_rows > 0) {
			while($row = $stmt->fetch_assoc()) {
				$role = $row["role"];
				if ($role !== "Staff") {
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
  // Checking and setting session for the button clicked
  
  $chosen = "";
  if (isset($_REQUEST['edit'])) {
	$aKey = array_keys($_REQUEST['edit']);
	$chosen = array_pop($aKey); 
    $_SESSION["chosen_user"] = $chosen;
	header('Location: http://localhost/ksk/edituser.php');
  }
?>

<?php
  //Setting up the value shown in list of residences with appeal capability
  
  $fullname_array = array();
  $phone_array = array();
  $email_array = array();
  $role_array = array();
  $driverlicense_array = array();
  $activeflag_array = array();
  
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
	$SELECT = "SELECT * From user";
	//prepare statement
	$stmt = $conn->query($SELECT);
	if ($stmt->num_rows > 0)
		while ($row = $stmt->fetch_assoc()) {
		  array_push($fullname_array, $row["fullname"]);
		  array_push($phone_array, $row["phone"]);
		  array_push($email_array, $row["email"]);
		  array_push($role_array, $row["role"]);
		  if (!empty($row["driverlicense"]))
			array_push($driverlicense_array, $row["driverlicense"]);
		  else
			array_push($driverlicense_array, "");
		  array_push($activeflag_array, $row["activeflag"]);
		}
	$stmt->close();
  }
  $conn->close();
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
            <h1 class="mb-2 bread">Manage User</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Staff Home<i class="ion-ios-arrow-forward"></i></a></span> <span>Manage User<i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>
	
		<section class="ftco-section ftco-no-pt ftco-no-pb">
			<div class="container-fluid px-0">
				<div class="row d-flex no-gutters">
<?php
	$recordno = '';
	$condition = '';
	$role = '';
	$activeflag = '';
	$firstflag = '0';
	$limit = '';
	
	if(isset($_REQUEST['fullname']) and $_REQUEST['fullname']!=""){
		if ($firstflag === '0') {
			$condition	.= ' WHERE fullname LIKE "%'.$_REQUEST['fullname'].'%" ';
			$firstflag = '1';
		}
	}
	if(isset($_REQUEST['email']) and $_REQUEST['email']!=""){
		if ($firstflag === '0') {
			$condition .= ' WHERE email LIKE "%'.$_REQUEST['email'].'%" ';
			$firstflag = '1';
		}
		else {
			$condition .= ' AND email LIKE "%'.$_REQUEST['email'].'%" ';
		}
	}
	if(isset($_REQUEST['phone']) and $_REQUEST['phone']!=""){
		if ($firstflag === '0') {
			$condition .= ' WHERE phone LIKE "%'.$_REQUEST['phone'].'%" ';
			$firstflag = '1';
		}
		else {
			$condition .= ' AND phone LIKE "%'.$_REQUEST['phone'].'%" ';
		}
	}
	if(isset($_REQUEST['role']) and $_REQUEST['role']!=""){
		$role = $_REQUEST['role'];
		if ($firstflag === '0') {
			$condition .= ' WHERE role = "'.$_REQUEST['role'].'" ';
			$firstflag = '1';
		}
		else {
			$condition .= ' AND role = "'.$_REQUEST['role'].'" ';
		}
	}
	if(isset($_REQUEST['activeflag']) and $_REQUEST['activeflag']!=""){
		$activeflag = $_REQUEST['activeflag'];
		if ($firstflag === '0') {
			$condition	.= ' WHERE activeflag = "'.$_REQUEST['activeflag'].'" ';
			$firstflag = '1';
		}
		else {
			$condition	.= ' AND activeflag = "'.$_REQUEST['activeflag'].'" ';
		}
	}
	
	$userid_array = array();
	$fullname_array = array();
	$phone_array = array();
	$email_array = array();
	$role_array = array();
	$driverlicense_array = array();
	$activeflag_array = array();
  
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

		$SELECT = 'SELECT * FROM user '."$condition".' ORDER BY userid ASC';
		//prepare statement
		$stmt = $conn->query($SELECT);
		$recordno = $stmt->num_rows;
		
		$pagingcode = '';
		$pages = new Paginator($recordno,9);
		$pagingcode .= '<div>';
		$pagingcode .= '<div class="col-sm-12">';
		$pagingcode .= '<div class="row">';
		$pagingcode .= '<div class="col-sm-8">';
		$pagingcode .= '<nav aria-label="Page navigation">';
		$pagingcode .= '<ul class="pagination">';
		$pagingcode .= $pages->display_pages();
		$pagingcode .= '</ul>';
		$pagingcode .= '</nav>';
		$pagingcode .= '</div>';
		$pagingcode .= '<div class="col-sm-3.5 text-right">';
		$pagingcode .= '<span class="form-inline">';
		$pagingcode .= $pages->display_jump_menu() . $pages->display_items_per_page();
		$pagingcode .= '</span>';
		$pagingcode .= '</div>';
		$pagingcode .= '<div class="clearfix"></div>';
		$limit = $pages->limit_start.', '.$pages->limit_end;		
		$pagingcode .= '</div>';
		$pagingcode .= '</div>';
		$pagingcode .= '</div>';
		
		$SELECT = 'SELECT * FROM user '."$condition".' ORDER BY userid ASC LIMIT '."$limit".'';
		//prepare statement
		$stmt = $conn->query($SELECT);
		$recordno = $stmt->num_rows;
		if ($recordno > 0)
			while ($row = $stmt->fetch_assoc()) {
				array_push($userid_array, $row["userid"]);
				array_push($fullname_array, $row["fullname"]);
				array_push($phone_array, $row["phone"]);
				array_push($email_array, $row["email"]);
				array_push($role_array, $row["role"]);
				if (!empty($row["driverlicense"]))
					array_push($driverlicense_array, $row["driverlicense"]);
				else
					array_push($driverlicense_array, "");
				array_push($activeflag_array, $row["activeflag"]);
			}
		$stmt->close();
	}
	$conn->close();
?>

   	<div class="container">
		<div class="card">
			<div class="card-header"><i class="fa fa-fw fa-globe"></i> <strong>Browse User</strong> </div>
			<div class="card-body">
				<?php
				if(isset($_REQUEST['msg']) and $_REQUEST['msg']=="rds"){
					echo	'<div class="alert alert-success"><i class="fa fa-thumbs-up"></i> Record deleted successfully!</div>';
				}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="rus"){
					echo	'<div class="alert alert-success"><i class="fa fa-thumbs-up"></i> Record updated successfully!</div>';
				}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="rnu"){
					echo	'<div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> You did not change any thing!</div>';
				}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="rna"){
					echo	'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> There is some thing wrong <strong>Please try again!</strong></div>';
				}
				?>
				<div class="col-sm-12">
					<h5 class="card-title"><i class="fa fa-fw fa-search"></i>Find User</h5>
					<form method="get">
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label>Full Name</label>
									<input type="text" name="fullname" id="fullname" class="form-control" value="<?php echo isset($_REQUEST['fullname'])?$_REQUEST['fullname']:''?>">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Email</label>
									<input type="text" name="email" id="email" class="form-control" value="<?php echo isset($_REQUEST['email'])?$_REQUEST['email']:''?>">
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<label>User Phone</label>
									<input type="tel" name="phone" id="phone" class="form-control" value="<?php echo isset($_REQUEST['phone'])?$_REQUEST['phone']:''?>">
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
								  <label for="">Role</label>
								  <div class="select-wrap one-third">									
									  <select name="role" id="role" class="form-control">
										<option value=""></option>
										<option <?php echo $role === "Donor" ? "selected" : "" ?> value="Donor">Donor</option>
										<option <?php echo $role === "Volunteer" ? "selected" : "" ?> value="Volunteer">Volunteer</option>
									  </select>
									</div>
								  </div>
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="">Status</label>
								  <div class="select-wrap one-third">
									  <select name="activeflag" id="activeflag" class="form-control">
										<option value=""></option>
										<option <?php echo $activeflag === "1" ? "selected" : "" ?> value="1">Active</option>
										<option <?php echo $activeflag === "0" ? "selected" : "" ?> value="0">Not Active</option>
									  </select>
									</div>
								  </div>
								</div>							
							<div class="col-sm-4">
								<div class="form-group">
									<label>&nbsp;</label>
									<div>
										<button type="submit" name="submit" value="search" id="submit" class="btn btn-primary"><i class="fa fa-fw fa-search"></i>Search</button>
										<a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-danger"><i class="fa fa-fw fa-sync"></i>Clear&nbsp;&nbsp;&nbsp;&nbsp;</a>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<hr>

<?php
	echo $pagingcode;
?>

		<hr>
		<div>
			<table class="table table-striped table-bordered">
				<thead>
					<tr class="bg-primary text-white">
						<th class="text-center">No</th>
						<th class="text-center">Full Name</th>
						<th class="text-center">Email</th>
						<th class="text-center">Phone</th>
						<th class="text-center">Role</th>
						<th class="text-center">Driver License</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
<?php
	if($recordno>0){
		for($i = 0; $i<$recordno; $i++) {
?>
					<tr>
						<td><?php echo $i + 1;?></td>
						<td><?php echo $fullname_array[$i];?></td>
						<td><?php echo $email_array[$i];?></td>
						<td><?php echo $phone_array[$i];?></td>
						<td><?php echo $role_array[$i];?></td>
						<td><?php echo $driverlicense_array[$i] === "" ? "" : $driverlicense_array[$i];?></td>
						<td><?php echo $activeflag_array[$i] === '1' ? "Active" : "Not Active";?></td>
						<td align="center">
							<a href="edituser.php?editId=<?php echo $userid_array[$i];?>" class="text-primary"><i class="fa fa-fw fa-edit"></i> Edit</a>
						</td>

					</tr>
					
<?php 
		}
	}
	else{
?>
					<tr><td colspan="8" align="center">No Record(s) Found!</td></tr>
<?php 
	} 
?>
				</tbody>
			</table>
		</div> <!--/.col-sm-12-->
		
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
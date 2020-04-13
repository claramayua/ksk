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
  //Check login session whether it is a valid user or not
  //this to make sure page is accessed manually using its url
  $loginfullname = "";
  $loginrole = "";
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
				$loginrole = $row["role"];
				if ($loginrole !== "Staff" && $loginrole != "Volunteer") {
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
	
	//Setting up the value shown in list of users with edit capability
	//Searching capability and pagination capability
	$recordno = '';
	$condition = '';
	$distance = '';
	$distanceSelect = '';
	$activeflag = '';
	$firstflag = '0';
	$limit = '0,0';
	
	//Setting up query statement based on searching keywords
	if(isset($_REQUEST['fullname']) and $_REQUEST['fullname']!=""){
		if ($firstflag === '0') {
			$condition	.= ' WHERE fullname LIKE "%'.$_REQUEST['fullname'].'%" ';
			$firstflag = '1';
		}
	}
	if(isset($_REQUEST['address']) and $_REQUEST['address']!=""){
		if ($firstflag === '0') {
			$condition .= ' WHERE address LIKE "%'.$_REQUEST['address'].'%" ';
			$firstflag = '1';
		}
		else {
			$condition .= ' AND address LIKE "%'.$_REQUEST['address'].'%" ';
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
	if(isset($_REQUEST['latitude']) and $_REQUEST['latitude']!="" && isset($_REQUEST['longitude']) and $_REQUEST['longitude']!="" && isset($_REQUEST['distance']) and $_REQUEST['distance']!=""){
		$distance = '(
						( 
							3959 * acos(
								cos	(
									radians	(
										'.$_REQUEST['latitude'].'
									)
								)
								* cos (
									radians (
										latitude
									)
								) 
								* cos (
									radians (
										longitude
									) 
									- radians(
										'.$_REQUEST['longitude'].'
									)
								) 
								+ sin(
									radians(
										'.$_REQUEST['latitude'].'
									)
								) 
								* sin(
									radians(
										latitude
									)
								)
							)
						) 
						* 1.60934
					)';
		$distanceSelect = $distance.' AS distance,';
	    if ($firstflag === '0') {
			$condition .= ' WHERE '.$distance.' < '.$_REQUEST['distance'].' ';
			$firstflag = '1';
		}
		else {
			$condition .= ' AND '.$distance.' < '.$_REQUEST['distance'].' ';
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
	
	//Setting up values to be shown in the data list
	$familyid_array = array();
	$fullname_array = array();
	$address_array = array();
	$phone_array = array();
	$distance_array = array();
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
		$SELECT = 'SELECT familyid, fullname, address, phone, latitude, longitude, '.$distanceSelect.' activeflag FROM family '.$condition.' ORDER BY familyid ASC';
		//prepare statement
		$stmt = $conn->query($SELECT);
		$recordno = $stmt->num_rows;
		
		if ($recordno > 0) {
			//Save html code in string to be used in provide pagination capability
			//This is done because the numbering, the page link in pagination is complicated
			//The Paginator object defined in the paginator class is implemented here
			$pagingcode = '';
			$pages = new Paginator($recordno,9);
			$pagingcode .= '<hr>';
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
			$pagingcode .= '<hr>';
		}
		
		$SELECT = 'SELECT familyid, fullname, address, phone, latitude, longitude, '.$distanceSelect.' activeflag FROM family '.$condition.' ORDER BY familyid ASC LIMIT '.$limit.'';
		
		//prepare statement
		$stmt = $conn->query($SELECT);
		$recordno = $stmt->num_rows;
		if ($recordno > 0)
			while ($row = $stmt->fetch_assoc()) {
				array_push($familyid_array, $row["familyid"]);
				array_push($fullname_array, $row["fullname"]);
				array_push($address_array, $row["address"]);
				array_push($phone_array, $row["phone"]);
				array_push($distance_array, $row["distance"]);
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
			<li class="nav-item active"><a href="showprofile.php" class="nav-link">Profile</a></li>
            <li class="nav-item active"><a href="setting.php" class="nav-link">Setting</a></li>
			<li class="nav-item active"><a href="changepassword.php" class="nav-link">Change Password</a></li>
			<li class="nav-item active"><a href="logout.php" class="nav-link">Logout</a></li>
	        <?php
	          echo '<li class="nav-item cta"><a href="menu' . strtolower($loginrole) . '.php" class="nav-link">' . $loginrole . ' Menu</a></li>'
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
            <h1 class="mb-2 bread">Manage Family</h1>
            <p class="breadcrumbs">
			  <span class="mr-2"><a href="menu<?php echo strtolower($loginrole); ?>.php"><?php echo $loginrole; ?> Menu<i class="ion-ios-arrow-forward"></i></a></span> 
			  <span>Manage Family<i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>
	
		<section class="ftco-section ftco-no-pt ftco-no-pb">
			<div class="container-fluid px-0">
				<div class="row d-flex no-gutters">

   	<div class="container">
		<div class="card">
			<div class="card-header"><i class="fa fa-fw fa-globe"></i> <strong>Browse Family</strong> <a href="addfamily.php" class="float-right btn btn-dark btn-sm"><i class="fa fa-fw fa-plus-circle"></i>Add Family</a></div>
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
					<h5 class="card-title"><i class="fa fa-fw fa-search"></i>Find Family</h5>
					<form method="get">
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label>Full Name</label>
									<input type="text" name="fullname" id="fullname" class="form-control" value="<?php echo isset($_REQUEST['fullname'])?$_REQUEST['fullname']:''?>">
								</div>
							</div>
							<div class="col-sm-5">
								<div class="form-group">
									<label>Address</label>
									<input type="text" name="address" id="address" class="form-control" value="<?php echo isset($_REQUEST['address'])?$_REQUEST['address']:''?>">
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<label>Phone</label>
									<input type="text" pattern="[0-9]+" name="phone" id="phone" class="form-control" value="<?php echo isset($_REQUEST['phone'])?$_REQUEST['phone']:''?>">
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
							<div class="col-sm-2">
								<div class="form-group">
								  <label for="">Distance (in km)</label>
								  <input type="text" pattern="^[0-9\.]*$" name="distance" id="distance" class="form-control" value="<?php echo isset($_REQUEST['distance'])?$_REQUEST['distance']:''?>">
								  </div>
								</div>
							<div class="col-sm-2">
								<div class="form-group">
									<label>From Latitude</label>
									<input type="text" pattern="^[0-9\.\-]*$" name="latitude" id="latitude" class="form-control" value="<?php echo isset($_REQUEST['latitude'])?$_REQUEST['latitude']:''?>">
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<label>Longitude</label>
									<input type="text" pattern="^[0-9\.\-]*$" name="longitude" id="longitude" class="form-control" value="<?php echo isset($_REQUEST['longitude'])?$_REQUEST['longitude']:''?>">
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

<?php
	//Including the pagination code here
	if ($recordno > 0)
		echo $pagingcode;
?>

		<div>
			<table class="table table-striped table-bordered">
				<thead>
					<tr class="bg-primary text-white">
						<th class="text-center">No</th>
						<th class="text-center">Full Name</th>
						<th class="text-center">Address</th>
						<th class="text-center">Phone</th>
						<th class="text-center">Distance</th>
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
						<td><?php echo $address_array[$i];?></td>
						<td><?php echo $phone_array[$i];?></td>
						<td><?php echo $distance_array[$i];?></td>
						<td><?php echo $activeflag_array[$i] === '1' ? "Active" : "Not Active";?></td>
						<td align="center">
							<a href="editfamily.php?editId=<?php echo $familyid_array[$i];?>" class="text-primary"><i class="fa fa-fw fa-edit"></i> Edit</a>
<?php
			//Delete button is for user 'Admin' only
			if ($loginrole == "Admin")
							echo '<a href="delete.php?delId='.$userid_array[$i].'" class="text-danger" onClick="return confirm(\'Are you sure to delete this user?\');"><i class="fa fa-fw fa-trash"></i> Delete</a>';
?>
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
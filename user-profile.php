<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['detsuid'] == 0)) {
	header('location:logout.php');
} else {
	$userid = $_SESSION['detsuid'];
	$fullname = $_POST['fullname'];
	$position = $_POST['position'];
	$email = $_POST['email'];
	$mobno = $_POST['contactnumber'];
	$noImage = 'https://placehold.it/150/30a5ff/fff';

	$getQuery = mysqli_query($con, "select * from tbluser where ID='$userid'");
	$row = mysqli_fetch_array($getQuery);

	if (isset($_POST['upload'])) {
		if (!isset($_FILES['image']['tmp_name'])) {
			$msg = "Please select an image.";
		} else {
			$file = $_FILES['image']['tmp_name'];
			$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
			$image_name = addslashes($_FILES['image']['name']);
			$image_size = getimagesize($_FILES['image']['tmp_name']);
			if ($image_size == false)
				$msg = "That's not an image.";
			else {
				move_uploaded_file($_FILES["image"]["tmp_name"], "assets/images/users/" . $_FILES["image"]["name"]);
				$location = "assets/images/users/" . $_FILES["image"]["name"];
				$query = mysqli_query($con, "update tbluser set Image ='$location' where ID='$userid'");
				$msg = "Image Uploaded.";
			}
		}
	}

	if (isset($_POST['submit'])) {
		$query = mysqli_query($con, "update tbluser set FullName ='$fullname',Position ='$position',Email ='$email', MobileNumber='$mobno' where ID='$userid'");
		if ($query) {
			$msg = "User profile has been updated.";
		} else {
			$msg = "Something Went Wrong. Please try again.";
		}
	}

	// change pas
	if (isset($_POST['changepass'])) {
		$userid = $_SESSION['detsuid'];
		$cpassword = md5($_POST['currentpassword']);
		$newpassword = md5($_POST['newpassword']);
		$query = mysqli_query($con, "select ID from tbluser where ID='$userid' and   Password='$cpassword'");
		$row = mysqli_fetch_array($query);
		if ($row > 0) {
			$ret = mysqli_query($con, "update tbluser set Password='$newpassword' where ID='$userid'");
			$msg = "Your password successully changed";
		} else {
			$msg = "Your current password is wrong";
		}
	}

?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Expense Mangement System</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/font-awesome.min.css" rel="stylesheet">
		<link href="css/datepicker3.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">

		<!--Custom Font-->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
		<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	</head>

	<body>
		<?php include_once('includes/header.php'); ?>
		<?php include_once('includes/sidebar.php'); ?>
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<div class="row">
				<ol class="breadcrumb">
					<li><a href="#">
							<em class="fa fa-home"></em>
						</a></li>
					<li class="active">My Profile</li>
				</ol>
			</div>
			<!--/.row-->

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading"> <em class="fa fa-cogs">&nbsp; My Profile</em></div>
						<div class="panel-body">
							<p style="font-size:16px; color:red" align="center"> <?php if ($msg) {
																						echo $msg;
																					}  ?> </p>
							<div class="col-md-3">
								<div class="form-group">
									<label>Upload Image</label>								
									<img src="<?php if ($row['Image']) {
												echo $row['Image'];
                      							} else { echo $noImage; } ?>" class="img-responsive" alt="image" class="responsive">									
									<form method="post" enctype="multipart/form-data">
										<input type="hidden" value="1000000" name="MAX_FILE_SIZE" />
										<input type="file" name="image" value="<?php echo $row['Image']; ?>" class="form-control responsive">
										<button type="submit" name="upload" class="btn btn-primary responsive" ><em class="fa fa-upload"> Upload Image</em></button>																			
									</form>
								</div>
							</div>
							<div class="col-md-9">
								<form role="form" method="post" action="">
									<div class="form-group">
										<label>Full Name</label>
										<input class="form-control" type="text" value="<?php echo $row['FullName']; ?>" name="fullname" required="true">
									</div>
									<div class="form-group">
										<label>Position</label>
										<input class="form-control" type="text" value="<?php echo $row['Position']; ?>" name="position" required="true">
									</div>
									<div class="form-group">
										<label>Email</label>
										<input type="email" class="form-control" name="email" value="<?php echo $row['Email']; ?>" required="true">
									</div>
									<div class="form-group">
										<label>Mobile Number</label>
										<input class="form-control" type="text" value="<?php echo $row['MobileNumber']; ?>" required="true" name="contactnumber" maxlength="10">
									</div>
									<div class="form-group">
										<label>Registration Date</label>
										<input class="form-control" name="regdate" type="text" value="<?php echo $row['RegDate']; ?>" readonly="true">
									</div>
									<div class="form-group has-success">
										<button type="submit" class="btn btn-primary" style="width: 150px" name="submit">Save</button>
									</div>
								</form>
							</div>

						</div>
						<div class="panel-footer ">
							<div class="row " align="right">
								<div class="col-md-12">									
									<a data-toggle="modal" data-target="#changePassword" class="btn btn-primary"><em class="fa fa-key">&nbsp;</em>Change Password</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include_once('includes/footer.php'); ?>
		</div>
		</div>
		<!--/.main-->

		<div id="changePassword" class="modal fade" role="dialog">
			<form role="form" method="post" action="" name="changepassword" onsubmit="return checkpass();">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Change Password</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label>Current Password</label>
								<input type="password" name="currentpassword" class=" form-control" required="true" value="">
							</div>
							<div class="form-group">
								<label>New Password</label>
								<input type="password" name="newpassword" class="form-control" value="" required="true">
							</div>
							<div class="form-group">
								<label>Confirm Password</label>
								<input type="password" name="confirmpassword" class="form-control" value="" required="true">
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" name="changepass">Change</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					</div>
				</div>
			</form>
		</div>
		</div>

		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/chart.min.js"></script>
		<script src="js/chart-data.js"></script>
		<script src="js/easypiechart.js"></script>
		<script src="js/easypiechart-data.js"></script>
		<script src="js/bootstrap-datepicker.js"></script>
		<script src="js/custom.js"></script>
		<script type="text/javascript">
			function checkpass() {
				if (document.changepassword.newpassword.value != document.changepassword.confirmpassword.value) {
					alert('New Password and Confirm Password field does not match');
					document.changepassword.confirmpassword.focus();
					return false;
				}
				return true;
			}
		</script>
	</body>

	</html>
<?php }  ?>
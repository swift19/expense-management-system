<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
	$contactno = $_POST['contactno'];
	$email = $_POST['email'];

	$query = mysqli_query($con, "select ID from tbluser where  Email='$email' and MobileNumber='$contactno' ");
	$ret = mysqli_fetch_array($query);
	if ($ret > 0) {
		$_SESSION['contactno'] = $contactno;
		$_SESSION['email'] = $email;
		header('location:reset-password.php');
	} else {
		$msg = "Invalid Details. Please try again.";
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
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">

</head>

<body>
	<div class="row">
		<h2 align="center">Expense Mangement System</h2>
		<hr />
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h4 align="center">Forgot your password?</h4>
				</div>

				<div class="panel-body">
					<div align='center'>
						<p>Don't worry! Resetting your password is easy. </br>
							Just type in the email and mobile number you registered.</p>
					</div>
					
					<form role="form" action="" method="post" id="" name="login">
						<fieldset>
							<div class="form-group">

								<input class="form-control" placeholder="E-mail" name="email" type="email" autofocus="" required="true">
							</div>

							<div class="form-group">
								<input class="form-control" placeholder="Mobile Number" name="contactno" type="contactno" value="" required="true">
							</div>
							<div class="form-group">
								<button type="submit" value="" name="submit" class="btn btn-primary" style="width:100%">Submit</button>
							</div>
						</fieldset>
						<p style="font-size:16px; color:red" align="center"> <?php if ($msg) {
																				echo $msg;
																			}  ?> </p>
						<hr />
						<div align='center'>
							<label>Did you remembered you password? <a href="index.php">Try logging in</a></label>
						</div>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->


	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['login']))
  {
    $email=$_POST['email'];
    $password=md5($_POST['password']);
    $query=mysqli_query($con,"select ID from tbluser where  Email='$email' && Password='$password' ");
    $ret=mysqli_fetch_array($query);
    if($ret>0){
      $_SESSION['detsuid']=$ret['ID'];
     header('location:dashboard.php');
    }
    else{
    $msg="Invalid Details.";
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
				<div class="panel-heading">Login</div>
				<div class="panel-body">
					<p style="font-size:16px; color:red" align="center"> <?php if($msg){ echo $msg; }  ?> </p>
					<form role="form" action="" method="post" id="" name="login">
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="E-mail" name="email" type="email" autofocus="" required="true">
							</div>							
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="password" type="password" value="" required="true">
								<a href="forgot-password.php">Having trouble signing in?</a>
							</div>
							<div class="form-group">
								<button type="submit" value="login" name="login" class="btn btn-primary"  style="width:100%">Login</button>		
							</div>
						</fieldset>
						<hr/>
						<div align='center'>
						   <label>Don't have an Account yet? <a href="register.php" >   Create an account</a></label>
						</div>							
					</form>
				</div>
				<div></div>
			</div>
		</div>
	</div>	
	

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
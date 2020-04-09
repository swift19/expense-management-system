<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['detsuid'] == 0)) {
	header('location:logout.php');
} else {
	$userid = $_SESSION['detsuid'];
	$dateexpense = $_POST['dateexpense'];
	$expensecategory = $_POST['expensecategory'];
	$costitem = $_POST['costitem'];
	$deleteRowId = $_POST['delCatId'];
	$editRowId = $_POST['editCatId'];

	$getCategoryQuery = mysqli_query($con, "select * from tblexpensecategory where UserId='$userid'");

	$rowCount = mysqli_fetch_array(mysqli_query($con, "select COUNT(*) as count from tblexpense where UserId='$userid'"));

	if (isset($_POST['submit'])) {
		$addQuery = mysqli_query($con, "insert into tblexpense(UserId,ExpenseDate,ExpenseCategory,ExpenseCost) value('$userid','$dateexpense','$expensecategory','$costitem')");
		if ($addQuery) {
			echo "<script>alert('Expense has been added');</script>";
			echo "<script>window.location.href='add-expense.php'</script>";
		} else {
			echo "<script>alert('Something went wrong. Please try again');</script>";
		}
	}

	if (isset($_POST['delete'])) {
		$deleteQuery = mysqli_query($con, "delete from tblexpense where ID='$deleteRowId'");
		if ($deleteQuery) {
			echo "<script>alert('Record successfully deleted');</script>";
			echo "<script>window.location.href='add-expense.php'</script>";
		} else {
			echo "<script>alert('Something went wrong. Please try again');</script>";
		}
	}

	if (isset($_POST['edit'])) {
		$editQuery = mysqli_query($con, "update tblexpense set UserId='$userid',ExpenseDate='$dateexpense',ExpenseCategory='$expensecategory',ExpenseCost='$costitem' where ID='$editRowId'");
		if ($editQuery) {
			echo "<script>alert('Record successfully Updated');</script>";
			echo "<script>window.location.href='add-expense.php'</script>";
		} else {
			echo "<script>alert('Something went wrong. Please try again');</script>";
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
					<li class="active">Expense</li>
				</ol>
			</div>
			<!--/.row-->

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">Expense</div>
						<div class="panel-body">
							<div class="col-md-10">
								<div class="form-group has-success">
									<a data-toggle="modal" data-target="#addExpense" class="btn btn-primary"><em class="fa fa-plus">&nbsp;</em> Add Expense</a>
								</div>
							</div>

							<div class="col-md-2">
								<label class="btn btn-default" data-ng-disabled="true">
									<small id="lblTotalCategories">Total No. of  Expense</small>
									<div><?php echo $rowCount['count']; ?></div>
								</label>
							</div>
							<div class="col-md-12">
								<div class="table-responsive-sm">
									<table class="table table-hover">
										<thead>
											<tr>
												<th style="width: 10%">No.</th>
												<th style="width: 20%">Expense Date (YYYY/mm/dd)</th>
												<th style="width: 35%">Expense Category</th>
												<th style="width: 20%">Expense Cost</th>
												<th></th>
												<th style="width: 15%">Action</th>
											</tr>
										</thead>
										<?php
										$ret = mysqli_query($con, "select * from tblexpense where UserId='$userid'");
										$cnt = 1;
										while ($row = mysqli_fetch_array($ret)) {
										?>
											<tbody>
												<tr>
													<td><?php echo $cnt; ?></td>
													<td><?php echo $row['ExpenseDate']; ?> </td>
													<td><?php echo $row['ExpenseCategory']; ?> </td>
													<td><?php echo $row['ExpenseCost']; ?> </td>
													<td><span hidden='true'><?php echo  $row['ID']; ?></span></td>
													<td>
														<button data-toggle="modal" class="btn btn-info editbtn">&nbsp; Edit &nbsp;</button>
														<button data-toggle="modal" class="btn btn-danger deletebtn"> Delete </button>
													</td>
												</tr>
											<?php $cnt = $cnt + 1;
										} ?>
											</tbody>
									</table>
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

		<!-- ADD -->
		<div id="addExpense" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<form role="form" method="post" action="">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Add Expense</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label>Date of Expense</label>
								<input class="form-control" type="date" value="" name="dateexpense" required="true">
							</div>
							<div class="form-group">
								<label>Category</label>
								<select class="form-control" name="expensecategory">
									<?php while ($row = mysqli_fetch_array($getCategoryQuery)) :; ?>
										<option><?php echo $row[2]; ?> </option>
									<?php endwhile; ?>
								</select>
							</div>
							<div class="form-group">
								<label>Cost of Expense</label>
								<input class="form-control" type="text" value="" required="true" name="costitem">
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" name="submit">Save</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<!-- EDIT -->
		<div id="editExpense" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<form role="form" method="post" action="">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Edit Expense</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
							<input type="hidden" class="form-control" id='editCatId' name="editCatId">
								<label>Date of Expense</label>								
								<input class="form-control" type="text" id="dateexpense" name="dateexpense" required="true">
							</div>
							<div class="form-group">
								<label>Category</label>								
								<input class="form-control" type="text" id="expensecategory" name="expensecategory" required="true">
							</div>
							<div class="form-group">
								<label>Cost of Expense</label>
								<input class="form-control" type="text" id="costitem" name="costitem" required="true" >
							</div>
						</div>
						<div class="modal-footer">
							<button type="edit" class="btn btn-primary" name="edit">Save</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<!-- DELETE -->
		<div id="deleteExpense" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<form role="form" method="post" action="">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Delete
							</h4>
						</div>
						<div class="modal-body">
							<p>Are you sure you want to delete this expense?</p>
							<input type="hidden" class="form-control" id='delCatId' name="delCatId">
						</div>
						<div class="modal-footer">
							<button type="delete" class="btn btn-primary" name="delete">Yes</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
						</div>
					</form>
				</div>
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
		<script>
		$(document).ready(function() {

			$('.deletebtn').on('click', function() {
				$('#deleteExpense').modal('show');
				$tr = $(this).closest('tr');
				var data = $tr.children("td").map(function() {
					return $(this).text();
				}).get();
				console.log(data);
				$('#delCatId').val(data[4]);
			});

			$('.editbtn').on('click', function() {
				$('#editExpense').modal('show');
				$tr = $(this).closest('tr');
				var data = $tr.children("td").map(function() {
					return $(this).text();
				}).get();
				console.log(data);				
				$('#dateexpense').val(data[1]);
			    $('#expensecategory').val(data[2]);
				$('#costitem').val(data[3]);
				$('#editCatId').val(data[4]);
			});
		});
	</script>
	</body>

	</html>
<?php }  ?>
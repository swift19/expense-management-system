<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['detsuid'] == 0)) {
	header('location:logout.php');
} else {
	$userid = $_SESSION['detsuid'];
	// $getExpenseQuery = mysqli_query($con, "select ExpenseCategory,ExpenseCost from tblexpense where UserId='$userid'");
	// while ($row = mysqli_fetch_array($getExpenseQuery)) {		
	// 	$chart_data .= "{ label: '" . $row["ExpenseCategory"] . "', data: " . $row["ExpenseCost"] . "},";
	// }
	// $chart_data = substr($chart_data, 0, -1);

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

		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
			google.charts.load('current', {
				'packages': ['corechart']
			});
			google.charts.setOnLoadCallback(drawChart);

			function drawChart() {
				var data = google.visualization.arrayToDataTable([
					['ExpenseCategory', 'ExpenseCost'],
					<?php
					$getExpenseQuery = mysqli_query($con, "select ExpenseCategory,ExpenseCost from tblexpense where UserId='$userid' GROUP BY ExpenseCategory");
					while ($row = mysqli_fetch_array($getExpenseQuery)) {
						echo " ['" . $row['ExpenseCategory'] . "', " . $row['ExpenseCost'] . "], ";
					}
					?>
				]);
				var options = {
					pieHole: 0.4
				};
				var chart = new google.visualization.PieChart(document.getElementById('piechart'));
				chart.draw(data, options);
			}
		</script>

		<script type="text/javascript">
			google.charts.load('current', {
				'packages': ['line']
			});
			google.charts.setOnLoadCallback(drawBar);

			function drawBar() {		
				var data = new google.visualization.DataTable();
				data.addColumn('string', 'ExpenseDate');
				data.addColumn('number', 'Cost');

				data.addRows([
					<?php
					$query = mysqli_query($con, "select ExpenseDate ,ExpenseCost from tblexpense where UserId='$userid' ORDER BY ExpenseDate ASC");					
					while ($row = mysqli_fetch_array($query)) {
						echo " [ '" . $row['ExpenseDate'] . "', " . $row['ExpenseCost'] . " ], ";
					}
					?>
				]);
				var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
				chart.draw(data);				
			}
		</script>
	</head>

	<body>

		<?php include_once('includes/header.php'); ?>
		<?php include_once('includes/sidebar.php'); ?>

		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<div class="row">
				<ol class="breadcrumb">
					<li>
						<a href="#">
							<em class="fa fa-home"></em>
						</a>
					</li>
					<li class="active">Dashboard</li>
				</ol>
			</div>
			<!--/.row-->

			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Dashboard
				</div>
			</div>
			<!--/.row-->




			<div class="row">
				<div class="col-xs-6 col-md-3">

					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<?php
							//Today Expense
							$userid = $_SESSION['detsuid'];
							$tdate = date('Y-m-d');
							$query = mysqli_query($con, "select sum(ExpenseCost)  as todaysexpense from tblexpense where (ExpenseDate)='$tdate' && (UserId='$userid');");
							$result = mysqli_fetch_array($query);
							$sum_today_expense = $result['todaysexpense'];
							?>

							<h4>Today's Expense</h4>
							<div class="easypiechart" id="easypiechart-blue" data-percent="<?php echo $sum_today_expense; ?>"><span class="percent"><?php if ($sum_today_expense == "") {
																																						echo "0";
																																					} else {
																																						echo $sum_today_expense;
																																					}

																																					?></span></div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3">
					<div class="panel panel-default">
						<?php
						$query4 = mysqli_query($con, "select sum(Income)  as totalincome from tblincome where (UserId='$userid');");
						$result4 = mysqli_fetch_array($query4);
						$sum_total_income = $result4['totalincome'];
						?>
						<div class="panel-body easypiechart-panel">
							<h4>Total Income</h4>
							<div class="easypiechart" id="easypiechart-orange" data-percent="<?php echo $sum_total_income; ?>"><span class="percent"><?php if ($sum_total_income == "") {
																																							echo "0";
																																						} else {
																																							echo $sum_total_income;
																																						}

																																						?></span></div>
						</div>

					</div>

				</div>

				<div class="col-xs-6 col-md-3">
					<div class="panel panel-default">
						<?php
						$query5 = mysqli_query($con, "select sum(ExpenseCost)  as totalexpense from tblexpense where UserId='$userid';");
						$result5 = mysqli_fetch_array($query5);
						$sum_total_expense = $result5['totalexpense'];
						?>
						<div class="panel-body easypiechart-panel">
							<h4>Total Expense</h4>
							<div class="easypiechart" id="easypiechart-teal" data-percent="<?php echo $sum_total_expense; ?>"><span class="percent"><?php if ($sum_total_expense == "") {
																																						echo "0";
																																					} else {
																																						echo $sum_total_expense;
																																					}

																																					?></span></div>
						</div>

					</div>

				</div>

				<div class="col-xs-6 col-md-3">
					<div class="panel panel-default">
						<?php
						$totExpese = mysqli_fetch_array(mysqli_query($con, "select sum(ExpenseCost) as totExpese from tblexpense where UserId='$userid';"));
						$totIncome = mysqli_fetch_array(mysqli_query($con, "select sum(Income) as totIncome from  tblincome where UserId='$userid';"));
						$sum_balance = $totIncome['totIncome'] - $totExpese['totExpese'];
						?>
						<div class="panel-body easypiechart-panel">
							<h4>Running Balance</h4>
							<div class="easypiechart" id="easypiechart-red" data-percent="<?php echo $sum_balance; ?>"><span class="percent"><?php if ($sum_balance == "") {
																																					echo "0";
																																				} else {
																																					echo $sum_balance;
																																				}

																																				?></span></div>
						</div>
					</div>
				</div>

			</div>
			<!--/.row-->
			<div class="row">
				<div class="col-xs-6">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h4>Expense Graph</h4>
							<div id="chart_div" class="linechart"></div>
						</div>
					</div>
				</div>


				<div class="col-xs-6">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h4>Expense Chart</h4>
							<div id="piechart" class="piechart"></div>
						</div>
					</div>

				</div>
			</div>

			<!--/.row-->
		</div>
		<!--/.main-->
		<!-- <?php include_once('includes/footer.php'); ?> -->
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/chart.min.js"></script>
		<script src="js/chart-data.js"></script>
		<script src="js/easypiechart.js"></script>
		<script src="js/easypiechart-data.js"></script>
		<script src="js/bootstrap-datepicker.js"></script>
		<script src="js/custom.js"></script>
		<!-- <script>
			window.onload = function() {
				var chart1 = document.getElementById("line-chart").getContext("2d");
				window.myLine = new Chart(chart1).Line(lineChartData, {
					responsive: true,
					scaleLineColor: "rgba(0,0,0,.2)",
					scaleGridLineColor: "rgba(0,0,0,.05)",
					scaleFontColor: "#c5c7cc"
				});
			};
		</script> -->





	</body>

	</html>
<?php } ?>
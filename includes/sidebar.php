<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar wrapper">
  <div class="profile-sidebar">
    <?php
    $userid = $_SESSION['detsuid'];
    $query = mysqli_query($con, "select * from tbluser where ID='$userid'");
    $row = mysqli_fetch_array($query);    
    $noImage = 'https://placehold.it/150/30a5ff/fff';
    ?>
    <div class="profile-userpic">
      <!-- <img src="http://placehold.it/50/30a5ff/fff" class="img-responsive" alt=""  width="50" height="50"> -->
      <img src="<?php if ($row['Image']) {
												echo $row['Image'];
                      } else { echo $noImage; } ?>" class="img-responsive" alt="image" class="responsive">
    </div>
    <div class="profile-usertitle">

      <div class="profile-usertitle-name"><?php echo $row['FullName']; ?></div>
      <div class="profile-usertitle-position"><?php echo $row['Position']; ?></div>
      <!-- <div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div> -->
    </div>
    <div class="clear"></div>
  </div>
  <div class="divider"></div>

  <ul class="nav menu" id="wrapper">
    <li class="active"><a href="dashboard.php"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>
    <li class="parent "><a data-toggle="collapse" href="#sub-item-1">
        <em class="fa fa-navicon">&nbsp;</em>Expenses <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-arrow-right"></em></span>
      </a>
      <ul class="children collapse" id="sub-item-1">
        <li><a class="" href="add-expense.php">
            <span class="fa fa-plus">&nbsp;</span> Add Expenses
          </a></li>
        <!-- <li><a class="" href="manage-expense.php">
            <span class="fa fa-arrow-right">&nbsp;</span> Manage Expenses
          </a></li> -->
        <li><a href="add-expense-category.php">
            <span class="fa fa-list-alt">&nbsp;</span> Expense Category
          </a></li>
      </ul>
    </li>
    <li class="parent "><a data-toggle="collapse" href="#sub-item-2">
        <em class="fa fa-navicon">&nbsp;</em>Expense Report <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-arrow-right"></em></span>
      </a>
      <ul class="children collapse" id="sub-item-2">
        <li><a class="" href="expense-datewise-reports.php">
            <span class="fa fa-arrow-right">&nbsp;</span> Daywise Expenses
          </a></li>
        <li><a class="" href="expense-monthwise-reports.php">
            <span class="fa fa-arrow-right">&nbsp;</span> Monthwise Expenses
          </a></li>
        <li><a class="" href="expense-yearwise-reports.php">
            <span class="fa fa-arrow-right">&nbsp;</span> Yearwise Expenses
          </a></li>
      </ul>
    </li>
    <li><a href="add-income.php"><em class="fa fa-usd">&nbsp;</em> Income</a></li>
    <li><a href="user-profile.php"><em class="fa fa-user">&nbsp;</em> My Profile</a></li>
    <!-- <li><a href="change-password.php"><em class="fa fa-clone">&nbsp;</em> Change Password</a></li> -->
    <li><a data-toggle="modal" data-target="#logOut"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
  </ul>
</div>

<div id="logOut" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Logout <?php echo $row['FullName']; ?>?</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to logout?</p>
      </div>
      <div class="modal-footer">
        <a href="logout.php" class="btn btn-primary">Yes</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
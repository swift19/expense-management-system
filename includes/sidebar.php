<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>


<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar wrapper">
    <div class="profile-sidebar">
        <div class="profile-userpic">
            <img src="http://placehold.it/50/30a5ff/fff" class="img-responsive" alt="">
        </div>
        <div class="profile-usertitle">
            <?php
            $uid = $_SESSION['detsuid'];
            $ret = mysqli_query($con, "select FullName from tbluser where ID='$uid'");
            $row = mysqli_fetch_array($ret);
            $name = $row['FullName'];

            ?>
            <div class="profile-usertitle-name"><?php echo $name; ?></div>
            <div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
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
                <li><a class="" href="manage-expense.php">
                        <span class="fa fa-arrow-right">&nbsp;</span> Manage Expenses
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




        <li><a href="user-profile.php"  class="list-group-item list-group-item-action bg-light"><em class="fa fa-list-alt">&nbsp;</em> Expense Category</a></li>
        <li><a href="user-profile.php"><em class="fa fa-user">&nbsp;</em> My Profile</a></li>
        <li><a href="change-password.php"><em class="fa fa-clone">&nbsp;</em> Change Password</a></li>        
        <li><a data-toggle="modal" data-target="#logOut"><em class="fa fa-power-off" >&nbsp;</em> Logout</a></li>        

    </ul>
</div>

<div id="logOut" class="modal fade" role="dialog">
  <div class="modal-dialog">    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Logout <?php echo $name; ?>?</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to logout?</p>
      </div>
      <div class="modal-footer">        
        <a href="logout.php" class="btn btn-primary">Yes</a>
        <button type = "button" class = "btn btn-default" data-dismiss="modal">No</button>                           
      </div>
    </div>
  </div>
</div>

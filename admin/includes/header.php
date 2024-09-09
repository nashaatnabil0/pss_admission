<?php
session_start();
// error_reporting(0);
include('includes/dbconnection.php');
?>
<header class="header dark-bg">
   <div class="toggle-nav">
     <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
   </div>
<?php
$adid=$_SESSION['sportadmission'];
$ret= $pdoConnection -> query("select * from users where ID='$adid'");
$row=$ret-> fetch(PDO:: FETCH_ASSOC);
$name=$row['name'];
?>
   <!--logo start-->
   <a href="dashboard.php" class="logo"><span class="lite"><strong> Peace Sports School Admission System | Admin</strong></span></a>
   <!--logo end-->

   <div class="top-nav notification-row">
     <!-- notificatoin dropdown start-->
     <ul class="nav pull-right top-menu">

       <!-- user login dropdown start-->
       <li class="dropdown">
         <a data-toggle="dropdown" class="dropdown-toggle" >
           <span class="profile-ava">
             <img alt="" src="images/av1.jpg" width="40" height="30">
           </span>
           <span class="username"><?php echo $name; ?></span>
           <b class="caret"></b>
         </a>
         <ul class="dropdown-menu extended logout">
           <div class="log-arrow-up"></div>
           <li class="eborder-top">
             <a href="admin-profile.php"><i class="icon_profile"></i> My Profile</a>
           </li>
           <li>
             <a href="change-password.php"><i class="icon_mail_alt"></i> Change Password</a>
           </li>
           <li>
             <a href="logout.php"><i class="icon_key_alt"></i> Log Out</a>
           </li>
         </ul>
       </li>
       <!-- user login dropdown end -->
     </ul>
     <!-- notificatoin dropdown end-->
   </div>
</header>
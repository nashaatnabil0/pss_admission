<?php
session_start();
include('includes/dbconnection.php');
error_reporting(0);
if (strlen($_SESSION['agmsaid']==0)) {
  header('location:logout.php');
  } else{
if(isset($_POST['submit']))
{

  $errors = [];   
$adminid=$_SESSION['agmsaid'];

$cpassword=md5($_POST['currentpassword']);
$newpassword=$_POST['newpassword'];
$Confpassword=$_POST['confirmpassword'];

$query=$pdoConnection-> query("select ID from tbladmin where ID='$adminid' and Password='$cpassword'");
$row=$query ->fetch(PDO:: FETCH_ASSOC);
if($row>0){

  $passwordPattern= '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
  if(preg_match($passwordPattern,$newpassword)){
    // Password Accepted
        if ($Confpassword === $newpassword) {
          //Password match

          $newpassword=md5($_POST['newpassword']);
          $query=$pdoConnection-> query("update tbladmin set Password='$newpassword' where ID='$adminid'");
            if($query)
            {
            echo '<script>alert("Your password successully changed.")</script>';
            echo "<script type='text/javascript'> document.location ='admin-profile.php'; </script>";
            session_destroy();
            }else{
             echo "<script>alert('Somthing Wrong');</script>";
            }
        } else {
              //not match
          $errors['PassMatch'] = "Confirmation Password not match";
        }

  }else{
          //Weak Password Rejected
    $errors['PassWeak'] = "Password must have Uppercase, lowercase, dight, spicial char, and length must be 8 or more";
  }
} else {
echo '<script>alert("Your current password is wrong.")</script>';
}

}

  
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  
  

  <title>Change Password | Galerie Management System</title>

  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <!-- Custom styles -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet" />
</head>

<body>
  <!-- container section start -->
  <section id="container" class="">
    <!--header start-->
    <?php include_once('includes/header.php');?>
    <!--header end-->

    <!--sidebar start-->
   <?php include_once('includes/sidebar.php');?>
    <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-files-o"></i> Change Password</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Change Password</li>
              <li><i class="fa fa-files-o"></i>Change Password</li>
            </ol>
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Change Password
              </header>
              
            </section>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">
                <div class="form">
                  
                  <form class="form-validate form-horizontal" method="post" action="" name="changepassword" onsubmit="return checkpass();">
                    <div class="form-group ">
                      <label for="fullname" class="control-label col-lg-2">Current Password <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input type="password" name="currentpassword" class=" form-control" required= "true" value="">
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="address" class="control-label col-lg-2">New Password <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input type="password" name="newpassword" class="form-control" value="">
                        <span style="color:red;display:block;text-align:left"><?php echo (isset($errors['PassWeak']))?$errors['PassWeak']:'';?></span>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="username" class="control-label col-lg-2">Confirm Password <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input type="password" name="confirmpassword" class="form-control" value="">
                        <span style="color:red;display:block;text-align:left"><?php echo (isset($errors['PassMatch']))?$errors['PassMatch']:'';?></span>
                      </div>
                    </div>
                  
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-primary" type="submit" name="submit">Change</button>
                       
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
    <!--main content end-->
     <?php include_once('includes/footer.php');?>
  </section>
  <!-- container section end -->

  <!-- javascripts -->
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- nice scroll -->
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
  <!-- jquery validate js -->
  <script type="text/javascript" src="js/jquery.validate.min.js"></script>

  <!-- custom form validation script for this page-->
  <script src="js/form-validation-script.js"></script>
  <!--custome script for all page-->
  <script src="js/scripts.js"></script>


</body>

</html>
<?php }  ?>
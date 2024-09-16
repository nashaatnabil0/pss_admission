<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include ('includes/validation.php');
if (strlen($_SESSION['sportadmission']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {
    $errors = [];
      $adminid=$_SESSION['sportadmission'];
      $aname=$_POST['name'];
      if (empty($aname)) {
        $errors['name'] = "Name cannot be empty";
    }

    $mobnum=trim($_POST['contactnumber']);

    $monnumPattern='/^(011|010|015|012)[0-9]{8}$/';
    if (empty($mobnum)) {
      $errors['mobnum'] = "phone number cannot be empty";
  }elseif(!preg_match($monnumPattern,$mobnum)){
     $errors['mobnuminvalid'] = "Invalid phone number format Must be 11 digits & start with (012 / 011 / 015 / 010)";
 }


 if (empty($errors)) {
     $query=$pdoConnection-> query("update users set name ='$aname', MobileNumber='$mobnum' where ID='$adminid'");
    if ($query) {
    echo "<script>alert('Admin profile has been updated.');</script>";
    echo "<script>window.location.href='admin-profile.php'</script>";
  }
  else
    {
      echo "<script>alert('Something Went Wrong. Please try again.');</script>";
    }
  }

}
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  
 

  <title>Admin-Profile | Peace Sports School Admission System</title>

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
            <h3 class="page-header"><i class="fa fa-user-md"></i> Profile</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_documents_alt"></i>Pages</li>
              <li><i class="fa fa-user-md"></i>Profile</li>
            </ol>
          </div>
        </div>
          <!-- profile-widget -->
       
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <div class="panel-body">
                  <div id="edit-profile" class="tab-pane">
                    <section class="panel">
                      <div class="panel-body bio-graph-info">
                        <h1> Profile Info</h1>
                        <form class="form-horizontal" role="form" method="post" action="">
                                  <?php
                                $adminid=$_SESSION['sportadmission'];
                                $ret=$pdoConnection-> query("select * from users where ID='$adminid'");
                                $cnt=1;
                                while ($row=$ret ->fetch(PDO:: FETCH_ASSOC)) {
                                ?>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Name</label>
                            <div class="col-lg-6">
                              <input class=" form-control" id="adminname" name="name" type="text" value="<?php  echo $row['name'];?>">
                              <?php if(isset($_POST['submit']) && isset($errors['name'])){ ?>
                                <span style="color:red;display:block;text-align:left"><?php echo $errors['name'] ?></span>
                              <?php } ?>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-lg-2 control-label">Contact Number</label>
                            <div class="col-lg-6">
                              <input class="form-control " id="contactnumber" name="contactnumber" type="text" value="<?php  echo $row['MobileNumber'];?>" required="true">
                              <?php if(isset($_POST['submit']) && isset($errors['mobnum'])){  ?>
                              <span style="color:red;display:block;text-align:left"><?php echo $errors['mobnum'];  ?></span>
                              <?php } elseif($errors['mobnuminvalid']!=""){ ?>
                              <span style="color:red;display:block;text-align:left"><?php echo $errors['mobnuminvalid'] ?></span>
                              <?php }?>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Email</label>
                            <div class="col-lg-6">
                              <input class="form-control " id="email" name="email" type="email" value="<?php  echo $row['Email'];?>" required="true" readonly='true'>
                            </div>
                          </div>
                         
                          <?php } ?>

                          <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                              <button type="submit" class="btn btn-primary" name="submit">Update</button>
                              
                            </div>
                          </div>
                        </form>
                      </div>
                    </section>
                  </div>
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
  <!-- jquery knob -->
  <script src="assets/jquery-knob/js/jquery.knob.js"></script>
  <!--custome script for all page-->
  <script src="js/scripts.js"></script>

  <script>
    //knob
    $(".knob").knob();
  </script>


</body>

</html>
<?php }  ?>
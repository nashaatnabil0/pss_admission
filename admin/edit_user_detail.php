<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sportadmission']==0)) {
  header('location:logout.php');
  }
  else{
    $cid=$_GET['editid'];
    $errors = [];
    if(isset($_POST['submit'])){
      $name = trim($_POST['name']);
      if (empty($name)) {
        $errors['name'] = "Name cannot be empty";
    }
      $mobnum = trim($_POST['mobnum']);
      $monnumPattern='/^(011|010|015|012)[0-9]{8}$/';
      if (empty($mobnum)) {
        $errors['mobnum'] = "phone number cannot be empty";
    }elseif(!preg_match($monnumPattern,$mobnum)){
       $errors['mobnuminvalid'] = "Invalid phone number format Must be 11 digits & start with (012 / 011 / 015 / 010)";
   }
  
      $email = trim($_POST['email']);
  
      if (empty($email)) {
        $errors['email'] = "Email cannot be empty";
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        }
    $role= trim($_POST['role']);
    if (empty($role)) {
      $errors['role'] = "Please choose a role";
  }
    if(empty($errors)){
      // $query = $pdoConnection->query("INSERT INTO users (Name, MobileNumber, Email, role ,password ) VALUES ('$name', '$mobnum', '$email', '$role','$password')");
      $query = $pdoConnection->query("UPDATE users SET name='$name',MobileNumber='$mobnum',Email='$email',role='$role' WHERE ID = $cid;");
  
      if ($query) {
          echo "<script>alert('Admin/ Moderator Data has been Updated.');</script>";
          echo "<script>window.location.href ='viewall_users.php'</script>";
      } else {
          echo "<script>alert('Something Went Wrong. Please try again.');</script>";
        }
      }    
  }
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  
  <title>Edit User |Peace Sports School Admission System</title>

  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <link href="css/daterangepicker.css" rel="stylesheet" />
  <link href="css/bootstrap-datepicker.css" rel="stylesheet" />
  <link href="css/bootstrap-colorpicker.css" rel="stylesheet" />
  <!-- date picker -->

  <!-- color picker -->

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
            <h3 class="page-header"><i class="fa fa-file-text-o"></i>Edit User</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Users</li>
              <li><i class="fa fa-file-text-o"></i>Edit User Information</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
              Edit Admin/ Moderator Detail
              </header>
              <div class="panel-body">
                <form class="form-horizontal " method="post" action="">
                  <p style="font-size:16px; color:red" align="left"> <?php if($msg){echo $msg;}  ?> </p>
                    <?php
                    $ret= $pdoConnection-> query("SELECT * FROM users where ID='$cid'");
                    $cnt=1;
                    while ($row=$ret->fetch(PDO:: FETCH_ASSOC)) {
                    ?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="name" name="name"  type="text" value="<?php  echo $row['name'];?>" required/>
                      <?php if(isset($_POST['submit'])&& isset($errors['name'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['name'] ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Mobile Number</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="mobnum" name="mobnum"  type="text" value="<?php  echo $row['MobileNumber'];?>" required>
                      <?php if(isset($_POST['submit'])){ if(isset($errors['mobnum'])){  ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['mobnum'];?></span>
                       <?php } elseif($errors['mobnuminvalid']!=""){ ?>
                       <span style="color:red;display:block;text-align:left"><?php echo $errors['mobnuminvalid'] ?></span>
                       <?php } }  ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="email" name="email" type="email" value="<?php  echo $row['Email'];?>" required>
                      <?php if(isset($_POST['submit']) && isset($errors['email'])) { ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['email']; ?></span>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="form-group">
                    <label class="col-sm-2 control-label">Role</label>
                    <div class="col-sm-10">
                    <input class="" id="role" name="role"  type="radio" value="admin" style="margin:7px" <?php if($row['role']==='admin'){ echo 'checked';}?> required > Admin <span style="margin: 35px"></span>
                    <input class="" id="rolemod" name="role"  type="radio" value="moderator" style="margin:7px" <?php if($row['role']==='moderator'){ echo 'checked';}?> required> Moderator  <span style="margin: 35px"></span>
                    <input class="" id="roleAcc" name="role"  type="radio" value="accountant" style="margin:7px" <?php if($row['role']==='accountant'){ echo 'checked';}?> required> Accountant   
                    <?php if(isset($_POST['submit']) && isset($errors['role'])) { ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['role']; ?></span>
                        <?php } ?>
                  </div>
                  </div>
                <?php } ?>
                 <p style="text-align: center;"> <button type="submit" name='submit' class="btn btn-primary">Update</button></p>
                </form>
              </div>
            </section>
            
          </div>
        </div>
        <!-- Basic Forms & Horizontal Forms-->

        
         
      
        <!-- page end-->
      </section>
    </section>
 <?php include_once('includes/footer.php');?>
  </section>
  <!-- container section end -->
  <!-- javascripts -->
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- nice scroll -->
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.nicescroll.js" type="text/javascript"></script>

  <!-- jquery ui -->
  <script src="js/jquery-ui-1.9.2.custom.min.js"></script>

  <!--custom checkbox & radio-->
  <script type="text/javascript" src="js/ga.js"></script>
  <!--custom switch-->
  <script src="js/bootstrap-switch.js"></script>
  <!--custom tagsinput-->
  <script src="js/jquery.tagsinput.js"></script>

  <!-- colorpicker -->

  <!-- bootstrap-wysiwyg -->
  <script src="js/jquery.hotkeys.js"></script>
  <script src="js/bootstrap-wysiwyg.js"></script>
  <script src="js/bootstrap-wysiwyg-custom.js"></script>
  <script src="js/moment.js"></script>
  <script src="js/bootstrap-colorpicker.js"></script>
  <script src="js/daterangepicker.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <!-- ck editor -->
  <script type="text/javascript" src="assets/ckeditor/ckeditor.js"></script>
  <!-- custom form component script for this page-->
  <script src="js/form-component.js"></script>
  <!-- custome script for all page -->
  <script src="js/scripts.js"></script>


</body>

</html>
<?php  } ?>
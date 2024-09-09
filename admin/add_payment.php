<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sportadmission']==0)) {
  header('location:logout.php');
  }
else {
  $errors = [];
  $formSubmitted = $_SERVER["REQUEST_METHOD"] == "POST";
  if ($formSubmitted) {
    $name = $_POST['name'];
    if (empty($name)) {
      $errors['name'] = "Name cannot be empty";
  }
    $mobnum = $_POST['mobnum'];
    $monnumPattern='/^(011|010|015|012)[0-9]{8}$/';
    if (empty($mobnum)) {
      $errors['mobnum'] = "phone number cannot be empty";
  }elseif(!preg_match($monnumPattern,$mobnum)){
     $errors['mobnuminvalid'] = "Invalid phone number format Must be 11 digits & start with (012 / 011 / 015 / 010)";
 }

    $email = $_POST['email'];

    if (empty($email)) {
      $errors['email'] = "Email cannot be empty";
  }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $errors['email'] = "Invalid email format";
      }
   
      $edudetails = $_POST['edudetails'];
      $awarddetails = $_POST['awarddetails'];

        $img = $_FILES["images"]["name"];
      $extension = substr($img, strlen($img) - 4, strlen($img));
      // Allowed extensions
      $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");
      // Validation for allowed extensions
      if (!in_array($extension, $allowed_extensions)) {
          $errors['images'] = "Invalid format. Only jpg / jpeg/ png /gif format allowed";
       }

      if (empty($errors)) {
          $proimg = md5($img) . $extension;
          move_uploaded_file($_FILES["images"]["tmp_name"], "images/" . $proimg);

          $query = $pdoConnection->query("INSERT INTO tblartist(Name, MobileNumber, Email, Education, Award, Profilepic) VALUES ('$name', '$mobnum', '$email', '$edudetails', '$awarddetails', '$proimg')");

          if ($query) {
              echo "<script>alert('Artist details have been added.');</script>";
              echo "<script>window.location.href ='manage-artist.php'</script>";
          } else {
              echo "<script>alert('Something Went Wrong. Please try again.');</script>";
            }
      }else{
        $nameVal=$_POST['name'];
        $emailVal=$_POST['email'];
        $mobnumVal=$_POST['mobnum'];
        $eduVal=$_POST['edudetails'];
        $awdVal=$_POST['awarddetails'];
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Add Payment | Peace Sports School Admission System</title>

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
            <h3 class="page-header"><i class="fa fa-file-text-o"></i>Add Artist Detail</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Artist</li>
              <li><i class="fa fa-file-text-o"></i>Add Artist Detail</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
             Add Artist Detail
              </header>
              <div class="panel-body">
                <form class="form-horizontal " method="post" action="" enctype="multipart/form-data" novalidate>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="name" name="name"  type="text" value = "<?php echo (isset($nameVal))?$nameVal:'';?>"/>
                      <?php if($formSubmitted && isset($errors['name'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['name'] ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Mobile Number</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="mobnum" name="mobnum"  type="text" value = "<?php echo (isset($mobnumVal))?$mobnumVal:'';?>">
                      <?php if($formSubmitted){ if(isset($errors['mobnum'])){  ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['mobnum'];  ?></span>
                       <?php } elseif($errors['mobnuminvalid']!=""){ ?>
                       <span style="color:red;display:block;text-align:left"><?php echo $errors['mobnuminvalid'] ?></span>
                       <?php } }  ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="email" name="email" type="email" value = "<?php echo (isset($emailVal))?$emailVal:'';?>">
                      <?php if($formSubmitted && isset($errors['email'])) { ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['email']; ?></span>
                        <?php } ?>
                      </div>
                    </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Education Details</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="edudetails" value = "<?php echo (isset($eduVal))?$eduVal:'';?>"></textarea>
            
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Award Details</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="awarddetails" value = "<?php echo (isset($awdVal))?$awdVal:'';?>"></textarea>
                  
                    </div>
                  </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Image</label>
                    <div class="col-sm-10">
                       <input type="file" class="form-control" name="images" id="images" value="" required="true">
                       <?php if($formSubmitted && isset($errors['images'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['images'] ?></span>
                       <?php } ?>
                      </div>
                  </div>
                 <p style="text-align: center;"> <button type="submit" name='submit' class="btn btn-primary">Submit</button></p>
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
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sportadmission']==0)) {
  header('location:logout.php');
}
else {
  $errors = [];
if (isset($_POST['submit'])) {
    // Trainee
    $name =trim($_POST['Name']);
    $namePattern = '/^[a-zA-Z]+(?:\s+[a-zA-Z]+)+$/';
    if (empty($name)) {
        $errors['Name'] = "Name cannot be empty";
    }elseif (!preg_match( $namePattern , $name)) {
      $errors['Name'] = "Name must be two words at least and contain letters only ";
     }
    
    $gender = trim ($_POST['gender']);
    if (empty($gender)) {
        $errors['gender'] = "Please Choose a gender";
    }
    
    $contactmobnum = trim($_POST['contactMobNum']);
    $mobnumPattern = '/^(011|010|015|012)[0-9]{8}$/';
    if (empty($contactmobnum)) {
        $errors['contactMobNum'] = "Phone number cannot be empty";
    } elseif (!preg_match($mobnumPattern, $contactmobnum)) {
        $errors['contactMobNuminvalid'] = "Invalid phone number format Must be 11 digits & start with (012 / 011 / 015 / 010)";
    }

    $birthdate = $_POST['birthdate'];
    if (empty($birthdate)) {
        $errors['birthdate'] = "Birthdate cannot be empty";
    }
    
    $nidPattern ='/^\d{3}(0[0-9]|1[0-2])([0-2][0-9]|3[01])\d{7}$/';
    $NID = trim($_POST['NID']);
    if (empty($NID)) {
        $errors['NID'] = "National ID number cannot be empty";
    } elseif (!preg_match($nidPattern, $NID)){
      $errors['NIDinvalid'] = "Please enter a valid 14-digit National ID where the 4th and 5th digits form a number less than or equal to 12, and the 6th and 7th digits form a number less than or equal to 31.";
    }

    // Father
    $fatherName = trim( $_POST['fatherName']);
    if (empty($fatherName)) {
      $errors['fatherName'] = "Father full name can't be empty";
    }elseif (!preg_match( $namePattern , $fatherName)) {
      $errors['fatherName'] = "Name must be two words at least  and contain letters only ";
     }

    $fatherJob = trim($_POST['fatherJob']);
    if (empty($fatherJob)) {
      $errors['fatherJob'] = "Father job can't be empty";
    }
    $fathermobnum = trim($_POST['fatherMobNum']);
    if (empty($fathermobnum)) {
        $errors['fatherMobNum'] = "Phone number cannot be empty";
    } elseif (!preg_match($mobnumPattern, $fathermobnum)) {
        $errors['fatherMobNuminvalid'] = "Invalid phone number format Must be 11 digits & start with (012 / 011 / 015 / 010)";
    }

    // Mother
    $motherName = trim($_POST['motherName']);
    if (empty($motherName)) {
      $errors['motherName'] = "Mother full name can't be empty";
    }elseif (!preg_match( $namePattern , $motherName)) {
      $errors['fatherName'] = "Name must be two words at least  and contain letters only ";
     }

    $motherJob = trim($_POST['motherJob']);
    if (empty($motherName)) {
      $errors['motherJob'] = "Mother job can't be empty";
    }
    $mothermobnum = trim( $_POST['motherMobNum']);
    if (empty($mothermobnum)) {
        $errors['motherMobNum'] = "Phone number cannot be empty";
    } elseif (!preg_match($mobnumPattern, $mothermobnum)) {
        $errors['motherMobNuminvalid'] = "Invalid phone number format Must be 11 digits & start with (012 / 011 / 015 / 010)";
    }

    // Photo & Birth Certificate/NID
    $allowed_extensions = ["jpg", "jpeg", "png", "gif"];

   
    function uploadImages($imageFile, $name, $NID ) {
      
      if ($imageFile["name"] != "") {
        $extension = strtolower(pathinfo($imageFile["name"], PATHINFO_EXTENSION));
              $newImageName = $NID .'-'. $name. '.' . $extension;
              move_uploaded_file($imageFile["tmp_name"], "images/" . $newImageName);
              return $newImageName;
          } else {
            return null;
          }
      
      return null;
    }

    function checkExtensions($imageFile, $allowed_extensions, $fileInputName ) {
      if ($imageFile["name"] != "") {
          $extension = strtolower(pathinfo($imageFile["name"], PATHINFO_EXTENSION));
          if (!in_array($extension, $allowed_extensions)) {
            $errors[$fileInputName] = "Invalid format. Only jpg / jpeg / png / gif format allowed.";
          }
      }
    }

    //var_dump($_FILES);
    $traineeImg = trim($_FILES['traineePic']['name']);
    if (empty($traineeImg)){
      $errors['traineePicempty'] = "Please upload trainee Photo.";
    }else{
      checkExtensions($_FILES["traineePic"], $allowed_extensions,'traineePic');
    }
    
    $certImg = trim($_FILES['bdimg']['name']);
    if (empty($certImg)){
      $errors['bdimgempty'] = "Please upload Birth Certificate or National ID photo.";
    }else{
      checkExtensions($_FILES["bdimg"], $allowed_extensions,'bdimg');
    }

  
    //notes
  $notes = trim($_POST['Notes']);
  if ($notes == "") {
      $notes = null;
  }
  
  if(empty($errors)){
  //insert into databse
  $traineePhoto = uploadImages($_FILES["traineePic"],'proimg', $NID);
  $bdImage = uploadImages($_FILES["bdimg"], 'certimg', $NID);

  $query = $pdoConnection->query("INSERT INTO trainees (Name, NID, birthDate, gender, photo, birthCertificate,contactMobNum,fatherName,fatherMobNum,fatherJob,motherName,motherMobNum,motherJob,Notes) VALUES ('$name', '$NID','$birthdate', '$gender', '$traineePhoto','$bdImage','$contactmobnum','$fatherName','$fathermobnum','$fatherJob','$motherName','$mothermobnum','$motherJob','$notes')");
  
          if ($query) {
            
              echo "<script>alert('Trainee has been added.');</script>";
              echo "<script>window.location.href ='viewall_trainees.php'</script>";
          } else {
              echo "<script>alert('Something Went Wrong. Please try again.');</script>";
            }
   }else{

   }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Add Trainee | Peace Sports School Admission System</title>

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
            <h3 class="page-header"><i class="fa fa-file-text-o"></i>Add trinee</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Trainee</li>
              <li><i class="fa fa-file-text-o"></i>Add Trainee</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
             Add Trainee Details
              </header>
              <div class="panel-body">
                <form class="form-horizontal " method="post" action="" enctype="multipart/form-data" novalidate>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="Name" name="Name"  type="text" value=""/>
                      <?php if( isset($_POST['submit']) && isset($errors['Name'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['Name']; ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">National ID</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="NID" name="NID"  type="text" value="" >
                      <?php if(isset($_POST['submit']) && isset($errors['NID'])) { ?>
                            <span style="color:red;display:block;text-align:left"><?php echo $errors['NID']; ?></span>
                        <?php } ?>
                        <?php if( isset($_POST['submit']) && isset($errors['NIDinvalid'])){ ?>
                            <span style="color:red;display:block;text-align:left"><?php echo $errors['NIDinvalid']; ?></span>
                        <?php }  ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Birthdate</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="birthdate" name="birthdate"  type="date" value="">
                      <?php if(isset($_POST['submit']) && isset($errors['birthdate'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['birthdate']; ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Gender</label>
                    <div class="col-sm-10">
                     <input class="" id="gender" name="gender"  type="radio" value="male" style="margin:7px"> Male <span style="margin: 35px"></span>
                      <input class="" id="gender" name="gender"  type="radio" value="female" style="margin:7px"> Female
                      <?php if(isset($_POST['submit']) && isset($errors['gender'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['gender']; ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Contact Mobile Number</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="contactMobNum" name="contactMobNum" type="text" value="">
                      <?php if(isset($_POST['submit']) && isset($errors['contactMobNum'])) { ?>
                            <span style="color:red;display:block;text-align:left"><?php echo $errors['contactMobNum']; ?></span>
                        <?php } ?>
                       <?php if( isset($_POST['submit']) && isset($errors['contactMobNuminvalid'])) { ?>
                            <span style="color:red;display:block;text-align:left"><?php echo $errors['contactMobNuminvalid']; ?></span>
                        <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Father Name</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="fatherName" name="fatherName"  type="text" value=""/>
                      <?php if(isset($_POST['submit']) && isset($errors['fatherName'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['fatherName']; ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Father Job</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="fatherJob" name="fatherJob"  type="text" value=""/>
                      <?php if(isset($_POST['submit']) && isset($errors['fatherJob'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['fatherJob']; ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Father Mobile Number</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="fatherMobNum" name="fatherMobNum"  type="text" value="">
                      <?php if(isset($_POST['submit']) && isset($errors['fatherMobNum'])){  ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['fatherMobNum'];  ?></span>
                       <?php } ?>
                       <?php if(isset($_POST['submit']) && isset($errors['fatherMobNuminvalid'])){ ?>
                       <span style="color:red;display:block;text-align:left"><?php echo $errors['fatherMobNuminvalid'] ?></span>
                       <?php }   ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Mother Name</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="motherName" name="motherName"  type="text" value=""/>
                      <?php if(isset($_POST['submit']) && isset($errors['motherName'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['motherName']; ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Mother Job</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="motherJob" name="motherJob"  type="text"value=""/>
                      <?php if(isset($_POST['submit']) && isset($errors['motherJob'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['motherJob']; ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Mother Mobile Number</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="motherMobNum"  name="motherMobNum"  type="text"value="">
                      <?php if(isset($_POST['submit']) && isset($errors['motherMobNum'])){ ?>
                            <span style="color:red;display:block;text-align:left"><?php echo $errors['motherMobNum'];  ?></span>
                        <?php } elseif(isset($_POST['submit']) && isset($errors['motherMobNuminvalid'])){ ?>
                            <span style="color:red;display:block;text-align:left"><?php echo $errors['motherMobNuminvalid']; ?></span>
                        <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                  <label class="col-sm-2 control-label">Trainee Photo</label>
                  <div class="col-sm-10">
                      <input type="file" class="form-control" name="traineePic" id="traineePic" required value="">
                      <?php if(isset($_POST['submit']) && isset($errors['traineePic'])) { ?>
                          <span style="color:red;display:block;text-align:left"><?php echo $errors['traineePic']; ?></span>
                      <?php } ?>
                      <?php if(isset($_POST['submit']) && isset($errors['traineePicempty'])) { ?>
                          <span style="color:red;display:block;text-align:left"><?php echo $errors['traineePicempty']; ?></span>
                      <?php } ?>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-2 control-label">Birth Certificate / National ID Image</label>
                  <div class="col-sm-10">
                      <input type="file" class="form-control" name="bdimg" id="bdimg" required value="">
                      <?php if(isset($_POST['submit']) && isset($errors['bdimg'])) { ?>
                          <span style="color:red;display:block;text-align:left"><?php echo $errors['bdimg']; ?></span>
                      <?php } ?>
                      <?php if(isset($_POST['submit']) && isset($errors['bdimgempty'])) { ?>
                          <span style="color:red;display:block;text-align:left"><?php echo $errors['bdimgempty']; ?></span>
                      <?php } ?>
                  </div>
              </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Notes</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="Notes" value=""></textarea>
                    </div>
                  </div>
                 <p style="text-align: center;"> <button type="submit" name="submit" class="btn btn-primary">Submit</button></p>
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
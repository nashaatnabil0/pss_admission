<?php
session_start();
// error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sportadmission']==0)) {
  header('location:logout.php');
  }
  else{
    $errors = [];
    $cid=$_GET['editid'];

    if (isset($_POST['submit'])) {
    // Trainee
    $name = trim($_POST['Name']);
    if (empty($name)) {
        $errors['Name'] = "Name cannot be empty";
    }
    
    $gender = $_POST['gender'];
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

    $birthdate = trim($_POST['birthdate']);
    if (empty($birthdate)) {
        $errors['birthdate'] = "Birthdate cannot be empty";
    }
    
    $NID = trim($_POST['NID']);
    if (empty($NID)) {
        $errors['NID'] = "National ID number cannot be empty";
    }
    $nidPattern ='/^\d{3}(0[0-9]|1[0-2])([0-2][0-9]|3[01])\d{7}$/';
    if (!preg_match($nidPattern, $NID)){
      $errors['NIDinvalid'] = "Please enter a valid 14-digit National ID where the 4th and 5th digits form a number less than or equal to 12, and the 6th and 7th digits form a number less than or equal to 31.";
    }

    // Father
    $fatherName = trim($_POST['fatherName']);
    if (empty($fatherName)) {
      $errors['fatherName'] = "Father full name can't be empty";
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
    }
    $motherJob = trim($_POST['motherJob']);
    if (empty($motherName)) {
      $errors['motherJob'] = "Mother job can't be empty";
    }
    $mothermobnum =trim($_POST['motherMobNum']);
    if (empty($mothermobnum)) {
        $errors['motherMobNum'] = "Phone number cannot be empty";
    } elseif (!preg_match($mobnumPattern, $mothermobnum)) {
        $errors['motherMobNuminvalid'] = "Invalid phone number format Must be 11 digits & start with (012 / 011 / 015 / 010)";
    }

        //notes
    $notes = trim($_POST['Notes']);
    if ($notes == "") {
        $notes = null;
    }
        

    // Photo & Birth Certificate/NID
    //fetching photos from the database to update
    $delete_image = $pdoConnection -> query("select photo , birthCertificate from trainees where NID='$cid'");
    $image_data = $delete_image-> fetch(PDO:: FETCH_ASSOC);
  
    $existing_TraineePhoto = $image_data['photo'];
    $existing_birthcertificate = $image_data['birthCertificate'];

    $allowed_extensions = ["jpg", "jpeg", "png", "gif"];
    
   //&$error to modify the errors array outside the function
   function uploadImages($imageFile, $allowed_extensions, $name, $NID, &$errors ,$fileInputName ) {
     if ($imageFile["name"] != "") {
         $extension = strtolower(pathinfo($imageFile["name"], PATHINFO_EXTENSION));
         if (in_array($extension, $allowed_extensions)) {
             $newImageName = $NID .'-'. $name. $fileInputName . '.' . $extension;
             move_uploaded_file($imageFile["tmp_name"], "images/" . $newImageName);
             return $newImageName;
         } else {
           $errors[$fileInputName] = "Invalid format. Only jpg / jpeg / png / gif format allowed.";
           return null;
         }
     }
     return null;
   }

//var_dump($_FILES);
   $traineePhoto = uploadImages($_FILES["traineePic"], $allowed_extensions, $name, $NID, $errors, 'traineePic');
   if (empty($traineePhoto)){
     $traineePhoto= $existing_TraineePhoto;
   }

   $bdImage = uploadImages($_FILES["bdimg"], $allowed_extensions, $name, $NID, $errors, 'bdimg');
   if (empty($bdImage)){
     $bdImage = $existing_birthcertificate;
   }

  if(empty($errors)){
  //insert into databse
  $query = $pdoConnection->query("UPDATE trainees SET Name= '$name', NID='$NID', birthDate='$birthdate', gender='$gender', photo='$traineePhoto', birthCertificate='$bdImage',contactMobNum='$contactmobnum',fatherName='$fatherName',fatherMobNum='$fathermobnum',fatherJob='$fatherJob',motherName='$motherName',motherMobNum='$mothermobnum',motherJob='$motherJob', Notes ='$notes' WhERE NID = $cid;");
      
          if ($query) {
            if ($traineePhoto != $existing_TraineePhoto) {
              unlink("images/" . $existing_TraineePhoto);
              }
         
         if ($bdImage != $existing_birthcertificate) {
              unlink("images/" . $existing_birthcertificate);
             }   
              echo "<script>alert('Trainee information have been updated.');</script>";
              echo "<script>window.location.href ='viewall_trainees.php'</script>";
          } else {
              echo "<script>alert('Something Went Wrong. Please try again.');</script>";
            }
      }    else {
        var_dump($errors);
      } 
   }

  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  
  <title>Edit Trainee | Peace Sports School Admission System</title>

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
            <h3 class="page-header"><i class="fa fa-file-text-o"></i>Update Trainee Information</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Trainee</li>
              <li><i class="fa fa-file-text-o"></i>Trainee Information</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
               Update Trainee Information
              </header>
              <div class="panel-body">
                <form class="form-horizontal " method="post" action="" enctype="multipart/form-data" novalidate>
                <?php
                      $query=$pdoConnection-> query("select * from trainees where NID='$cid'");
                      $row=$query ->fetch(PDO:: FETCH_ASSOC);
                      if($row > 0) {
                      ?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="Name" name="Name"  type="text" value="<?php  echo $row['Name'];?>"/>
                      <?php if( isset($_POST['submit']) && isset($errors['Name'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['Name']; ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">National ID</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="NID" name="NID"  type="text" value="<?php  echo $row['NID'];?>" >
                      <?php if(isset($_POST['submit']) && isset($errors['NID'])) { ?>
                            <span style="color:red;display:block;text-align:left"><?php echo $errors['NID']; ?></span>
                        <?php } ?>
                       <?php if( isset($_POST['submit']) && isset($errors['NIDinvalid'])) { ?>
                            <span style="color:red;display:block;text-align:left"><?php echo $errors['NIDinvalid']; ?></span>
                        <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Birthdate</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="birthdate" name="birthdate"  type="date" value="<?php  echo $row['birthDate'];?>">
                      <?php if(isset($_POST['submit']) && isset($errors['birthdate'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['birthdate']; ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Gender</label>
                    <div class="col-sm-10">
                     <input class="" id="gender" name="gender"  type="radio" value="male" style="margin:7px" <?php if($row['gender']==='male'){ echo 'checked';} ?>> Male <span style="margin: 35px"></span>
                      <input class="" id="gender" name="gender"  type="radio" value="female" style="margin:7px" <?php if($row['gender']==='female'){ echo 'checked';} ?>> Female
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Contact Mobile Number</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="contactMobNum" name="contactMobNum" type="text" value="<?php echo $row['contactMobNum']; ?>">
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
                      <input class="form-control" id="fatherName" name="fatherName"  type="text" value="<?php echo $row['fatherName']; ?>"/>
                      <?php if(isset($_POST['submit']) && isset($errors['fatherName'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['fatherName']; ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Father Job</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="fatherJob" name="fatherJob"  type="text" value="<?php echo $row['fatherJob']; ?>"/>
                      <?php if(isset($_POST['submit']) && isset($errors['fatherJob'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['fatherJob']; ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Father Mobile Number</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="fatherMobNum" name="fatherMobNum" type="text" value="<?php echo $row['fatherMobNum']; ?>">
                      <?php if(isset($_POST['submit']) && isset($errors['fatherMobNum'])){  ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['fatherMobNum'];  ?></span>
                       <?php } ?>
                       <?php if(isset($_POST['submit']) && isset($errors['fatherMobNuminvalid'])){ ?>
                       <span style="color:red;display:block;text-align:left"><?php echo $errors['fatherMobNuminvalid'] ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Mother Name</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="motherName" name="motherName"  type="text" value="<?php echo $row['motherName']; ?>"/>
                      <?php if(isset($_POST['submit']) && isset($errors['motherName'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['motherName']; ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Mother Job</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="motherJob" name="motherJob"  type="text"value="<?php echo $row['motherJob']; ?>" />
                      <?php if(isset($_POST['submit']) && isset($errors['motherJob'])){ ?>
                        <span style="color:red;display:block;text-align:left"> <?php echo $errors['motherJob'] ?> </span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Mother Mobile Number</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="motherMobNum" name="motherMobNum" type="text"value="<?php echo $row['motherMobNum']; ?>">
                      <?php if(isset($_POST['submit']) && isset($errors['motherMobNum'])){  ?>
                        <span style="color:red;display:block;text-align:left"><?php echo '0'.$errors['motherMobNum'];  ?></span>
                       <?php } ?>
                       <?php if(isset($_POST['submit']) && isset($errors['motherMobNuminvalid'])){ ?>
                       <span style="color:red;display:block;text-align:left"><?php echo $errors['motherMobNuminvalid']; ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Trainee Photo</label>
                    <div class="col-sm-10">
                      <img src="images/<?php echo $row['photo'];?>" width="150" height="200" >
                    </div>
                  </div>
                  <div class="form-group">
                  <label class="col-sm-2 control-label">change Trainee Photo</label>
                  <div class="col-sm-10">
                      <input type="file" class="form-control" name="traineePic" id="traineePic" >
                      <?php if(isset($errors['traineePic'])) { ?>
                          <span style="color:red;display:block;text-align:left"><?php echo $errors['traineePic']; ?></span>
                      <?php } ?>
                  </div>
              </div>
              <div class="form-group">
                    <label class="col-sm-2 control-label">Birth Certificate / National ID Image</label>
                    <div class="col-sm-10">
                      <img src="images/<?php echo $row['birthCertificate'];?>" width="150" height="200">
                    </div>
                  </div>
              <div class="form-group">
                  <label class="col-sm-2 control-label">Update Birth Certificate / National ID Image</label>
                  <div class="col-sm-10">
                      <input type="file" class="form-control" name="bdimg" id="bdimg" value="<?php echo $row['birthCertificate']; ?>">
                      <?php if(isset($errors['bdimg'])) { ?>
                          <span style="color:red;display:block;text-align:left"><?php echo $errors['bdimg']; ?></span>
                      <?php } ?>
                  </div>
              </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Notes</label>
                    <div class="col-sm-10">
                    <textarea class="form-control" name="Notes"><?php echo $row['Notes']; ?></textarea>
                    </div>
                  </div>
                  <?php } ?>
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
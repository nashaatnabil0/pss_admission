<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sportadmission']==0)) {
  header('location:logout.php');
}
else {
  $errors = [];
if (isset($_POST['submit'])) {
    // Trainee
    $name = $_POST['Name'];
    if (empty($name)) {
        $errors['Name'] = "Name cannot be empty";
    }
    
    $gender = $_POST['gender'];
    if (empty($gender)) {
        $errors['gender'] = "Please Choose a gender";
    }
    
    $contactmobnum = $_POST['contactMobNum'];
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
    
    $NID = $_POST['NID'];
    if (empty($NID)) {
        $errors['NID'] = "National ID number cannot be empty";
    }

    // Father
    $fatherName = $_POST['fatherName'];
    $fatherJob = $_POST['fatherJob'];
    $fathermobnum = $_POST['fatherMobNum'];
    if (empty($fathermobnum)) {
        $errors['fatherMobNum'] = "Phone number cannot be empty";
    } elseif (!preg_match($mobnumPattern, $fathermobnum)) {
        $errors['fatherMobNuminvalid'] = "Invalid phone number format Must be 11 digits & start with (012 / 011 / 015 / 010)";
    }

    // Mother
    $motherName = $_POST['motherName'];
    $motherJob = $_POST['motherJob'];
    $mothermobnum = $_POST['motherMobNum'];
    if (empty($mothermobnum)) {
        $errors['motherMobNum'] = "Phone number cannot be empty";
    } elseif (!preg_match($mobnumPattern, $mothermobnum)) {
        $errors['motherMobNuminvalid'] = "Invalid phone number format Must be 11 digits & start with (012 / 011 / 015 / 010)";
    }

    // Photo & Birth Certificate/NID
    $allowed_extensions = ["jpg", "jpeg", "png", "gif"];

    function uploadImages($imageFile, $allowed_extensions, $name, $NID) {
        if ($imageFile["name"] != "") {
            $extension = strtolower(pathinfo($imageFile["name"], PATHINFO_EXTENSION));
            if (in_array($extension, $allowed_extensions)) {
                $newImageName = $NID .'-'. md5($imageFile["name"]) . '.' . $extension;
                move_uploaded_file($imageFile["tmp_name"], "images/" . $newImageName);
                return $newImageName;
            } else {
              echo "<script>alert('Image " . $imageFile["name"] . " Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
              return null;
            }
        }
        return null;
      }

    $traineePhoto = uploadImages($_FILES["traineePic"], $allowed_extensions, $name, $NID);
    $bdImage = uploadImages($_FILES["bdimg"], $allowed_extensions, $name, $NID);
  
    //notes
  $notes =$_POST['Notes'];
  if($notes==""){
    $query = $pdoConnection->query("INSERT INTO trainees (Name, NID, birthDate, gender, photo, birthCertificate,contactMobNum,fatherName,fatherMobNum,fatherJob,motherName,motherMobNum,motherJob) VALUES ('$name', '$NID','$birthdate', '$gender', '$traineePhoto','$bdImage','$contactmobnum','$fatherName','$fathermobnum','$fatherJob','$motherName','$mothermobnum','$motherJob')");
  }else{
  //insert into databse
  $query = $pdoConnection->query("INSERT INTO trainees (Name, NID, birthDate, gender, photo, birthCertificate,contactMobNum,fatherName,fatherMobNum,fatherJob,motherName,motherMobNum,motherJob,Notes) VALUES ('$name', '$NID','$birthdate', '$gender', '$traineePhoto','$bdImage','$contactmobnum','$fatherName','$fathermobnum','$fatherJob','$motherName','$mothermobnum','$motherJob','$notes')");
  }
          if ($query) {
              echo "<script>alert('Trainee has been added.');</script>";
              echo "<script>window.location.href ='viewall_trainees.php'</script>";
          } else {
              echo "<script>alert('Something Went Wrong. Please try again.');</script>";
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
                <form class="form-horizontal " method="post" action="" enctype="multipart/form-data" >
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="Name" name="Name"  type="text" />
                      <?php if( isset($errors['Name'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['Name'] ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">National ID</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="NID" name="NID"  type="text" >
                      <?php if(isset($_POST['submit'])){ 
                        if(isset($errors['NID'])){  ?>
                            <span style="color:red;display:block;text-align:left"><?php echo $errors['NID']; ?></span>
                        <?php } elseif(isset($errors['nidinvalid'])){ ?>
                            <span style="color:red;display:block;text-align:left"><?php echo $errors['nidinvalid']; ?></span>
                        <?php } } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Birthdate</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="birthdate" name="birthdate"  type="date">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Gender</label>
                    <div class="col-sm-10">
                      <input class="" id="gender" name="gender"  type="radio" value="male"> <t> Male <br>
                      <input class="" id="gender" name="gender"  type="radio" value="Female"> <t> Female
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Contact Mobile Number</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="contactMobNum" name="contactMobNum"  type="text">
                      <?php if(isset($_POST['submit'])){ 
                        if(isset($errors['contactMobNum'])){ ?>
                            <span style="color:red;display:block;text-align:left"><?php echo $errors['contactMobNum'];  ?></span>
                        <?php } elseif(isset($errors['contactMobNuminvalid'])){ ?>
                            <span style="color:red;display:block;text-align:left"><?php echo $errors['contactMobNuminvalid']; ?></span>
                        <?php } 
                        } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Father Name</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="fatherName" name="fatherName"  type="text"/>
                      <?php if(isset($errors['fatherName'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['fatherName'] ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Father Job</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="fatherJob" name="fatherJob"  type="text" />
                      <?php if(isset($_POST['submit']) && isset($errors['fatherJob'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['fatherJob'] ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Father Mobile Number</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="fatherMobNum" name="fatherMobNum"  type="text">
                      <?php if(isset($_POST['submit'])){ 
                        if(isset($errors['contactMobNum'])){ ?>
                            <span style="color:red;display:block;text-align:left"><?php echo $errors['contactMobNum'];  ?></span>
                        <?php } elseif(isset($errors['contactMobNuminvalid'])){ ?>
                            <span style="color:red;display:block;text-align:left"><?php echo $errors['contactMobNuminvalid']; ?></span>
                        <?php } 
                        } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Mother Name</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="motherName" name="motherName"  type="text"/>
                      <?php if(isset($_POST['submit']) && isset($errors['motherName'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['motherName'] ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Mother Job</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="motherJob" name="motherJob"  type="text"/>
                      <?php if(isset($_POST['submit']) && isset($errors['motherJob'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['motherJob'] ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Mother Mobile Number</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="motherMobNum" name="motherMobNum"  type="text">
                      <?php if(isset($_POST['submit'])){ 
                        if(isset($errors['contactMobNum'])){ ?>
                            <span style="color:red;display:block;text-align:left"><?php echo $errors['contactMobNum'];  ?></span>
                        <?php } elseif(isset($errors['contactMobNuminvalid'])){ ?>
                            <span style="color:red;display:block;text-align:left"><?php echo $errors['contactMobNuminvalid']; ?></span>
                        <?php } 
                        } ?>
                    </div>
                  </div>
                  <div class="form-group">
                  <label class="col-sm-2 control-label">Trainee Photo</label>
                  <div class="col-sm-10">
                      <input type="file" class="form-control" name="traineePic" id="traineePic" required>
                      <?php if(isset($errors['traineePhoto'])) { ?>
                          <span style="color:red;display:block;text-align:left"><?php echo $errors['traineePhoto']; ?></span>
                      <?php } ?>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-2 control-label">Birthday Certificate / National ID Image</label>
                  <div class="col-sm-10">
                      <input type="file" class="form-control" name="bdimg" id="bdimg" required>
                      <?php if(isset($errors['bdimg'])) { ?>
                          <span style="color:red;display:block;text-align:left"><?php echo $errors['bdimg']; ?></span>
                      <?php } ?>
                  </div>
              </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Notes</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="Notes"></textarea>
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
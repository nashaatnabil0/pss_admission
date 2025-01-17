<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sportadmission']==0)) {
  header('location:logout.php');
  }
  else{
    $errors = [];
    $cid=$_GET['editid'];
    
    // Check if any season is active
    $checkActiveSeason = $pdoConnection->query("SELECT * FROM season WHERE state = 'on' || state= 'ON'");
    if ($checkActiveSeason->rowCount() > 0) {
        $activeSeason = true;
    }
    if(isset($_POST['submit']))
    {
      $delete_image = $pdoConnection -> query("select image from season where ID='$cid'");
      $image_data = $delete_image-> fetch(PDO:: FETCH_ASSOC);
      $exist_image_name = $image_data['image'];

      $Name=trim($_POST['Name']);
      $alphapet_NumPattern = '/^([a-zA-Z0-9\s]+|[\p{Arabic}0-9\s]+)$/u';
      if (empty($Name)){
        $errors['Name'] = "Please enter a season name";
      }elseif (!preg_match($alphapet_NumPattern, $Name)){
        $errors['Name']='Name must be letters only';
      }

      $State = trim($_POST['seasonstate']);
      if (empty($State)){
        $errors['seasonstate'] = "Please choose state for the season";
      }

      $stDate=trim($_POST['startdate']);
      if(empty($stDate) || $stDate == ""){
        $stDate = null;
      }
      $notes = trim($_POST['notes']);
      if (empty($notes)) {
          $notes = null; 
      }
      
      $allowed_extensions = ["jpg", "jpeg", "png", "gif"];
   
    function uploadImages($imageFile, $name) {
      if ($imageFile["name"] != "") {
        $extension = strtolower(pathinfo($imageFile["name"], PATHINFO_EXTENSION));
              $newImageName =  $name. '-poster.' . $extension;
              move_uploaded_file($imageFile["tmp_name"], "images/" . $newImageName);
              return $newImageName;
          } else {
            return null;
          }
      
      return null;
    }

      $seasonImg = $_FILES['image']['name'];
      if($seasonImg!=""){
        $extension = strtolower(pathinfo($seasonImg, PATHINFO_EXTENSION));
        // Validation for allowed extensions
        if (!in_array($extension, $allowed_extensions)) {
          $errors['imageinvalid'] = "Image Extension not acceptable use one of (jpg, jpeg, png, gif)";
        }

      }else {
        $seasonImg = $exist_image_name;
      }

      if (empty($errors)) {
          if ($seasonImg != $exist_image_name) {
            $seasonImg = uploadImages($_FILES["image"],$Name);
        }        
        $query = $pdoConnection->query("UPDATE season SET name='$Name',state='$State',startDate='$stDate',image='$seasonImg' , notes='$notes' WHERE ID = $cid;");


          if ($query) {
            if ($seasonImg != $exist_image_name) {unlink("images/$exist_image_name");}
            if($State == 'off' || $State== 'OFF'){
                $groupstate = $pdoConnection -> query(" UPDATE groups SET state= 'closed' WHERE seasonId = $cid ;") ;
                echo "<script>alert('Season Data has been Updated. all groups related to this season are now closed.');</script>";
            }else{
            echo "<script>alert('Season Data has been Updated.');</script>";
            }
            echo "<script>window.location.href ='viewall_seasons.php'</script>";
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
  
  <title>Edit Season | Peace Sports School </title>

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
            <h3 class="page-header"><i class="fa fa-file-text-o"></i>Edit Season</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Season</li>
              <li><i class="fa fa-file-text-o"></i>Edit Season</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
               Update Season Details
              </header>
              <div class="panel-body">
              <form class="form-horizontal " method="post" action="" enctype="multipart/form-data">
              <?php
                      $query=$pdoConnection-> query("select * from season where ID='$cid'");
                      $row=$query ->fetch(PDO:: FETCH_ASSOC);
                      if($row > 0) {
                      ?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Season Name</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="Name" name="Name"  type="text" value="<?php  echo $row['name'];?>">
                      <?php if( isset($errors['Name'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['Name'] ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Season State</label>
                    <div class="col-sm-10">
                        <input type="radio" id="seasonstate-on" name="seasonstate" value="on" style="margin:7px" <?php if ($row['state'] === 'on') echo 'checked'; ?>> Active  <span style="margin: 30px"></span>
                        <input type="radio" id="seasonstate-off" name="seasonstate" value="off" style="margin:7px" <?php if ($row['state'] === 'off') echo 'checked'; ?>> Inactive
                        <span id="state-note" style="color: #3d557d ;display:block;text-align:left"></span>
                        <?php if(isset($errors['seasonstate'])) { ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['seasonstate'] ?></span>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Start Date</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="startDate" name="startdate"  type="date" value="<?php  echo $row['startDate'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Season Poster</label>
                    <div class="col-sm-10">
                      <img src="images/<?php echo $row['image'];?>" width="150" height="200" value="<?php  echo $row['image'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Change Poster</label>
                    <div class="col-sm-10">
                       <input type="file" class="form-control" name="image" id="image" value="">
                       <?php if( isset($errors['imageinvalid'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['imageinvalid'] ?></span>
                       <?php } ?>
                      </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Notes</label>
                    <div class="col-sm-10">
                    <textarea class="form-control" name="notes"><?php echo htmlspecialchars($row['notes']); ?></textarea>
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
  <!-- allow only one active season-->
  <script>
    window.onload = function () {
        let activeSeason = <?php echo $activeSeason ? 'true' : 'false'; ?>; 
        let currentSeasonState = '<?php echo $row['state']; ?>'; 
        let stateNote = document.getElementById('state-note');
        let stateOn = document.getElementById('seasonstate-on');

        // Check if there is an active season and if it's not the current season being edited
        if (activeSeason && currentSeasonState !== 'on') {
            stateOn.disabled = true; // Disable activating another season
            stateNote.innerHTML = 'Another season is active. Deactivate the active season to activate this one.';
        }
    }
</script>


</body>

</html>
<?php  } ?>
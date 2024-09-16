<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sportadmission']==0)) {
  header('location:logout.php');
  }
  else{
    $errors = [];
    $cid=$_GET['editid'];
    

    if(isset($_POST['submit']))
    {
      $delete_image = $pdoConnection -> query("select image from season where ID='$cid'");
      $image_data = $delete_image-> fetch(PDO:: FETCH_ASSOC);
      $image_name = $image_data['image'];

      $Name=trim($_POST['Name']);
      if (empty($Name)){
        $errors['Name'] = "Please enter a season name";
      }

      $State = trim($_POST['seasonstate']);
      if (empty($State)){
        $errors['seasonstate'] = "Please choose state for the season";
      }

      $stDate=trim($_POST['startdate']);
      if(empty($stDate)){
        $stDate = null;
      }
      $seasonImg = $_FILES['image']['name'];
      if (empty($seasonImg)){
        $errors['image'] = "Please upload season image";
      }

      if($seasonImg!=""){
        $extension = strtolower(pathinfo($seasonImg, PATHINFO_EXTENSION));
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        // Validation for allowed extensions
        if (!in_array($extension, $allowed_extensions)) {
          $seasonImg = $image_name ;
        }
      }
      if (empty($errors)) {
        if(!empty($seasonImg)){
          $renameSeasonImg = md5($seasonImg) . '.' . $extension;
        move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $renameSeasonImg);
          // $query = $pdoConnection->query("INSERT INTO season (name, state, startDate, image) VALUES ('$Name', '$State', '$stDate', '$renameSeasonImg')");
          $query = $pdoConnection->query("UPDATE season SET name='$Name',state='$State',startDate='$stDate',image='$renameSeasonImg' WHERE ID = $cid;");
        }else{
          $query = $pdoConnection->query("UPDATE season SET name='$Name',state='$State',startDate='$stDate' WHERE ID = $cid;");
        }
          if ($query) {
            if(!empty($seasonImg)){unlink("images/$image_name");}
            echo "<script>alert('Season Data has been Updated.');</script>";
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
  
  <title>Edit Season | Peace Sports School Admission System</title>

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
                    <label class="col-sm-2 control-label">Season State:</label>
                    <div class="col-sm-10">
                      <input class="" id="seasonstate" name="seasonstate"  type="radio" value="on" style="margin:7px" <?php if($row['state']==='on'){ echo 'checked';}?> >Active <span style="margin: 30px"></span>
                      <input class="" id="seasonstateoff" name="seasonstate"  type="radio" value="off" style="margin:7px" <?php if($row['state']==='off'){ echo 'checked';}?> >Inactive 
                      <?php if( isset($errors['seasonstate'])){ ?>
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
                       <?php if( isset($errors['image'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['image'] ?></span>
                       <?php } ?>
                       <?php if( isset($errors['imageinvalid'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['imageinvalid'] ?></span>
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
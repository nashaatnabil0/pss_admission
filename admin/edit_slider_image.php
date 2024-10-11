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
    

    if(isset($_POST['submit']))
    {
      $delete_image = $pdoConnection -> query("select image from slider_images where ID='$cid'");
      $image_data = $delete_image-> fetch(PDO:: FETCH_ASSOC);
      $exist_image_name = $image_data['image'];

    $title=trim($_POST['title']);
    $alphapet_NamePattern = '/^([a-zA-Z0-9\s]+|[\p{Arabic}0-9\s]+)$/u';
    if (empty($title)){
      $errors['title'] = "Please enter a title for the image.";
    }elseif (!preg_match($alphapet_NamePattern, $title)){
      $errors['title']='The title must be letters only'; 
    }
    $caption= trim($_POST['caption']);
    if(empty($caption)){
       $caption = null;
    }

    $allowed_extensions = ["jpg", "jpeg", "png", "gif"];

    function uploadImages($imageFile, $title) {
      if ($imageFile["name"] != "") {
        $extension = strtolower(pathinfo($imageFile["name"], PATHINFO_EXTENSION));
              $newImageName =  $title. '-slider.' . $extension;
              move_uploaded_file($imageFile["tmp_name"], "images/" . $newImageName);
              return $newImageName;
          } else {
            return null;
          }
      
      return null;
    }

      $Img = $_FILES['image']['name'];
      if($Img!=""){
        $extension = strtolower(pathinfo($Img, PATHINFO_EXTENSION));
        // Validation for allowed extensions
        if (!in_array($extension, $allowed_extensions)) {
          $errors['imageinvalid'] = "Image Extension not acceptable use one of (jpg, jpeg, png, gif)";
        }

      }else {
        $Img = $exist_image_name;
      }

      if (empty($errors)) {
          if ($Img != $exist_image_name) {
            $Img = uploadImages($_FILES["image"],$title);
        }        
        $query = $pdoConnection->query("UPDATE slider_images SET image='$Img', title='$title', caption='$caption' WHERE ID = $cid;");

          if ($query) {
            if ($Img != $exist_image_name) {unlink("images/$exist_image_name");}
            echo "<script>alert('Image has been Updated.');</script>";
            echo "<script>window.location.href ='viewall_slider_image.php'</script>";
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
  
  <title>Edit Home Page Slider Image | Peace Sports School</title>

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
            <h3 class="page-header"><i class="fa fa-file-text-o"></i>Edit Image</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Image</li>
              <li><i class="fa fa-file-text-o"></i>Edit Image</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
               Update Image Details
              </header>
              <div class="panel-body">
              <form class="form-horizontal " method="post" action="" enctype="multipart/form-data">
              <?php
                      $query=$pdoConnection-> query("select * from slider_images where ID='$cid'");
                      $row=$query ->fetch(PDO:: FETCH_ASSOC);
                      if($row > 0) {
                      ?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Image title</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="title" name="title"  type="text" value="<?php  echo $row['title'];?>">
                      <?php if( isset($errors['title'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['title'] ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Image</label>
                    <div class="col-sm-10">
                      <img src="images/<?php echo $row['image'];?>" width="150" height="200" value="<?php  echo $row['image'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Change Image</label>
                    <div class="col-sm-10">
                       <input type="file" class="form-control" name="image" id="image" value="">
                       <?php if( isset($errors['imageinvalid'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['imageinvalid'] ?></span>
                       <?php } ?>
                      </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Caption</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="caption"><?php echo htmlspecialchars($row['caption']); ?></textarea>
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
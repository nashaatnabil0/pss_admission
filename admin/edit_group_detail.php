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
     
      $title = trim($_POST['title']);
      if (empty($title)) {
        $errors['title'] = "Please enter a group name";
      }
      $days = trim($_POST['days']);
      if (empty($days)) {
        $errors['days'] = "Please enter the training days";
      }
      
      $timing = trim($_POST['timing']);
  
      if (empty($timing)) {
        $errors['timing'] = "Please enter a Training time";
      }
      
      $minAge = trim($_POST['minAge']);
      if (empty($minAge)) {
        $errors['minAge'] = "Minimum Age can't be empty";
      }
     
      $maxAge = trim($_POST['maxAge']);
      if (empty($maxAge)) {
        $errors['maxAge'] = "Maximum Age can't be empty";
      }
      
      $trainer = trim($_POST['trainer']);
      $sport = $_POST['sport'];
      if (empty($sport)) {
        $errors['sport'] = "Please select a sport";
      }
      $season = trim($_POST['season']);
      if (empty($season)) {
        $errors['season'] = "Please select a season";
      }
      $price = trim($_POST['price']);
      if (empty($season)) {
        $errors['price'] = "Plese enter a price ";
      }
      $capacity = trim($_POST['capacity']);
      if (empty($capacity)) {
        $errors['price'] = "Capacity can't be empty";
      }
      $place = trim($_POST['place']);

      if (empty($errors)) {
        if ($place == "") {
          $query = $pdoConnection->query("UPDATE groups SET Title='$title',days='$days',Timeslot='$timing',minAge='$minAge',maxAge='$maxAge',trainerId='$trainer',sportId='$sport',seasonId='$season',price='$price',capacity='$capacity' WHERE ID = '$cid';");
        }else{
          $query = $pdoConnection->query("UPDATE groups SET Title='$title',days='$days',Timeslot='$timing',minAge='$minAge',maxAge='$maxAge',trainerId='$trainer',sportId='$sport',seasonId='$season',price='$price',capacity='$capacity', place = '$place' WHERE ID = '$cid';");
        }
              if ($query) {
                  echo "<script>alert('Group has been Updated.');</script>";
                  echo "<script>window.location.href ='viewall_groups.php'</script>";
              } else {
                  echo "<script>alert('Something Went Wrong. Please try again.');</script>";
                }
          }
      }
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  
  <title>Edit Group | Peace Sports School Admission System</title>

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
            <h3 class="page-header"><i class="fa fa-file-text-o"></i>Add Group Details</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Group</li>
              <li><i class="fa fa-file-text-o"></i>Add Groups Details</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
              Edit Group Details
              </header>
              <div class="panel-body">
                <form class="form-horizontal " method="post" action="" enctype="multipart/form-data" >
                      <?php
                      $query=$pdoConnection-> query("select * from groups where ID='$cid'");
                      $row=$query ->fetch(PDO:: FETCH_ASSOC);
                      if($row>0){
                      ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Group Title</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="title" name="title"  type="text"  placeholder= "Group Name" value="<?php  echo $row['Title'];?>"/>
                      <?php if(isset($_POST['submit']) && isset($errors['title'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['title'] ?></span>
                       <?php } ?>
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Training Days</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="days" name="days"  type="text" placeholder="sat- tue" value="<?php  echo $row['days'];?>"/>
                      <?php if(isset($_POST['submit']) && isset($errors['days'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['days'] ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Training Place</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="place" name="place"  type="text" value="<?php  echo $row['place'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Timing</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="timing" name="timing" type="text" value="<?php  echo $row['Timeslot'];?>" placeholder="8:00 pm">
                      <?php if(isset($_POST['submit']) && isset($errors['timing'])) { ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['timing']; ?></span>
                        <?php } ?>
                      </div>
                    </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Min Age</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="minAge" name="minAge" type="number" value="<?php  echo $row['minAge'];?>">
                      <?php if(isset($_POST['submit']) && isset($errors['minAge'])) { ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['minAge']; ?></span>
                        <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Max Age</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="maxAge" name="maxAge" type="number" value="<?php  echo $row['maxAge'];?>">
                      <?php if(isset($_POST['submit']) && isset($errors['maxAge'])) { ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['maxAge']; ?></span>
                        <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Trainer</label>
                    <div class="col-sm-10">
                      <select class="form-control m-bot15" name="trainer" id="trainer">
                        <option value="">Choose a trainer</option>
                          <?php $query=$pdoConnection-> query("select * from trainers");
                            while($row1=$query ->fetch(PDO:: FETCH_ASSOC))
                            {
                            ?>    
                            <option value="<?php echo $row1['ID'];?>" <?php if($row1['ID'] == $row['trainerId']){ echo "selected='selected'";}?>><?php echo $row1['name'];?></option>
                            <?php } ?> 
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Sport</label>
                    <div class="col-sm-10">
                      <select class="form-control m-bot15" name="sport" id="sport">
                        <option value="">Choose a sport</option>
                          <?php $query=$pdoConnection-> query("select * from sport");
                            while($row2=$query ->fetch(PDO:: FETCH_ASSOC))
                            {
                            ?>    
                          <option value="<?php echo $row2['ID'];?>" <?php if($row2['ID'] == $row['sportId']){ echo "selected='selected'";}?>><?php echo $row2['name'];?></option>
                            <?php } ?> 
                      </select>
                      <?php if(isset($_POST['submit']) && isset($errors['sport'])) { ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['sport']; ?></span>
                        <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Season</label>
                    <div class="col-sm-10">
                      <select class="form-control m-bot15" name="season" id="season">
                        <option value="">Choose a Season</option>
                          <?php $query=$pdoConnection-> query("select * from season where season.state = 'on' ");
                            while($row3=$query ->fetch(PDO:: FETCH_ASSOC))
                            {
                            ?>    
                          <option value="<?php echo $row3['ID'];?>" <?php if($row3['ID'] == $row['seasonId']){ echo "selected='selected'";}?>><?php echo $row3['name'];?></option>
                            <?php } ?> 
                      </select>
                      <?php if(isset($_POST['submit']) && isset($errors['season'])) { ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['season']; ?></span>
                        <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Subscription Fees</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="price" name="price" type="number" value="<?php  echo $row['price'];?>" min=0>
                      <?php if(isset($_POST['submit']) && isset($errors['price'])) { ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['price']; ?></span>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="form-group">
                    <label class="col-sm-2 control-label">Capacity</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="capacity" name="capacity" type="number" value="<?php  echo $row['capacity'];?>">
                      <?php if(isset($_POST['submit']) && isset($errors['capacity'])) { ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['capacity']; ?></span>
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
<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sportadmission']==0)) {
  header('location:logout.php');
  }
else {  
  $errors = [];
  $cid=$_GET['editid'];

   // Fetch all trainee NIDs from the database
   $stmt = $pdoConnection->query("SELECT NID, Name FROM trainees");
   $trainees = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all NIDs and names

  if(isset($_POST['submit'])){
    $traineeNID = $_POST['traineeNID'];
    // Validate traineeNID
    // Check if the trainee exists in the 'trainees' table and has no existing enrollment
    $stmt = $pdoConnection->query(" SELECT COUNT(*) FROM trainees 
                                      LEFT JOIN enrollment ON trainees.NID = enrollment.traineeNID 
                                      WHERE trainees.NID = $traineeNID AND (enrollment.state IS NULL OR enrollment.state IN ('off', 'waiting'))");
    $exists = $stmt->fetchColumn();

    $group = $_POST['group'];
    if (empty($group)) {
      $errors['group'] = "Please select a group";
    }

    $pymntPlan = $_POST['pymntplan'];
    if (empty($pymntPlan)) {
      $errors['pymntplan'] = "Please select a payment plan";
    }

    $enrollstate = $_POST['enrollstate'];
    if (empty($enrollstate)) {
      $errors['enrollstate'] = "Please select an enrollment state";
    }

    $enrolldate = $_POST['enrolldate'];
    if ($enrolldate == "") {
        $enrolldate = date('Y-m-d') ;
    }else{
      $enrolldate = $_POST['enrolldate'];
    }
    
    $discount = $_POST['discount'];
    if ($discount == "") {
      $discount = null;
    }
    
    if (empty($errors)){
      
    $query2 = $pdoConnection->query("UPDATE enrollment SET groupId ='$group', paymentPlan ='$pymntPlan', state='$enrollstate', date='$enrolldate', discount='$discount' where ID = '$cid'");
    
          if ($query2) {
              echo "<script>alert('Enrollment details have been updated.');</script>";
              echo "<script>window.location.href ='viewall_enrollments.php'</script>";
          } else {
              echo "<script>alert('Something Went Wrong. Please try again.');</script>";
            }
      }
 }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  
  <title>Edit Enrollment | Peace Sports School Admission System</title>

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
            <h3 class="page-header"><i class="fa fa-file-text-o"></i>Update Enrollment Details</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Update Enrollment</li>
              <li><i class="fa fa-file-text-o"></i>Update Enrollment Details</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
               Update Enrollment Details
              </header>
              <div class="panel-body">
              <form class="form-horizontal " method="post" action="" enctype="multipart/form-data" novalidate>
              <?php
              $query=$pdoConnection-> query("select * from enrollment where ID='$cid'");
                      $row2=$query ->fetch(PDO:: FETCH_ASSOC);
                      if($row2 > 0) {
                      ?>  
              <!-- Trainee National ID input with datalist -->
                <div class="form-group">
                <label class="col-sm-2 control-label">Trainee National ID</label>
                <div class="col-sm-10">
                  <input class="form-control" id="searchTrainee" name="traineeNID" type="text" value="<?php  echo $row2['traineeNID']; ?>" placeholder="Type the national ID number" list="traineeListOptions" readonly/>
                  <datalist id="traineeListOptions">
                    <?php foreach ($trainees as $trainee) { ?>
                      <option value="<?php echo $trainee['NID']; ?>">
                        <?php echo $trainee['NID'] . " - " . $trainee['Name']; ?>
                      </option>
                    <?php } ?>
                  </datalist>
                  <?php if (isset($_POST['submit']) && isset($errors['traineeNID'])){ ?>
                    <span style="color:red;display:block;text-align:left"><?php echo $errors['traineeNID']; ?></span>
                  <?php } ?>
                  <?php if (isset($_POST['submit']) && isset($errors['traineeNIDinvalid'])) { ?>
                    <span style="color:red;display:block;text-align:left"><?php echo $errors['traineeNIDinvalid']; ?></span>
                  <?php } ?>
                </div>
                </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Group</label>
                    <div class="col-sm-10">
                      <select class="form-control m-bot15" name="group" id="group">
                        <option value="" >Choose a group</option>
                          <?php $query=$pdoConnection-> query("select * from groups");
                            while($row=$query ->fetch(PDO:: FETCH_ASSOC))
                            {
                            ?> 
                          <option value="<?php echo $row['ID'];?>" <?php if($row2['groupId'] == $row['ID']){ echo "selected='selected'";}?> ><?php echo $row['Title'];?></option>
                            <?php } ?> 
                      </select>
                      <?php if (isset($_POST['submit']) && isset($errors['group'])){ ?>
                    <span style="color:red;display:block;text-align:left"><?php echo $errors['group']; ?></span>
                  <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Payment Plan</label>
                    <div class="col-sm-10">
                      <input class="" id="paymentPlan" name="pymntplan"  type="radio" value="full" <?php if($row2['paymentPlan'] === 'full') {echo 'checked';} ?>  style="margin:7px" required> Full <span style="margin: 35px"></span>
                      <input class="" id="paymentPlan" name="pymntplan"  type="radio" value="installment" <?php if($row2 ['paymentPlan'] === 'installment') {echo 'checked';} ?> style="margin:7px" required > Installments
                     <?php if (isset($_POST['submit']) && isset($errors['pymntplan'])){ ?>
                     <span style="color:red;display:block;text-align:left"><?php echo $errors['pymntplan']; ?></span>
                     <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Discount</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="discount" name="discount"  type="text" value="<?php echo $row2['discount'] === null ? 0 : $row2['discount']; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Enrollment State:</label>
                    <div class="col-sm-10">
                    <input class="" id="enrolltate" name="enrollstate"  type="radio" value="on" <?php if($row2['state']==='on'){echo 'checked';} ?> style="margin:7px" required > Active <span style="margin: 35px"></span>
                    <input class="" id="enrollstateoff" name="enrollstate"  type="radio" value="off" <?php if($row2['state']==='off'){echo 'checked';} ?> style="margin:7px" required> Inactive  <span style="margin: 35px"></span>
                    <input class="" id="enrollstatewait" name="enrollstate"  type="radio" value="waiting" <?php if($row2['state']==='waiting'){echo 'checked';} ?> style="margin:7px" required> Waiting   
                    <?php if (isset($_POST['submit']) && isset($errors['enrollstate'])){ ?>
                    <span style="color:red;display:block;text-align:left"><?php echo $errors['enrollstate']; ?></span>
                  <?php } ?>
                  </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Enrollment Date</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="enrolldate" name="enrolldate" type="date" value="<?php echo $row2['date']?>">
                      </div>
                    </div>
                 <p style="text-align: center;"> <button type="submit" name="submit" class="btn btn-primary">Submit</button></p>
                </form>
                <?php } ?>
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
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sportadmission']==0)) {
  header('location:logout.php');
  }
  else{

if(isset($_POST['submit']))
  {
    
    $name=$_POST['name'];
    $mobnum=$_POST['mobnum'];
    $spID=$_POST['SportID'];
    $eid=$_GET['editid'];
    if($spID==""){
      $query = $pdoConnection -> query("update trainers SET name='$name', MobileNumber='$mobnum', sportId= NULL where ID='$eid'");
    }else{
      $query = $pdoConnection -> query("update trainers SET name='$name', MobileNumber='$mobnum', sportId= '$spID' where ID='$eid'");
    }
    
    if ($query) {
      echo "<script>alert('Trainer details has been updated.');  location.href='viewall_trainers.php'</script>";
  }
  else
    {
      echo "<script>alert('Something Went Wrong. Please try again.');</script>";
    }

  }

  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  
  <title>Edit Trainer | Peace Sports School Admission System</title>

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
            <h3 class="page-header"><i class="fa fa-file-text-o"></i>Update Trainer Detail</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Trainers</li>
              <li><i class="fa fa-file-text-o"></i>Trainer Detail</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
              Trainer Detail
              </header>
              <div class="panel-body">
                <form class="form-horizontal " method="post" action="">
                  <?php
                    $ret= $pdoConnection-> query("SELECT * FROM trainers where ID='$cid'");
                    while ($row=$ret->fetch(PDO:: FETCH_ASSOC)) {
                  ?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="name" name="name"  type="text" required="true" value="<?php  echo $row['name'];?>">
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="col-sm-2 control-label">Mobile Number</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="mobnum" maxlength="11" name="mobnum"  type="text" required="true" value="<?php  echo '0'.$row['MobileNumber'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Sport</label>
                    <div class="col-sm-10">
                      <select class="form-control m-bot15" name="SportID" id="SportID">
                        <option value="">Choose trainer</option>
                          <?php $query=$pdoConnection-> query("select * from sport");
                            while($row1=$query ->fetch(PDO:: FETCH_ASSOC)){?>    
                            <option value="<?php echo $row1['ID'];?>" <?php if($row1['ID'] == $row['sportId']){ echo "selected='selected'";}?> > <?php echo $row1['name'];?></option>
                            <?php } ?> 
                      </select>
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
<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sportadmission']==0)) {
  header('location:logout.php');
  }
else {
  $errors = [];
  if(isset($_POST['submit'])){
    $name = $_GET['name'];
    if (empty($name)) {
      $errors['name'] = "Name cannot be empty";
  }
  
      $enrollId = $_GET['editid'];
      $fullprice = $_POST['price'];
      $totalpaid = ['totalpaid']; //calculated
      $remaining = ['remaining']; //calculated
      $discount = $_POST['discount'];
      $pymntAmount = ['amount'];
      $pymntMethod = ['method'];
      
      $pymntdate = $_POST['date'];
      
      if ($pymntdate == "") {
          $pymntdate = date('Y-m-d') ;
      }else{
        $pymntdate = $_POST['date'];
      }

      $addedby = $_POST['adminName'];
      $notes = $_POST['notes'];

          $query = $pdoConnection->query("INSERT INTO payment ( enrollmentId, paymentAmount, paymentMethod, date, userId, notes) VALUES ('$enrollId', '$pymntAmount', '$pymntMethod', '$pymntdate', '$addedby', '$notes')");

          if ($query) {
              echo "<script>alert('Payment has been added.');</script>";
              echo "<script>window.location.href ='make_payment.php'</script>";
          } else {
              echo "<script>alert('Something Went Wrong. Please try again.');</script>";
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
            <h3 class="page-header"><i class="fa fa-file-text-o"></i>Add Payment </h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Payment</li>
              <li><i class="fa fa-file-text-o"></i>Add Payment</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
             Add Payment
              </header>
              <div class="panel-body">
                <form class="form-horizontal " method="post" action="" enctype="multipart/form-data" >
                <?php
              $traineeinfo= $pdoConnection->query(" SELECT
                                                      t.Name , e.traineeNID, g.price , e.discount 
                                                    from
                                                    enrollment e
                                                    join
                                                    trainees t on e.traineeNID = t.NID
                                                    join 
                                                    'group' g on e.groupId = g.ID
                                                    where 
                                                    e.ID = $enrollId ;
                                                    ");
                              $cnt=1;
                              while ($row2=$traineeinfo-> fetch(PDO:: FETCH_ASSOC)) { ?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="name" name="name"  type="text" value = "<?php echo $row2['t.Name'];?>"/> 
                      <?php if( $_POST['submit'] && isset($errors['name'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['name'] ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Subscription Fees</label>
                    <div class="col-sm-10">
                      <input class=" form-control" id="price" name="price" type="text" value = "<?php echo $row2['g.price'];?>" readonly >
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Discount</label>
                    <div class="col-sm-10">
                      <input class=" form-control" id="discount" name="discount" type="text" value = "<?php echo $row2['e.discount'];?>" readonly>
                    <?php}?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Total Paid Amount </label>
                    <div class="col-sm-10">
                      <input class=" form-control" id="totalpaid" name="totalpaid" type="text" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Remaining Amount</label>
                    <div class="col-sm-10">
                      <input class=" form-control" id="remaining" name="remaining" type="text" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Payment Amount</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="amount" name="amount"  type="number" value=''>
                      <?php if($_POST['submit']){ if(isset($errors['amount'])){  ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['amount']; ?></span>
                        <?php }} ?>
                      </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Payment Method</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="method" name="method" type="text">
                      <?php if($_POST['submit'] && isset($errors['mothod'])) { ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['method']; ?></span>
                        <?php } ?>
                      </div>
                    </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Payment Date</label>
                    <div class="col-sm-10">
                    <input class="form-control" id="date" name="date" type="date">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Payment Added by:</label>
                    <?php
                    $adminid=$_SESSION['sportadmission'];
                                $ret=$pdoConnection-> query("select * from users where ID='$adminid'");
                                $cnt=1;
                                while ($row=$ret ->fetch(PDO:: FETCH_ASSOC)) {
                                ?>
                    <div class="col-sm-10">
                      <input class=" form-control" id="adminName" name="adminName" type="text" value="<?php  echo $row['name'];?>" readonly>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Notes</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="notes"></textarea>
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

  <!-- get the current date -->
  <script>
  var dateElement = document.getElementById("date");
  var today = new Date();

  // put the date in the defult format YYYY-MM-DD
  var formattedDate = today.getFullYear() + '-' +
                      ('0' + (today.getMonth() + 1)).slice(-2) + '-' + 
                      ('0' + today.getDate()).slice(-2);

  // Set the value of the input as today's date
  dateElement.value = formattedDate;  
</script>



</body>

</html>
<?php  } ?>
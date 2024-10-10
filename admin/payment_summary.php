<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sportadmission']==0)) {
  header('location:logout.php');
  }
else {
// Check if the clear_session flag is set and clear only the payment_summary
if (isset($_GET['clear_session']) && $_GET['clear_session'] == 'true') {
  unset($_SESSION['payment_summary']);
  header('Location: make_payment.php'); // Redirect back to make paymrnt page after clearing
  exit;
}

if (!isset($_SESSION['payment_summary'])) {
    header('Location: add_payment.php');     // Redirect back if there's no summary
    exit;
}

$summary = $_SESSION['payment_summary'];
//echo $summary['amount_of_payment'];
//die;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Payment Summary| Peace Sports School </title>

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
  <!-- style to print the form only -->
  <style>
@media print {
  /* Hide all unnecessary elements */
  header, footer , Title {
    display: none !important; 
  }

  /* Show the form contents */
  .panel-body {
    display: block !important; /* Ensure the panel body is displayed */
  }

  /* hide all inputs but show their values */
  input[type="text"], input[type="number"], input[type="date"] {
    border: none; 
    background: none; 
    color: black; 
    display: block; 
    width: auto; 
  }

  button#print ,  button#back {
    display: none !important;
  }
  .sidebar {
    display: none !important;
  }
  .breadcrumb {
    display: none !important;
  }
}
</style>


</head>

<body>


<!-- container section start -->
  <section id="container" class="">
    <!--header start-->
    <?php include_once('includes/header.php');?>
    <!--header end-->

    <!--sidebar start-->
  <div id=sidebar> 
     <?php include_once('includes/sidebar.php');?>
    <!--sidebar end-->
</div>
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-file-text-o"></i>Payment Summary</h3>
            <ol class="breadcrumb" id="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Payment</li>
              <li><i class="fa fa-file-text-o"></i>Payment Summary</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
             Payment Summary
              </header>
              <div class="panel-body">
                <form class="form-horizontal " method="POST" action="" enctype="multipart/form-data" >
  
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="name" name="name"  type="text" value = "<?php echo $summary['name']; ?>" readonly/> 
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Group</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="group_details" name="group_details"  type="text" value = "<?php echo $summary['group_details'] ; ?>" readonly/> 
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Payment Amount</label>
                    <div class="col-sm-10">
                    <input class="form-control" id="amount_of_payment" name="amount_of_payment"  type="number" value = "<?php echo $summary['amount_of_payment'] ; ?>" readonly/> 
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Payment Method</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="method" name="method"  type="text" value=" <?php echo $summary['payment_method']; ?>" readonly />
                      </div>
                    </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Payment Date</label>
                    <div class="col-sm-10">
                    <input class="form-control" id="date" name="date" type="date" value="<?php echo $summary['payment_date']; ?>" readonly />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Subscription Fees</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="price" name="price"  type="text" value = "<?php echo $summary['total_fees']; ?>" readonly /> 
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Discount</label>
                    <div class="col-sm-10">
                      <input class=" form-control" id="discount" name="discount" type="text" value = "<?php echo $summary['discount']; ?>" readonly />
                    </div>
                  </div>
                  <div class="form-group">
                  <label class="col-sm-2 control-label">Fees After Discount</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="discprice" name="discprice" type="text" value="<?php echo $summary['fees_after_discount']; ?>" readonly />
                  </div>
                </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Total Paid Amount </label>
                    <div class="col-sm-10">

                      <input class=" form-control" id="totalpaid" name="totalpaid" type="text"  value="<?php echo $summary['total_paid_amount']; ?>" readonly />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Remaining Amount</label>
                    <div class="col-sm-10">
                      <input class=" form-control" id="remaining" name="remaining" type="text" value="<?php echo $summary['remaining_amount']; ?>" readonly />
                    </div>
                  </div>
                  <p style="text-align: center;"> <button type="submit" name="print" id= "print" onclick="window.print()" class="btn btn-primary">Print</button></p>
                 <p style="text-align: center;"> <button type="button" name="back" id= "back" class="btn btn-primary" onclick="window.location.href='add_payment.php'">Back</button></p>
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

  <script>
  // Trigger session clearing when the page is closed
  window.onbeforeunload = function() {
    if (!window.reloading) {
      window.location.href = 'payment_summary.php?clear_session=true';
    }
  };

  // Trigger session clearing after the page is printed
  window.onafterprint = function() {
    window.location.href = 'payment_summary.php?clear_session=true';
  };

  // Prevent session clearing on page reload
  window.onload = function() {
    window.reloading = true;
  };
</script>


</body>

</html>
<?php  } ?>
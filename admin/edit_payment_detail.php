<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sportadmission']==0)) {
  header('location:logout.php');
}
else{

$errors = [];
$paymntId = $_GET['editid'];
//var_dump($enrollId); die;
$pymntDataquery = $pdoConnection->query("SELECT * FROM payment WHERE ID = $paymntId;" );
$pymntData = $pymntDataquery->fetch(PDO:: FETCH_ASSOC);
$enrollId = $pymntData['enrollmentId'];

$formSubmitted = $_SERVER["REQUEST_METHOD"] == "POST";
if ($formSubmitted) {
    // Validate enroll ID

    $name = trim($_POST['name']);
    if (empty($name)) {
        $errors['name'] = "Name cannot be empty";
    }

    $pymntAmount = trim($_POST['amount']);
    if (empty($pymntAmount)) {
        $errors['amount'] = "Payment amount cannot be empty";
    }

    $remainingAmount =trim( $_POST['remaining']);
    $feesAfterDiscount = trim($_POST['discprice']);
    if ($pymntAmount > $feesAfterDiscount) {
       $errors['amount'] = "Payment amount cannot exceed the fees after discount value";
      }

    $pymntMethod = trim($_POST['method']);
    if (empty($pymntMethod)) {
        $errors['method'] = "Payment method is required";
    }
    

    $pymntdate = trim($_POST['date']);
    if (empty($pymntdate)) {
        $pymntdate = date('Y-m-d');
    }

    $addedby = trim($_POST['adminName']);
    $adminid = $_SESSION['sportadmission'];
    $stmt2 = $pdoConnection->query("SELECT * FROM users WHERE ID = $adminid;" );
    $exists = $stmt2->fetchall();
    if (!$exists) {
        $errors['addedby'] = "Admin not found";
    }

    $notes = trim($_POST['notes']);
    if (empty($notes)) {
        $errors['notes'] = "Please leave a note about your edit" ;
    }

    $discount = $_POST['discount'];
    $groupDestails = $_POST['groupDetails'];
    $name = $_POST['name'];
    $subscriptionFees = $_POST['price'];

    // Only proceed with inserting into the database if there are no errors
    if (empty($errors)) {
        $query = $pdoConnection->query(" UPDATE payment SET  paymentAmount = '$pymntAmount', paymentMethod = '$pymntMethod', date = '$pymntdate', userId ='$adminid', notes ='$notes' WHERE ID = '$paymntId'");
        if ($query) {
            // Calculate remaining amount after the new payment
            $paidquery = $pdoConnection->query("SELECT SUM(paymentAmount) AS totalPaidAmount FROM payment WHERE enrollmentId = $enrollId;");
            $row4 = $paidquery->fetch(PDO::FETCH_ASSOC);
            $totalPaidAmount = $row4['totalPaidAmount'] ? $row4['totalPaidAmount'] : 0;

            $feesAfterDiscountQuery = $pdoConnection->query("SELECT g.price - COALESCE(e.discount, 0) AS feesAfterDiscount FROM enrollment e JOIN groups g ON e.groupId = g.ID WHERE e.ID = $enrollId;");
            $row3 = $feesAfterDiscountQuery->fetch(PDO::FETCH_ASSOC);
            $feesAfterDiscount = $row3['feesAfterDiscount'] ? $row3['feesAfterDiscount'] : 0;

            $remainingAmount = $feesAfterDiscount - $totalPaidAmount;

            // If remaining amount is 0, update the payment state to "complete"
            if ($remainingAmount <= 0) {
                $pdoConnection->query("UPDATE enrollment SET paymentState = 'complete' WHERE ID = $enrollId;");
            }
            if ($remainingAmount !=0 && $totalPaidAmount !=$feesAfterDiscount ) {
              $pdoConnection->query("UPDATE enrollment SET paymentState = 'partial' WHERE ID = $enrollId;");
          }

          // Use session to store the summary details
          $summary= $_SESSION['payment_summary'] = [
            'name' => $name,
            'group_details' => $groupDestails,
            'amount_of_payment' => $pymntAmount,
            'total_fees' => $subscriptionFees,
            'fees_after_discount' => $feesAfterDiscount,
            'total_paid_amount' => $totalPaidAmount,
            'remaining_amount' => $remainingAmount,
            'payment_method' => $pymntMethod,
            'discount' => $discount,
            'payment_date' => $pymntdate,
           ];

           echo "<script>alert('Payment has been updated.');</script>";
           echo "<script>window.location.href ='payment_summary.php'</script>";

        }else {
          echo "<script>alert('Something Went Wrong. Please try again.');</script>";
        } 
     }
}
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  
  <title>Edit Payment | Peace Sports School Admission System</title>

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
            <h3 class="page-header"><i class="fa fa-file-text-o"></i>Update Payment Details</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Update Payment</li>
              <li><i class="fa fa-file-text-o"></i>Update Payment Details</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
               Update Payment Details
              </header>
              <div class="panel-body">
              <form class="form-horizontal " method="POST" action="" enctype="multipart/form-data" >
                <?php
                $traineeinfo = $pdoConnection->query("SELECT t.Name, e.traineeNID, g.price, g.Title , g.minAge, g.maxAge, sp.name as sportName, s.name as seasonName, e.discount FROM enrollment e 
                                                                                                                                                                                  JOIN trainees t ON e.traineeNID = t.NID 
                                                                                                                                                                                  JOIN groups g ON g.ID = e.groupId 
                                                                                                                                                                                  JOIN sport sp ON g.sportId = sp.ID 
                                                                                                                                                                                  JOIN season s ON g.seasonId = s.ID  
                                                                                                                                                                                  WHERE e.ID = $enrollId;"); 
                $cnt=1;
                while ($row2=$traineeinfo-> fetch(PDO:: FETCH_ASSOC)) { ?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="name" name="name"  type="text" value = "<?php echo $row2['Name'];?>" readonly/> 
                      <?php if( $formSubmitted && isset($errors['name'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['name'] ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Group Details</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="groupDetails" name="groupDetails"  type="text" value = "<?php echo $row2['Title'] . " (" . $row2['minAge'] . " - " . $row2['maxAge'] . ") " . "- " . $row2['sportName'] . "- season: " . $row2['seasonName'] ; ?>" readonly/> 
                    </div>
                    </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Subscription Fees</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="price" name="price"  type="text" value = "<?php echo $row2['price'];?>" readonly/> 
                      <?php if( $formSubmitted && isset($errors['price'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['price'] ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Discount</label>
                    <div class="col-sm-10">
                      <input class=" form-control" id="discount" name="discount" type="text" value = "<?php if ($row2['discount']==NULL)echo 0;else echo $row2['discount'];?>" readonly>
                    <?php }?>
                    </div>
                  </div>
                  <div class="form-group">
                  <label class="col-sm-2 control-label">Fees After Discount</label>
                  <div class="col-sm-10">
                    <?php 
                      // Fetch the price after discount with default discount as 0 if it's NULL
                      $pricequery = $pdoConnection->query("SELECT g.price - COALESCE(e.discount, 0) AS 'difference' 
                                                          FROM enrollment e 
                                                          JOIN groups g ON e.groupId = g.ID 
                                                          WHERE e.ID = $enrollId;");
                      $row3 = $pricequery->fetch(PDO::FETCH_ASSOC);  // Fetch one result
                    ?>
                    <input class="form-control" id="discprice" name="discprice" type="text" value="<?php echo $row3['difference']; ?>" readonly />
                  </div>
                </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Total Paid Amount </label>
                    <div class="col-sm-10">
                    <?php 
                      $paidquery = $pdoConnection->query("SELECT SUM(paymentAmount) AS totalamntpaid
                                                          FROM payment
                                                          WHERE enrollmentId = $enrollId;");
                      
                      $row4 = $paidquery->fetch(PDO::FETCH_ASSOC);
                            // Default to 0 if no amount is paid                                     
                      $totalPaidAmount = $row4['totalamntpaid'] ? $row4['totalamntpaid'] : 0;
                    ?>
                      <input class=" form-control" id="totalpaid" name="totalpaid" type="text"  value="<?php if ($row4['totalamntpaid']==NULL) echo 0; else echo $row4['totalamntpaid']; ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Remaining Amount</label>
                    <div class="col-sm-10">
                      <?php
                      // Calculate the remaining amount
                        $feesAfterDiscount = $row3['difference'] ? $row3['difference'] : 0;
                        $remainingAmount = $feesAfterDiscount - $totalPaidAmount;
                      ?>
                      <input class=" form-control" id="remaining" name="remaining" type="text" value="<?php echo $remainingAmount; ?>" readonly>
                    </div>
                  </div>
                  <?php 
                    $viewquery=$pdoConnection-> query("select * from payment where ID='$paymntId'");
                    $row5=$viewquery ->fetch(PDO:: FETCH_ASSOC);
                    if($row5>0){
                     ?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Payment Amount</label>
                    <div class="col-sm-10">
                    <input class="form-control" id="amount" name="amount"  type="number" value="<?php echo $row5['paymentAmount']; ?>" placeholder="Enter the amount of payment">
                    <?php if($formSubmitted && isset($errors['amount'])){  ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['amount']; ?></span>
                        <?php } ?>
                      </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Payment Method</label>
                    <div class="col-sm-10">
                      <select class="form-control m-bot15" id="method" name="method">
                      <option value="">Choose payment method</option>
                      <option value="cash"  <?php if($row5['paymentMethod'] == 'cash') echo 'selected'; ?> >Cash</option>
                      <option value="instapay"  <?php if($row5['paymentMethod'] == 'Instapay') echo 'selected'; ?> >Instapay</option>
                        </select>
                        <?php if($formSubmitted && isset($errors['method'])) { ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['method']; ?></span>
                        <?php } ?>
                      </div>
                    </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Payment Date</label>
                    <div class="col-sm-10">
                    <input class="form-control" id="date" name="date" type="date" value="<?php echo $row5['date']; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Payment Added by:</label>
                    <?php
                        $savedadmin = $pdoConnection->query("SELECT u.name  FROM users u JOIN payment p ON u.ID = p.userId WHERE p.enrollmentId = $enrollId;");
                         $row6 = $savedadmin -> fetch(PDO:: FETCH_ASSOC);
                        $addedBy = $row6['name'];
                        $loggedInAdminId = $_SESSION['sportadmission']; 
                        $adminquery = $pdoConnection->query("SELECT * FROM users WHERE ID='$loggedInAdminId'");
                        $admin = $adminquery->fetch(PDO:: FETCH_ASSOC);
                        ?>
                    <div class="col-sm-10">
                      <input class=" form-control" id="adminName" name="adminName" type="text" value="<?php echo $addedBy ;?>" readonly>
                      <?php if( $formSubmitted && isset($errors['addedby'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['addedby'] ?></span>
                       <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Notes</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="notes" placeholder="Explain your edit here" ><?php echo $row5['notes']; ?></textarea>
                      <?php if( $formSubmitted && isset($errors['notes'])){ ?>
                        <span style="color:red;display:block;text-align:left"><?php echo $errors['notes'] ?></span>
                       <?php } ?>
                    </div>
                  </div>
                 <p style="text-align: center;"> <button type="submit" name="submit" id= "submit" class="btn btn-primary">Submit</button></p>
                <?php } ?>
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
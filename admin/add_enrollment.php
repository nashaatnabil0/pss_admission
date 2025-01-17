<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sportadmission']==0)) {
  header('location:logout.php');
  }
else {  
  $errors = [];
   // Fetch all trainee NIDs from the database
   $stmt = $pdoConnection->query("SELECT NID, Name FROM trainees");
   $trainees = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all NIDs and names
   
  if(isset($_POST['submit'])){
    
$nidPattern = '/^\d{3}(0[0-9]|1[0-2])([0-2][0-9]|3[01])\d{7}$/';
$traineeNID =trim($_POST['traineeNID']);
$traineeExists = false; 

// Check if empty
if (empty($traineeNID)) {
    $errors['traineeNID'] = "National ID number cannot be empty";
} 
// Check if matches the pattern
elseif (!preg_match($nidPattern, $traineeNID)) {
    $errors['traineeNIDinvalid'] = "Please enter a valid 14-digit National ID number.";
} 
else {
    // Check if exists in the list
    foreach ($trainees as $trainee) {
        if ($trainee['NID'] == $traineeNID) {
            $traineeExists = true;
            break;
        }
    }
    if (!$traineeExists) {
        $errors['traineeNID'] = "Trainee not found, please add the trainee first.";
    }
  }

    $sport = trim($_POST['sport']);
    if (empty($sport)) {
      $errors['sport'] = "Please select a sport";
    }
    $season = trim( $_POST['season']);
    if (empty($season)) {
      $errors['season'] = "Please select a season";
    }
    $group = trim($_POST['group']);
    if (empty($group)) {
      $errors['group'] = "Please select a group";
    }

    // Check for the sport and season based on the selected group
    $groupQuery = $pdoConnection->prepare("SELECT sportId, seasonId FROM groups WHERE ID = :groupId");
    $groupQuery->execute(['groupId' => $group]);
    $groupDetails = $groupQuery->fetch(PDO::FETCH_ASSOC);
    
    if ($groupDetails) {
      $sportId = $groupDetails['sportId'];
      $seasonId = $groupDetails['seasonId'];
  
      // Check if the trainee is already enrolled in the same sport and season in any group
      $checkEnrollment = $pdoConnection->prepare("SELECT COUNT(*) FROM enrollment e 
          JOIN groups g ON e.groupId = g.ID 
          WHERE e.traineeNID = :traineeNID 
          AND g.sportId = :sportId 
          AND g.seasonId = :seasonId");
  
      $checkEnrollment->execute([
          'traineeNID' => $traineeNID,
          'sportId' => $sportId,
          'seasonId' => $seasonId
      ]);
  
      $enrollmentExists = $checkEnrollment->fetchColumn();
  
      if ($enrollmentExists) {
          $errors['traineeNIDinvalid'] = "The trainee is already enrolled in this sport this season in a different group. Go to manage enrollment page for any edits.";
      }
  
      // Check if the trainee is already enrolled in the selected group
      $checkSameGroupEnrollment = $pdoConnection->prepare("SELECT COUNT(*) FROM enrollment e join groups g on e.groupId = g.ID WHERE e.traineeNID = :traineeNID AND e.groupId = :groupId AND g.seasonId = :seasonId ");
      $checkSameGroupEnrollment->execute([
          'traineeNID' => $traineeNID,
          'groupId' => $group,
          'seasonId' => $seasonId
      ]);
  
      $sameGroupEnrollmentExists = $checkSameGroupEnrollment->fetchColumn();
  
      if ($sameGroupEnrollmentExists) {
          $errors['traineeNIDinvalid'] = "The trainee is already enrolled in this group this season. Go to manage enrollment page for any edits  ";
      }
    }
      
    $pymntPlan = trim($_POST['pymntplan']);
    if (empty($pymntPlan)) {
      $errors['pymntplan'] = "Please select a payment plan";
    }

    $enrollstate = trim($_POST['enrollstate']);
    if (empty($enrollstate)) {
      $errors['enrollstate'] = "Please select an enrollment state";
    }

    $enrolldate = trim($_POST['enrolldate']);
    if ($enrolldate == "") {
        $enrolldate = date('Y-m-d') ;
    }else{
      $enrolldate = trim($_POST['enrolldate']);
    }
    
    $discount = trim($_POST['discount']);
    if (empty($discount)){
      $discount = null;
    }
      
    if (empty($errors)){
            $query2 = $pdoConnection->query("INSERT INTO enrollment(traineeNID, groupId, paymentPlan, state, discount) VALUES ('$traineeNID', '$group', '$pymntPlan', '$enrollstate', '$discount')");
                  if ($query2) {
                      echo "<script>alert('Enrollment details have been added.');</script>";
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
  <title>Add Enrollment |Peace Sports School Admission System</title>

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
            <h3 class="page-header"><i class="fa fa-file-text-o"></i>Add Enrollment</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Enrollment</li>
              <li><i class="fa fa-file-text-o"></i>Add Enrollment</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
             Add Enrollment Details
              </header>
              <div class="panel-body">
                <form class="form-horizontal " method="post" action="" enctype="multipart/form-data" novalidate>
                <!-- Trainee National ID input with datalist -->
                <div class="form-group">
                <label class="col-sm-2 control-label">Trainee National ID</label>
                <div class="col-sm-10">
                  <input class="form-control" id="searchTrainee" name="traineeNID" type="text" placeholder="Type the national ID number" list="traineeListOptions" value=""/>
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
                    <label class="col-sm-2 control-label">Sport</label>
                    <div class="col-sm-10">
                      <select class="form-control m-bot15" name="sport" id="sport">
                        <option value="">Choose a Sport</option>
                          <?php $sportquery=$pdoConnection-> query("select * from sport ");
                            while($row=$sportquery ->fetch(PDO:: FETCH_ASSOC))
                            {
                            ?> 
                          <option value="<?php echo $row['ID'];?>"><?php echo $row['name'];?></option>
                            <?php } ?> 
                      </select>
                      <?php if (isset($_POST['submit']) && isset($errors['sport'])){ ?>
                    <span style="color:red;display:block;text-align:left"><?php echo $errors['sport']; ?></span>
                  <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Group</label>
                    <div class="col-sm-10">
                      <select class="form-control m-bot15" name="group" id="group">
                        <option value="">Choose a group</option> 
                      </select>
                      <?php if (isset($_POST['submit']) && isset($errors['group'])){ ?>
                    <span style="color:red;display:block;text-align:left"><?php echo $errors['group']; ?></span>
                  <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Season</label>
                    <div class="col-sm-10">
                      <?php $seasonquery = $pdoConnection->query( "select * from season where state = 'on' ");
                           $row3 = $seasonquery -> fetch(PDO:: FETCH_ASSOC);
                      ?>
                      <input class="form-control" id="season" name="season"  type="text" value="<?php echo $row3['name'];?>" readonly >
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Payment Plan</label>
                    <div class="col-sm-10">
                      <input class="" id="paymentPlan" name="pymntplan"  type="radio" value="full" style="margin:7px" required> Full <span style="margin: 35px"></span>
                      <input class="" id="paymentPlan" name="pymntplan"  type="radio" value="Installment" style="margin:7px" required > Installments
                     <?php if (isset($_POST['submit']) && isset($errors['pymntplan'])){ ?>
                     <span style="color:red;display:block;text-align:left"><?php echo $errors['pymntplan']; ?></span>
                     <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Discount</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="discount" name="discount"  type="number" value="">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Enrollment State:</label>
                    <div class="col-sm-10">
                    <input class="" id="enrollstate" name="enrollstate"  type="radio" value="on" style="margin:7px" required > Active <span style="margin: 35px"></span>
                    <input class="" id="enrollstateoff" name="enrollstate"  type="radio" value="off" style="margin:7px" required> Inactive  <span style="margin: 35px"></span>
                    <input class="" id="enrollstatewait" name="enrollstate"  type="radio" value="waiting" style="margin:7px" required> Waiting   
                    <?php if (isset($_POST['submit']) && isset($errors['enrollstate'])){ ?>
                    <span style="color:red;display:block;text-align:left"><?php echo $errors['enrollstate']; ?></span>
                  <?php } ?>
                  </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Enrollment Date</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="enrolldate" name="enrolldate" type="date" value="">
                      </div>
                    </div>
                 <p style="text-align: center;"> <button type="submit" name="submit" class="btn btn-primary">Submit</button></p>
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
  var dateElement = document.getElementById("enrolldate");
  var today = new Date();

  // put the date in the defult format YYYY-MM-DD
  var formattedDate = today.getFullYear() + '-' +
                      ('0' + (today.getMonth() + 1)).slice(-2) + '-' + 
                      ('0' + today.getDate()).slice(-2);

  // Set the value of the input as today's date
  dateElement.value = formattedDate;  
</script>

<!-- get the groups based on the sport selected -->
<script>
   // All groups with their associated sport ID
   const groups = [
    <?php
    $groupquery = $pdoConnection->query("SELECT g.ID, g.Title, sp.ID as sportId, sp.name as sportName, g.maxAge, g.minAge , g.state as groupstate
                                        FROM groups g 
                                        JOIN sport sp ON g.sportId = sp.ID");
    while ($row2 = $groupquery->fetch(PDO::FETCH_ASSOC)) {
    ?>
        { 
          id: "<?php echo $row2['ID']; ?>", 
          title: "<?php echo $row2['Title']; ?>", 
          sportId: "<?php echo $row2['sportId']; ?>",
          minAge: "<?php echo $row2['minAge']; ?>",
          maxAge: "<?php echo $row2['maxAge']; ?>",
          groupstate: "<?php echo $row2['groupstate']; ?>" 
        },
    <?php
    }
    ?>
];

document.getElementById('sport').addEventListener('change', function() {
    const sportId = this.value;
    const groupSelect = document.getElementById('group');

    // Clear previous options
    groupSelect.innerHTML = '<option value="">Choose a Group</option>';

    // Filter and add new group options based on the selected sport
    groups.filter(group => group.sportId === sportId).forEach(group => {
        const option = document.createElement('option');
        option.value = group.id;
        option.textContent = group.title + " - " + " ( " + group.minAge + "-" + group.maxAge + " ) " + " Y " + " - " + group.groupstate;
        groupSelect.appendChild(option);
    });
});


</script>
</body>

</html>
<?php  } ?>
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sportadmission']==0)) {
  header('location:logout.php');
  } else{

if(isset($_GET['delid']))
{
$rid=intval($_GET['delid']);
$sql= $pdoConnection -> query("DELETE FROM enrollment WHERE ID='$rid'");

  if($sql){
    echo "<script>alert('Enroll Data deleted');</script>"; 
    echo "<script>window.location.href = 'viewall_enrollments.php'</script>";     
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <title>Manage Enrollments | Peace Sports School Admission System</title>

  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
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

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-table"></i>Enrollments Management</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="fa fa-table"></i>Enrollments</li>
              <li><i class="fa fa-th-list"></i>View all Enrollments</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                Search Enrollment
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search by Trainee Name, Enrol Group, Payment Plan, or State..." class="form-control" style="margin-bottom: 10px;">
              </header>
              <table class="table">
                <thead>                        
                  <tr>
                    <th>S.NO</th>
                    <th>Trainee Name</th>
                    <th>Enrol Group</th>
                    <th>Payment Plan</th>
                    <th>Payment State</th>
                    <th>Enrollment State</th>
                    <th>Discount</th>
                    <th>Action</th>
                  </tr>
                </thead>
                  <?php
                  $ret= $pdoConnection-> query("SELECT
                    en.ID,
                    en.traineeNID,
                    en.groupId,
                    en.paymentPlan,
                    en.paymentState,
                    en.state,
                    en.discount,
                    en.date,
                    t.Name as Tname,
                    g.Title as Gtilte,
                    g.days as Gdays,
                    g.minAge as gminAge,
                    g.maxAge as gmaxAge,
                    g.Timeslot as Timing
                  FROM 
                    enrollment en 
                  JOIN
                    trainees t on en.traineeNID=t.NID 
                  JOIN 
                    groups g on en.groupId=g.ID;");
                  $cnt=1;
                  while ($row=$ret-> fetch(PDO:: FETCH_ASSOC)) {
                  ?>
                  <tr>
                    <td><?php echo $cnt;?></td>
                    <td><?php  echo $row['Tname'];?></td>
                    <td><?php  echo $row['Gtilte'].' / '.$row['Gdays'].' / '.$row['gminAge'].' to '.$row['gmaxAge'].' / '.$row['Timing'];?></td> 
                    <td><?php  echo $row['paymentPlan'];?></td>
                    <td><?php  echo $row['paymentState'];?></td>
                    <td><?php  echo $row['state'];?></td>
                    <td><?php  echo $row['discount'];?></td>
                    <td><a href="edit_enrollment_detail.php?editid=<?php echo $row['ID'];?>" class="btn btn-success">Edit</a> || <a href="viewall_enrollments.php?delid=<?php echo $row['ID'];?>" class="btn btn-danger confirm">Delete</a></td>
                  </tr>
                <?php 
                    $cnt=$cnt+1;
                    }?>
              </table>
            </section>
          </div>
       
        </div>
       
        <!-- page end-->
      </section>
    </section>
    <!--main content end-->
    <?php include_once('includes/footer.php');?>
  </section>
  <!-- container section end -->
  <!-- javascripts -->
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- nicescroll -->
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
  <!--custome script for all page-->
  <script src="js/scripts.js"></script>
  <!-- Confirm script -->
  <script>
    let deleteBtn = document.querySelectorAll(".confirm");
    for (let i = 0; i < deleteBtn.length; i++) {
        deleteBtn[i].addEventListener("click", (e) => {
            let ans = confirm("Are You Sure!!\nThis action will delete any payment related to it ?")
            if (!ans) {
                e.preventDefault();
            }
        })
    }
  </script>

</body>

</html>
<?php }  ?>
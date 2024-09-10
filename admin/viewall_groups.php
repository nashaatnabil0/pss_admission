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
$delete_image = $pdoConnection -> query("select Profilepic from tblartist where ID='$rid'");
$image_data = $delete_image-> fetch(PDO:: FETCH_ASSOC);
$image_name = $image_data['Profilepic'];

$sql= $pdoConnection -> query("DELETE FROM tblartist WHERE ID='$rid'");

  if($sql){
    unlink("images/$image_name");
    echo "<script>alert('Data deleted');</script>"; 
    echo "<script>window.location.href = 'manage-artist.php'</script>";     
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <title>Manage Groups | Peace Sports School Admission System</title>

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
            <h3 class="page-header"><i class="fa fa-table"></i>Groups Management</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="fa fa-table"></i>Groups</li>
              <li><i class="fa fa-th-list"></i>View All Groups</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                Group Search
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search by title, days, timing, location, age range, capacity, enrollment, or sport..." class="form-control mb-3" style="margin-bottom: 10px;">
                </header>
                <table class="table">
                  <thead>   
                    <tr>
                      <th>S.NO</th>
                      <th>Title</th>
                      <th>Days</th>
                      <th>Timing</th>
                      <th>Age Range</th>
                      <th>Capacity</th>
                      <th>Enrollments</th>
                      <th>Sport</th>
                      <th>Price</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <?php
                    $ret= $pdoConnection-> query("SELECT groups.ID as gID,groups.Title,groups.days,groups.Timeslot,groups.place,groups.minAge,groups.maxAge,groups.capacity,groups.price, sport.name FROM groups LEFT JOIN sport on groups.sportId=sport.ID");
                    $cnt=1;
                    while ($row=$ret-> fetch(PDO:: FETCH_ASSOC)) {
                      $gID = $row['gID'];
                      $query2=$pdoConnection-> query("SELECT * FROM `enrollment` WHERE enrollment.groupId = '$gID' AND enrollment.state='on'");
                      $enrollmentcount=$query2 ->rowCount();
                    ?>
                    <tr>
                      <td><?php echo $cnt;?></td>
                      <td><?php  echo $row['Title'];?></td>
                      <td><?php  echo $row['days'];?></td> 
                      <td><?php  echo $row['Timeslot'];?></td>
                      <td><?php  echo $row['minAge'].'y - '.$row['maxAge'].'y';?></td>
                      <td><?php  echo $row['capacity'];?></td>
                      <td><?php  echo $enrollmentcount;?></td>
                      <td><?php  echo $row['name'];?></td>
                      <td><?php  echo $row['price'];?></td>
                      <td><a href="edit_group_detail.php?editid=<?php echo $row['ID'];?>" class="btn btn-success">Edit</a> || <a href="viewall_groups.php?delid=<?php echo $row['ID'];?>" class="btn btn-danger confirm">Delete</a></td>
                    </tr>
                  <?php $cnt=$cnt+1;}?>
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
<!-- Confirm Script -->
<script>
  let deleteBtn = document.querySelectorAll(".confirm");
  for (let i = 0; i < deleteBtn.length; i++) {
      deleteBtn[i].addEventListener("click", (e) => {
          let ans = confirm("Are You Sure!!")
          if (!ans) {
              e.preventDefault();
          }
      })
  } 
</script>
<!-- Search Script -->
  <script>
    function searchTable() {
      var input = document.getElementById("searchInput");
      var filter = input.value.toUpperCase();
      var table = document.querySelector(".table");
      var tr = table.getElementsByTagName("tr");

      for (var i = 1; i < tr.length; i++) {
        var tdTitle = tr[i].getElementsByTagName("td")[1];    // Title
        var tdDays = tr[i].getElementsByTagName("td")[2];     // Days
        var tdTiming = tr[i].getElementsByTagName("td")[3];   // Timing
        var tdLocation = tr[i].getElementsByTagName("td")[4]; // Location
        var tdAge = tr[i].getElementsByTagName("td")[5];      // Age Range
        var tdCapacity = tr[i].getElementsByTagName("td")[6]; // Capacity
        var tdEnrollment = tr[i].getElementsByTagName("td")[7]; // Active Enrollment
        var tdSport = tr[i].getElementsByTagName("td")[8];    // Sport
        
        if (tdTitle || tdDays || tdTiming || tdLocation || tdAge || tdCapacity || tdEnrollment || tdSport) {
          var titleText = tdTitle.textContent || tdTitle.innerText;
          var daysText = tdDays.textContent || tdDays.innerText;
          var timingText = tdTiming.textContent || tdTiming.innerText;
          var locationText = tdLocation.textContent || tdLocation.innerText;
          var ageText = tdAge.textContent || tdAge.innerText;
          var capacityText = tdCapacity.textContent || tdCapacity.innerText;
          var enrollmentText = tdEnrollment.textContent || tdEnrollment.innerText;
          var sportText = tdSport.textContent || tdSport.innerText;

          if (
            titleText.toUpperCase().indexOf(filter) > -1 || 
            daysText.toUpperCase().indexOf(filter) > -1 || 
            timingText.toUpperCase().indexOf(filter) > -1 || 
            locationText.toUpperCase().indexOf(filter) > -1 || 
            ageText.toUpperCase().indexOf(filter) > -1 || 
            capacityText.toUpperCase().indexOf(filter) > -1 || 
            enrollmentText.toUpperCase().indexOf(filter) > -1 || 
            sportText.toUpperCase().indexOf(filter) > -1
          ) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
      }
    }
  </script>
<!-- sort Script -->
  <!-- <script>
    function sortTableByEnrollment() {
      var table = document.querySelector(".table");
      var rows = Array.from(table.rows).slice(1); // Get all rows except the header
      var sortedRows = rows.sort(function(a, b) {
        var enrollmentA = parseInt(a.getElementsByTagName("td")[7].innerText);
        var enrollmentB = parseInt(b.getElementsByTagName("td")[7].innerText);
        
        return enrollmentA - enrollmentB; // Sort in ascending order
      });

      // Append sorted rows to the table body
      var tbody = table.getElementsByTagName("tbody")[0];
      tbody.innerHTML = ""; // Clear current rows
      sortedRows.forEach(function(row) {
        tbody.appendChild(row);
      });
    }
  </script> -->

  
</body>

</html>
<?php }  ?>
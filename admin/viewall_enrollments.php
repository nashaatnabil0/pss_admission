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
                <!-- <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search by Trainee Name, Enrol Group, Payment Plan, or State..." class="form-control" style="margin-bottom: 10px;"> -->
                <input type="text" id="searchBar" placeholder="Search by Trainee Name or NID" onkeyup="filterTable()" class="form-control" style="margin-bottom: 10px;">

                <!-- Group Filter Dropdown -->
                <select id="groupFilter" onchange="filterTable()" style="margin-bottom: 10px;">
                    <option value="">All Groups</option>
                    <?php
                  $rettt= $pdoConnection-> query("SELECT
                    g.Title as Gtilte,
                    g.days as Gdays,
                    g.minAge as gminAge,
                    g.maxAge as gmaxAge,
                    g.Timeslot as Timing,
                    sp.name as spname
                  FROM 
                    groups g
                  JOIN
                    sport sp on g.sportId = sp.ID;");
                  $cnt=1;
                  while ($row=$rettt-> fetch(PDO:: FETCH_ASSOC)) {
                  ?>
                    <option 
                      value="<?php  echo $row['Gtilte'];?>">
                      <?php  echo $row['Gtilte'];?>
                    </option>
                  <?php } ?>
                </select>
                
                <!-- Payment State Filter Dropdown -->
                <select id="paymentStateFilter" onchange="filterTable()" style="margin-bottom: 10px;">
                    <option value="">All Payment States</option>
                    <option value="complete">complete</option>
                    <option value="partial">Partial</option>
                    <option value="No Payment">No Payment</option>
                </select>
                
                <!-- Enrollment State Filter Dropdown -->
                <select id="enrollmentStateFilter" onchange="filterTable()" style="margin-bottom: 10px;">
                    <option value="">All Enrollment States</option>
                    <option value="on">On</option>
                    <option value="Waiting">Waiting</option>
                    <option value="off">OFF</option>
                </select>
                <button onclick="resetFilters()" class="btn btn-primary" style="margin-bottom: 10px;">Reset Filters</button>
              </header>
              <table class="table" id="dataTable">
                <thead>                        
                  <tr>
                    <th>S.NO</th>
                    <th>Trainee Name</th>
                    <th>NID</th>
                    <th>Enrolld Group</th>
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
                    COALESCE(en.paymentState, 'No Payment') as paymentState,
                    en.state,
                    en.discount,
                    en.date,
                    t.Name as Tname,
                    g.Title as Gtilte,
                    g.days as Gdays,
                    g.minAge as gminAge,
                    g.maxAge as gmaxAge,
                    g.Timeslot as Timing,
                    sp.name as spname
                  FROM 
                    enrollment en 
                  JOIN
                    trainees t on en.traineeNID=t.NID 
                  JOIN 
                    groups g on en.groupId=g.ID
                  JOIN
                    sport sp on g.sportId = sp.ID;");
                  $cnt=1;
                  while ($row=$ret-> fetch(PDO:: FETCH_ASSOC)) {
                  ?>
                  <tr>
                    <td><?php echo $cnt;?></td>
                    <td><?php  echo $row['Tname'];?></td>
                    <td><?php  echo $row['traineeNID'];?></td>
                    <td><?php  echo $row['Gtilte'].' / '.$row['spname'].' / '.$row['Gdays'].' / '.$row['gminAge'].' to '.$row['gmaxAge'].' / '.$row['Timing'];?></td> 
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

  <!-- filter script -->
  <script>
        // JavaScript function to filter table based on search and dropdowns
        function filterTable() {
            var searchBar = document.getElementById('searchBar').value.toLowerCase();
            var groupFilter = document.getElementById('groupFilter').value.toLowerCase();
            var paymentStateFilter = document.getElementById('paymentStateFilter').value.toLowerCase();
            var enrollmentStateFilter = document.getElementById('enrollmentStateFilter').value.toLowerCase();

            var table = document.getElementById('dataTable');
            var rows = table.getElementsByTagName('tr');

            // Loop through table rows and filter based on inputs
            for (var i = 1; i < rows.length; i++) { // Start from index 1 to skip header
                var cells = rows[i].getElementsByTagName('td');
                var traineeName = cells[1].innerText.toLowerCase();
                var nid = cells[2].innerText.toLowerCase(); // NID column index is 2
                var group = cells[3].innerText.toLowerCase();
                var paymentState = cells[5].innerText.toLowerCase();
                var enrollmentState = cells[6].innerText.toLowerCase();

                // Check if each row matches the filters
                var nameOrNidMatch = traineeName.includes(searchBar) || nid.includes(searchBar);
                var groupMatch = group.includes(groupFilter) || groupFilter === "";
                var paymentStateMatch = paymentState.includes(paymentStateFilter) || paymentStateFilter === "";
                var enrollmentStateMatch = enrollmentState.includes(enrollmentStateFilter) || enrollmentStateFilter === "";

                // Show/hide the row based on match results
                if (nameOrNidMatch && groupMatch && paymentStateMatch && enrollmentStateMatch) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
        function resetFilters() {
            document.getElementById('groupFilter').selectedIndex = 0; // Reset group dropdown
            document.getElementById('paymentStateFilter').selectedIndex = 0; // Reset payment state dropdown
            document.getElementById('enrollmentStateFilter').selectedIndex = 0; // Reset enrollment state dropdown

            filterTable(); // Re-apply filter with default values
        }
    </script>
</body>

</html>
<?php }  ?>
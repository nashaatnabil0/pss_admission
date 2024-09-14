<?php
session_start();
// error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sportadmission']==0)) {
  header('location:logout.php');
  } else{
// لسه محتاجين نشوف هنعمل ايه ف الحوار ده هيمسح ولا هنعمله refund
if(isset($_GET['delid']))
{
    $paymentid=intval($_GET['delid']);
    $enID=intval($_GET['enID']);
    
    $deletquery = $pdoConnection->query("DELETE FROM payment WHERE ID = $paymentid;");

      if($deletquery){

        $paidquery = $pdoConnection->query("SELECT SUM(paymentAmount) AS totalPaidAmount FROM payment WHERE enrollmentId = $enID;");
        $row4 = $paidquery->fetch(PDO::FETCH_ASSOC);
        $totalPaidAmount = $row4['totalPaidAmount'] ? $row4['totalPaidAmount'] : 0;

        $feesAfterDiscountQuery = $pdoConnection->query("SELECT g.price - COALESCE(e.discount, 0) AS feesAfterDiscount FROM enrollment e JOIN groups g ON e.groupId = g.ID WHERE e.ID = $enID;");
        $row3 = $feesAfterDiscountQuery->fetch(PDO::FETCH_ASSOC);
        $feesAfterDiscount = $row3['feesAfterDiscount'] ? $row3['feesAfterDiscount'] : 0;
        if($totalPaidAmount<$feesAfterDiscount && $totalPaidAmount !=0){
          $pdoConnection->query("UPDATE enrollment SET paymentState = 'partial' WHERE ID = $enID;");
        }else{
          $pdoConnection->query("UPDATE enrollment SET paymentState = NULL WHERE ID = $enID;");
        }

        echo "<script>alert('Payment Data deleted');</script>"; 
        echo "<script>window.location.href = 'viewall_payments.php'</script>";     
      }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <title>Manage Payments | Peace Sports School Admission System</title>

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
            <h3 class="page-header"><i class="fa fa-table"></i>Payment Management</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="fa fa-table"></i>Payment</li>
              <li><i class="fa fa-th-list"></i>View all payment</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                Search Payment
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for names, groups, etc." class="form-control" style="margin-bottom: 10px;">
                <div style="margin-bottom: 10px;">
                  <label for="stateFilter">Filter by Enrollment State: </label>
                  <select id="stateFilter" onchange="filterTable()">
                    <option value="All">All</option>
                    <option value="on">On</option>
                    <option value="off">Off</option>
                  </select>
                </div>
              </header>
              <table class="table" id="enrollmentTable">
                <thead>                      
                  <tr>
                    <th>S.NO</th>
                    <th>Trainee Name</th>
                    <th>Group</th>
                    <th>Amount</th>
                    <th>Payment Meshod</th>
                    <th>Date</th>
                    <th>User</th>
                    <th>Enrollment State</th>
                    <th>Notes</th>
                    <th>Action</th>
                  </tr>
                </thead>
                  <?php
                  // $ret= $pdoConnection-> query("SELECT * FROM payment");
                  $ret= $pdoConnection-> query("SELECT
                      p.ID,
                      p.paymentAmount,
                      p.paymentMethod,
                      p.date,
                      u.name as Uname,
                      p.notes,
                      t.Name AS Tname,
                      g.Title as Gtitle,
                      g.days as Gdays,
                      g.Timeslot timing,
                      g.minAge as gminAge,
                      g.maxAge as gmaxAge,
                      en.state,
                      en.ID as enrollID
                    FROM 
                      payment p 
                    JOIN 
                      enrollment en ON p.enrollmentId = en.ID 
                    JOIN 
                      trainees t on en.traineeNID=t.NID 
                    JOIN 
                      users u on p.userId=u.ID 
                    JOIN 
                      groups g on en.groupId=g.ID");
                  $cnt=1;
                  while ($row=$ret-> fetch(PDO:: FETCH_ASSOC)) {
                  ?>
                <tr>
                  <td><?php echo $cnt;?></td>
                  <td><?php  echo $row['Tname'];?></td>
                  <td><?php  echo $row['Gtitle'].' / '.$row['Gdays'].' / '.$row['gminAge'].' to '.$row['gmaxAge'].' / '.$row['timing'];?></td> 
                  <td><?php  echo $row['paymentAmount'];?></td>
                  <td><?php  echo $row['paymentMethod'];?></td>
                  <td><?php  echo $row['date'];?></td>
                  <td><?php  echo $row['Uname'];?></td>
                  <td><?php  echo $row['state'];?></td>
                  <td><?php  echo $row['notes'];?></td>
                  <td><a href="edit_payment_detail.php?editid=<?php echo $row['ID'];?>" class="btn btn-success">Edit</a> || <a href="viewall_payments.php?delid=<?php echo $row['ID'];?>&enID=<?php echo $row['enrollID'] ?>" class="btn btn-danger confirm">Delete</a></td>
                </tr>
                <?php 
                  $cnt=$cnt+1;}?>
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
  <!-- confirm script -->
  <script>
      let deleteBtn = document.querySelectorAll(".confirm");
      for (let i = 0; i < deleteBtn.length; i++) {
          deleteBtn[i].addEventListener("click", (e) => {
              let ans = confirm("Are You Sure!!\nThis Action will delete the payment data and can not be restored ?")
              if (!ans) {
                  e.preventDefault();
              }
          })
      }
  </script>
  <!-- search script -->
  <script>
    function searchTable() {
      // Get search input value
      var input = document.getElementById("searchInput");
      var filter = input.value.toUpperCase();

      // Get table and rows
      var table = document.getElementById("enrollmentTable");
      var tr = table.getElementsByTagName("tr");

      // Loop through rows and filter by input text
      for (var i = 1; i < tr.length; i++) { // start from 1 to skip the header row
        var tdArray = tr[i].getElementsByTagName("td");
        var found = false;

        // Loop through all table cells
        for (var j = 0; j < tdArray.length; j++) {
          var td = tdArray[j];
          if (td) {
            var txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              found = true;
              break; // If a match is found in any cell, stop checking further cells in the row
            }
          }
        }

        // Show row if any cell matches the search query
        if (found) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  </script>
  <!-- state filter -->
  <script>
    function filterTable() {
      // Get selected filter value
      var stateFilter = document.getElementById("stateFilter").value;
      var searchInput = document.getElementById("searchInput").value.toUpperCase();

      // Get table rows from tbody
      var table = document.getElementById("enrollmentTable");
      var tr = table.getElementsByTagName("tr");

      // Loop through rows and filter based on state and search input
      for (var i = 1; i < tr.length; i++) { // start from 1 to skip the header row
        var stateTd = tr[i].getElementsByTagName("td")[7]; // index 7 for 'Enrollment State' column
        var foundInSearch = false;

        // Search functionality
        var tdArray = tr[i].getElementsByTagName("td");
        for (var j = 0; j < tdArray.length; j++) {
          var td = tdArray[j];
          if (td) {
            var txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(searchInput) > -1) {
              foundInSearch = true;
              break; // stop searching if found
            }
          }
        }

        // State filter check
        if (stateTd && foundInSearch) {
          var stateValue = stateTd.textContent || stateTd.innerText;
          if (stateFilter === "All" || stateValue === stateFilter) {
            tr[i].style.display = ""; // Show row if state matches filter and search term is found
          } else {
            tr[i].style.display = "none"; // Hide if state does not match
          }
        } else {
          tr[i].style.display = "none"; // Hide if no match found in search
        }
      }
    }
  </script>

</body>

</html>
<?php }  ?>
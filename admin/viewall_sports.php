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
$sql=$pdoConnection -> query("DELETE FROM tblartmedium where ID='$rid'");
 echo "<script>alert('Data deleted');</script>"; 
  echo "<script>window.location.href = 'manage-art-medium.php'</script>";     


}

  ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <title>Manage Sports| Peace Sports School Admission System</title>

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
            <h3 class="page-header"><i class="fa fa-table"></i>Sports Manage</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="fa fa-table"></i>Sports</li>
              <li><i class="fa fa-th-list"></i>View All Sports</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                Sports Search
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for titles or supervisors.." class="form-control" style="margin-bottom: 10px;">
              </header>
              <table class="table">
                <thead>                    
                  <tr>
                    <th>S.NO</th>
                    <th>Title</th>
                    <th>Supervisor</th>
                    <th>Action</th>
                  </tr>
                </thead>
                    <?php 
                    $ret=$pdoConnection->query("SELECT sport.ID as ID, sport.name as title, COALESCE(trainers.name, 'No Supervisor') AS Supervisor FROM sport LEFT JOIN trainers ON sport.supervisorID = trainers.ID;");
                    if($ret->rowCount()>0){ 
                    $cnt=1;
                    while ($row= $ret-> fetch(PDO:: FETCH_ASSOC)) {
                    ?>     
                <tr>
                  <td><?php echo $cnt;?></td>
                  <td><?php  echo $row['title'];?></td>
                  <td><?php  echo $row['Supervisor'];?></td>
                  <td><a href="edit_season_detail.php?editid=<?php echo $row['ID'];?>" class="btn btn-primary">Edit</a> || <a href="viewall_seasons.php?delid=<?php echo $row['ID'];?>" class="btn btn-danger confirm">Delete</a></td>
                </tr>
                    <?php 
                      $cnt=$cnt+1;
                    } }else {?>
                <tr>
                  <td colspan="4" style="text-align: center;">no Data</td>
                </tr>
                    <?php }?>
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
  <!-- Delete Btn Confirm -->
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
      // Get the search input value and convert it to uppercase
      var input = document.getElementById("searchInput");
      var filter = input.value.toUpperCase();
      
      // Get the table and its rows
      var table = document.querySelector(".table");
      var tr = table.getElementsByTagName("tr");

      // Loop through the rows and hide those that don't match the search
      for (var i = 1; i < tr.length; i++) {
        var tdTitle = tr[i].getElementsByTagName("td")[1]; // Title column
        var tdSupervisor = tr[i].getElementsByTagName("td")[2]; // Supervisor column
        
        if (tdTitle || tdSupervisor) {
          var titleText = tdTitle.textContent || tdTitle.innerText;
          var supervisorText = tdSupervisor.textContent || tdSupervisor.innerText;

          // Check if either title or supervisor matches the search query
          if (titleText.toUpperCase().indexOf(filter) > -1 || supervisorText.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
      }
    }
  </script>

</body>

</html>
<?php }  ?>
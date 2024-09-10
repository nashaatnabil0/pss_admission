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

  <title>Manage Trainers | Peace Sports School Admission System</title>

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
            <h3 class="page-header"><i class="fa fa-table"></i>Trainer Management</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="fa fa-table"></i>Trainers</li>
              <li><i class="fa fa-th-list"></i>View All Trainers</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                Trainers Search
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for name, mobile number, or sport..." class="form-control" style="margin-bottom: 10px;">
              </header>
              <table class="table">
                <thead>                    
                  <tr>
                    <th>S.NO</th>
                    <th>Full Name</th>
                    <th>Mob. Number</th>
                    <th>Sport</th>
                    <th>Action</th>
                  </tr>
                </thead>
                    <?php $ret=$pdoConnection->query("SELECT trainers.ID as ID, trainers.name, trainers.MobileNumber as mobNum, COALESCE(sport.name, 'No Sport assigned') as sport FROM `trainers` LEFT JOIN sport on trainers.sportId = sport.ID");
                    if($ret->rowCount()>0){ 
                    $cnt=1;
                    while ($row= $ret-> fetch(PDO:: FETCH_ASSOC)) {
                    ?>     
                <tr>
                  <td><?php echo $cnt;?></td>
                  <td><?php  echo $row['name'];?></td>
                  <td><?php  echo '0'.$row['mobNum'];?></td>
                  <td><?php  echo $row['sport'];?></td>
                  <td><a href="edit_trainer_detail.php?editid=<?php echo $row['ID'];?>" class="btn btn-primary">Edit</a> || <a href="viewall_seasons.php?delid=<?php echo $row['ID'];?>" class="btn btn-danger confirm">Delete</a></td>
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
      var input = document.getElementById("searchInput");
      var filter = input.value.toUpperCase();
      var table = document.querySelector(".table");
      var tr = table.getElementsByTagName("tr");

      for (var i = 1; i < tr.length; i++) {
        var tdName = tr[i].getElementsByTagName("td")[1]; // Full Name column
        var tdMobNum = tr[i].getElementsByTagName("td")[2]; // Mobile Number column
        var tdSport = tr[i].getElementsByTagName("td")[3]; // Sport column
        
        if (tdName || tdMobNum || tdSport) {
          var nameText = tdName.textContent || tdName.innerText;
          var mobNumText = tdMobNum.textContent || tdMobNum.innerText;
          var sportText = tdSport.textContent || tdSport.innerText;

          // Check if any of the columns match the search query
          if (
            nameText.toUpperCase().indexOf(filter) > -1 || 
            mobNumText.toUpperCase().indexOf(filter) > -1 || 
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

</body>

</html>
<?php }  ?>
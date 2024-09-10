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
$delete_image = $pdoConnection -> query("select image from season where ID='$rid'");
$image_data = $delete_image-> fetch(PDO:: FETCH_ASSOC);
$image_name = $image_data['image'];
$sql=$pdoConnection -> query("DELETE FROM season where ID='$rid'");
  if($sql){
    unlink("images/$image_name");
    echo "<script>alert('Data deleted');</script>"; 
    echo "<script>window.location.href = 'viewall_seasons.php'</script>";     
  }
}
  ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <title>Manage Seasons| Peace Sports School Admission System</title>

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
            <h3 class="page-header"><i class="fa fa-table"></i> Season Management</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="fa fa-table"></i>Season</li>
              <li><i class="fa fa-th-list"></i>View All Season</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                Season Search
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for title, state, or start date..." class="form-control" style="margin-bottom: 10px;">
              </header>
              <table class="table">
                <thead>                    
                  <tr>
                    <th>S.NO</th>
                    <th>Title</th>
                    <th>State</th>
                    <th>Start Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                    <?php $ret=$pdoConnection->query("SELECT * FROM `season`");
                    if($ret->rowCount()>0){ 
                    $cnt=1;
                    while ($row= $ret-> fetch(PDO:: FETCH_ASSOC)) {
                    ?>     
                <tr>
                  <td><?php echo $cnt;?></td>
                  <td><?php  echo $row['name'];?></td>
                  <td><?php  if($row['state']=="on"){ echo "Active";}else{echo "Not Active";}?></td>
                  <td><?php  echo $row['startDate'];?></td>
                  <td><a href="edit_season_detail.php?editid=<?php echo $row['ID'];?>" class="btn btn-primary">Edit</a> || <a href="viewall_seasons.php?delid=<?php echo $row['ID'];?>" class="btn btn-danger confirm">Delete</a></td>
                </tr>
                    <?php 
                      $cnt=$cnt+1;
                    } }else {?>
                <tr>
                  <td colspan="5" style="text-align: center;">no Data</td>
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
        var tdTitle = tr[i].getElementsByTagName("td")[1]; // Title column
        var tdState = tr[i].getElementsByTagName("td")[2]; // State column
        var tdDate = tr[i].getElementsByTagName("td")[3]; // Start Date column
        
        if (tdTitle || tdState || tdDate) {
          var titleText = tdTitle.textContent || tdTitle.innerText;
          var stateText = tdState.textContent || tdState.innerText;
          var dateText = tdDate.textContent || tdDate.innerText;

          // Check if any of the columns match the search query
          if (
            titleText.toUpperCase().indexOf(filter) > -1 || 
            stateText.toUpperCase().indexOf(filter) > -1 || 
            dateText.toUpperCase().indexOf(filter) > -1
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
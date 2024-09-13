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

$sql= $pdoConnection -> query("DELETE FROM users WHERE ID='$rid'");

  if($sql){
    echo "<script>alert('Data deleted');</script>"; 
    echo "<script>window.location.href = 'Viewall_users.php'</script>";     
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <title>Manage Users | Peace Sports School Admission System</title>

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
            <h3 class="page-header"><i class="fa fa-table"></i>User Management</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="fa fa-table"></i>Users</li>
              <li><i class="fa fa-th-list"></i>View all Users</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                Users Search
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search by name, email, mobile number, or role..." class="form-control mb-3" style="margin-bottom: 10px;">
              </header>
              <table class="table">
                <thead>                     
                  <tr>
                    <th>S.NO</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile Number</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <?php
                  $ret= $pdoConnection-> query("SELECT * FROM users");
                  $cnt=1;
                  while ($row=$ret-> fetch(PDO:: FETCH_ASSOC)) {
                ?>
                <tr>
                  <td><?php echo $cnt;?></td>
                  <td><?php  echo $row['name'];?></td>
                  <td><?php  echo $row['Email'];?></td> 
                  <td><?php  echo '0'.$row['MobileNumber'];?></td>
                  <td><?php  echo $row['role'];?></td>
                  <td><a href="edit_user_detail.php?editid=<?php echo $row['ID'];?>" class="btn btn-success">Edit</a> || <a href="Viewall_users.php?delid=<?php echo $row['ID'];?>" class="btn btn-danger confirm">Delete</a></td>
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
  <!-- confirm script -->
  <script>
    let deleteBtn = document.querySelectorAll(".confirm");
    for (let i = 0; i < deleteBtn.length; i++) {
        deleteBtn[i].addEventListener("click", (e) => {
            let ans = confirm("Are You Sure!!\nThis action will make all payment by this user be asigned to null")
            if (!ans) {
                e.preventDefault();
            }
        })
    }
  </script>
  <!-- search script -->
  <script>
    function searchTable() {
      var input = document.getElementById("searchInput");
      var filter = input.value.toUpperCase();
      var table = document.querySelector(".table");
      var tr = table.getElementsByTagName("tr");

      // Loop through all table rows, excluding the header (index 0)
      for (var i = 1; i < tr.length; i++) {
        var tdName = tr[i].getElementsByTagName("td")[1]; // Name column
        var tdEmail = tr[i].getElementsByTagName("td")[2]; // Email column
        var tdMobile = tr[i].getElementsByTagName("td")[3]; // Mobile Number column
        var tdRole = tr[i].getElementsByTagName("td")[4]; // Role column
        
        if (tdName || tdEmail || tdMobile || tdRole) {
          var nameText = tdName.textContent || tdName.innerText;
          var emailText = tdEmail.textContent || tdEmail.innerText;
          var mobileText = tdMobile.textContent || tdMobile.innerText;
          var roleText = tdRole.textContent || tdRole.innerText;

          // Check if any column matches the search query
          if (
            nameText.toUpperCase().indexOf(filter) > -1 || 
            emailText.toUpperCase().indexOf(filter) > -1 || 
            mobileText.toUpperCase().indexOf(filter) > -1 || 
            roleText.toUpperCase().indexOf(filter) > -1
          ) {
            tr[i].style.display = ""; // Show the row if it matches
          } else {
            tr[i].style.display = "none"; // Hide the row if it doesn't match
          }
        }       
      }
    }
  </script>

</body>

</html>
<?php }  ?>
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
$delete_image = $pdoConnection -> query("select Image, Image1, Image2, Image3, Image4 from tblartproduct where ID='$rid'");
$image_data = $delete_image-> fetch(PDO:: FETCH_ASSOC);

$sql= $pdoConnection -> query("DELETE FROM tblartproduct WHERE ID='$rid'");
 
if($sql){
  if ($image_data) {
    foreach ($image_data as $image_name) {
            unlink("images/$image_name");
        }
    }
}
  echo "<script>alert('Data deleted');</script>"; 
  echo "<script>window.location.href = 'manage-art-product.php'</script>";     
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <title>Manage Trainees| Peace Sports School Admission System</title>

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
            <h3 class="page-header"><i class="fa fa-table"></i> Trainees Management</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="fa fa-table"></i>Trainees Profiles</li>
              <li><i class="fa fa-th-list"></i>View All Trainees</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                Trainees Search
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search by name, NID, phone number, or notes..." class="form-control" style="margin-bottom: 10px;">
                </header>
              <table class="table">
                <thead>                    
                  <tr>
                    <th>S.NO</th>
                    <th>Full Name</th>
                    <th>NID</th>
                    <th>Contact Ph. Number</th>
                    <th>Notes</th>
                    <th>Action</th>
                  </tr>
                </thead>
                    <?php $ret=$pdoConnection->query("SELECT * FROM `trainees`");
                    if($ret->rowCount()>0){ 
                    $cnt=1;
                    while ($row= $ret-> fetch(PDO:: FETCH_ASSOC)) {
                    ?>     
                <tr>
                  <td><?php echo $cnt;?></td>
                  <td><?php  echo $row['Name'];?></td>
                  <td><?php  echo $row['NID'];?></td>
                  <td><?php  echo '0'.$row['contactMobNum'];?></td>
                  <td><?php  echo $row['Notes'];?></td>
                  <td>
                    <button 
                      class="btn btn-info" 
                      data-toggle="modal" 
                      data-target="#detailsModal" 
                      onclick="showDetails(
                        '<?php echo $row['Name'];?>', 
                        '<?php echo $row['NID'];?>', 
                        '<?php echo $row['birthDate'];?>', 
                        '<?php echo $row['gender'];?>', 
                        '<?php echo $row['contactMobNum'];?>', 
                        '<?php echo $row['fatherName'];?>', 
                        '<?php echo $row['fatherMobNum'];?>', 
                        '<?php echo $row['fatherJob'];?>', 
                        '<?php echo $row['motherName'];?>', 
                        '<?php echo $row['motherMobNum'];?>', 
                        '<?php echo $row['motherJob'];?>', 
                        '<?php echo $row['Notes'];?>'
                      )">Details
                    </button> ||
                    <a href="edit_season_detail.php?editid=<?php echo $row['ID'];?>" class="btn btn-primary">Edit</a> || <a href="viewall_seasons.php?delid=<?php echo $row['ID'];?>" class="btn btn-danger confirm">Delete</a>
                  </td>
                </tr>
                    <?php 
                      $cnt=$cnt+1;
                    } }else {?>
                <tr>
                  <td colspan="6" style="text-align: center;">no Data</td>
                </tr>
                    <?php }?>
              </table>
            
              <!-- Start Details Modal -->
             <!-- Modal Structure -->
              <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Trainee Details</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <!-- Details will be inserted here dynamically -->
                      <p><strong>Full Name:</strong> <span id="modalFullName"></span></p>
                      <p><strong>NID:</strong> <span id="modalNID"></span></p>
                      <p><strong>BirthDate:</strong> <span id="modalBD"></span></p>
                      <p><strong>Gender:</strong> <span id="modalGender"></span></p>
                      <p><strong>Contact Ph. Number:</strong> <span id="modalContPhone"></span></p>
                      <p><strong>Father Name:</strong> <span id="modalFaN"></span></p>
                      <p><strong>Father Ph. Num:</strong> <span id="modalFaPhone"></span></p>
                      <p><strong>Father Jop:</strong> <span id="modalFaJop"></span></p>
                      <p><strong>Mother Name:</strong> <span id="modalMaN"></span></p>
                      <p><strong>Mother Ph. Num:</strong> <span id="modalMaPhone"></span></p>
                      <p><strong>Mother Jop:</strong> <span id="modalMaJop"></span></p>
                      <p><strong>Notes:</strong> <span id="modalNotes"></span></p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Details Modal -->
            
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
        var tdNID = tr[i].getElementsByTagName("td")[2];  // NID column
        var tdPhone = tr[i].getElementsByTagName("td")[3]; // Phone column
        var tdNotes = tr[i].getElementsByTagName("td")[4]; // Notes column
        
        if (tdName || tdNID || tdPhone || tdNotes) {
          var nameText = tdName.textContent || tdName.innerText;
          var nidText = tdNID.textContent || tdNID.innerText;
          var phoneText = tdPhone.textContent || tdPhone.innerText;
          var notesText = tdNotes.textContent || tdNotes.innerText;

          // Check if any of the columns match the search query
          if (
            nameText.toUpperCase().indexOf(filter) > -1 || 
            nidText.toUpperCase().indexOf(filter) > -1 || 
            phoneText.toUpperCase().indexOf(filter) > -1 || 
            notesText.toUpperCase().indexOf(filter) > -1
          ) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
      }
    }
  </script>
  <!-- Modal Data Script -->
  <script>
    function showDetails(name,nid,Bdate,gender,ContNum,FaName,FaNum,FaJop,MaName,MaNum,MaJop, notes) {
      document.getElementById('modalFullName').textContent = name;
      document.getElementById('modalNID').textContent = nid;
      document.getElementById('modalBD').textContent = Bdate;
      document.getElementById('modalGender').textContent = gender;
      document.getElementById('modalContPhone').textContent = ContNum;
      document.getElementById('modalFaN').textContent = FaName;
      document.getElementById('modalFaPhone').textContent = FaNum;
      document.getElementById('modalFaJop').textContent = FaJop;
      document.getElementById('modalMaN').textContent = MaName;
      document.getElementById('modalMaPhone').textContent = MaNum;
      document.getElementById('modalMaJop').textContent = MaJop;
      document.getElementById('modalNotes').textContent = notes;
    }
  </script>

</body>

</html>
<?php }  ?>
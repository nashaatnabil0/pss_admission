<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sportadmission']) == 0) {
  header('location:logout.php');
} else {

  if (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $sql = $pdoConnection->query("DELETE FROM enrollment WHERE ID='$rid'");

    if ($sql) {
      echo "<script>alert('Enroll Data deleted');</script>";
      echo "<script>window.location.href = 'viewall_enrollments.php'</script>";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Report | PSS Admission System</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Table CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.css">
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/filter-control/bootstrap-table-filter-control.min.css">
  
   <!-- Bootstrap CSS -->
   <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  
  <!-- font icon -->
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet">
</head>

<body>
  <!-- container section start -->
  <section id="container" class="">
    <!--header start-->
    <?php include_once('includes/header.php'); ?>
    <!--header end-->

    <!--sidebar start-->
    <?php include_once('includes/sidebar.php'); ?>
    <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-table"></i> Enrollments Reports</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="fa fa-table"></i> Enrollments</li>
              <li><i class="fa fa-th-list"></i> Reports</li>
            </ol>
          </div>
        </div>

        <!-- Toolbar Section for exporting and managing table -->
        <div id="toolbar">
          <input type="text" id="customSearch" placeholder="Search by Trainee Name or NID" class="form-control" style="margin-bottom: 10px;">
          <!-- <button id="export" class="btn btn-primary">Export Data</button> -->
          <button id="reset-filters" class="btn btn-warning">Reset Filters</button>

        </div>
        
        <!-- Table Start -->
        <table
          id="table"
          data-toggle="table"
          data-show-button-text="true"

          data-show-refresh="true"

          data-show-columns="true"
          data-show-columns-search="true"
          data-show-columns-toggle-all="true"
          data-show-toggle="true"

          data-show-export="true"

           data-filter-control="true"

          data-search="true"
          data-search-selector="#customSearch"

          data-buttons-align="right"

          data-locale="en-US" 
        >
        </table>
        <!-- Table End -->
      </section>
    </section>
    <!--main content end-->
    <?php include_once('includes/footer.php'); ?>
  </section>
  <!-- container section end -->

  <!-- Load jQuery first, then Bootstrap JS and other scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table-locale-all.min.js"></script>
  <!-- Table Export Plugin -->
  <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/tableExport.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/extensions/export/bootstrap-table-export.min.js"></script>

  <script>
    var $table = $('#table');

    function initTable(data) {
      $table.bootstrapTable('destroy').bootstrapTable({
        filterControl: true,  // تأكد من تفعيل الفلترة
        filterShowClear: true, // إظهار زر لمسح الفلاتر
        height: 500,
        locale: 'en-US',  // تأكيد استخدام اللغة الإنجليزية
        columns: [
          { title: 'ID', field: 'ID', align: 'center', sortable: true },
          { title: 'Name', field: 'Tname', align: 'center', sortable: true },
          { title: 'NID', field: 'traineeNID', align: 'center', sortable: true },
          { title: 'Group Title', field: 'Gtilte', align: 'center', sortable: true, filterControl: 'select' },
          { title: 'Payment State', field: 'paymentState', align: 'center', sortable: true, filterControl: 'select'  },
          { title: 'Discount', field: 'discount', align: 'center', sortable: true },
          { title: 'Enroll State', field: 'state', align: 'center', sortable: true, filterControl: 'select'  },
          { title: 'Days', field: 'Gdays', align: 'center', sortable: true },
          { title: 'Min Age', field: 'gminAge', align: 'center', sortable: true },
          { title: 'Max Age', field: 'gmaxAge', align: 'center', sortable: true },
          { title: 'Time Slot', field: 'Timing', align: 'center', sortable: true },
          { title: 'Sport Name', field: 'spname', align: 'center', sortable: true , filterControl: 'select' }
        ],
        data: data
      });
    }

    function fetchTableData() {
      $.ajax({
        url: 'api/enroll_report_getter.php', // Replace with actual backend endpoint
        method: 'GET',
        success: function (response) {
          initTable(response);
        },
        error: function () {
          alert('Failed to load data.');
        }
      });
    }

    $(function () {
      fetchTableData(); // Fetch data on page load

      // $('#export').click(function () {
      //   $table.bootstrapTable('togglePagination').tableExport({
      //     type: 'csv', // يمكنك استخدام 'xlsx' إذا كنت تريد تصدير Excel
      //     escape: false
      //   });
      // });
    });



  // Reset filters functionality
  $('#reset-filters').click(function() {
    $table.bootstrapTable('resetSearch', ''); // إعادة تعيين البحث
    $table.bootstrapTable('clearFilterControl'); // Clear all filters
    $table.bootstrapTable('resetView');          // Reset the table view to original state
  });


  </script>

</body>

</html>
<?php } ?>

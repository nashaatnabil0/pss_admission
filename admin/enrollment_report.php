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

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- Include DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <style>
        /* Ensure that the filter row dropdowns do not interfere with sorting controls */
        #filterRow th {
            padding: 5px;
        }
    </style>
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
            <h3 class="page-header"><i class="fa fa-table"></i>Report</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="fa fa-table"></i>Reports</li>
              <li><i class="fa fa-th-list"></i>Enrollments Report</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
            <div class="mb-2">
            <!-- Reset Filters Button -->
            <button id="resetFilters" class="btn btn-primary" style="  margin: 10px;">Reset Filters</button>
            
        </div>
          <table id="athleteTable" class="display table table-bordered" >
            <thead>
            <tr id="filterRow">
                    <th></th> <!-- Counter column (no filter) -->
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>    
            
            <tr>
                    <th>#</th> <!-- Counter column -->
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Sport</th>
                    <th>Training Group</th>
                    <th>Enrollment Date</th>
                </tr>
                
            </thead>
            <tbody>
                <!-- Dynamic content will be inserted here -->
            </tbody>
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


     <!-- Include jQuery -->
     <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- Include DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script> <!-- Column visibility plugin -->

    <!-- Include JSZip and pdfmake for Excel and PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- <script>
        $(document).ready(function() {
            // Initialize the DataTable
            $('#athleteTable').DataTable({
                "ajax": {
                    "url": "api/enroll_report_getter.php", // URL to fetch data from the server-side
                    "dataSrc": ""
                },
                "columns": [
                    { "data": "ID" },
                    { "data": "Tname" },
                    { "data": "traineeNID" },
                    { "data": "Gtilte" },
                    { "data": "paymentState" },
                    { "data": "state" }
                ],
                "order": [[ 0, "asc" ]], // Default sorting on the first column
                "dom": 'Bfrtip', // Add the Buttons above the table
                "buttons": [
                    'copy', 'csv', 'excel', 'pdf', 'print' // Add export and print buttons
                ]
            
           
              });



        });

        
    </script> -->

    <script>
        $(document).ready(function() {
            // Initialize the DataTable with Buttons extension
            var table = $('#athleteTable').DataTable({
                "ajax": {
                    "url": "api/enroll_report_getter.php", // URL to fetch data from server-side
                    "dataSrc": ""
                },
                "columns": [
                  { "data": null, "className": "dt-center", "orderable": false }, // Counter column
                    { "data": "ID" },
                    { "data": "Tname" },
                    { "data": "traineeNID" },
                    // { "data": "sport", "visible": false }, // Sport column (hidden by default)
                    { "data": "Gtilte" },
                    { "data": "paymentState" },
                    { "data": "state" }
                ],
                // "order": [[ 1, "asc" ]], // Default sorting on the first column
                "dom": 'Bfrtip', // Add the Buttons above the table
                "buttons": [
                    {
                        extend: 'copy',
                        className: 'btn btn-primary',
                        text: '<i class="fa fa-copy"></i> Copy'
                    },
                    {
                        extend: 'csv',
                        className: 'btn btn-success',
                        text: '<i class="fa fa-file-csv"></i> CSV'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-info',
                        text: '<i class="fa fa-file-excel"></i> Excel'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-danger',
                        text: '<i class="fa fa-file-pdf"></i> PDF'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-dark',
                        text: '<i class="fa fa-print"></i> Print'
                    },
                    {
                        extend: 'colvis',
                        className: 'btn btn-secondary',
                        text: '<i class="fa fa-eye"></i> Select Columns' // Button to control column visibility
                    }
                ],
                "responsive": true,
                "columnDefs": [
                    {
                        "targets": 0, // First column (counter)
                        "searchable": false,
                        "orderable": false,
                        "render": function (data, type, row, meta) {
                            return meta.row + 1; // Return row number
                        }
                    }
                ],
                initComplete: function() {
                    // Add dropdown filters for specific columns
                    this.api().columns().every(function(i) {
                        var column = this;
                        
                        // Only add filters to specific columns (e.g., Sport and Training Group)
                        if (i === 4 || i === 5 || i === 6) {  // Index 3 (Sport) and 4 (Training Group)
                            var select = $('<select><option value="">All</option></select>')
                                .appendTo($('#filterRow th').eq(i)) // Add the select to the filter row
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                });

                            // Populate the dropdown with unique values from the column
                            column.data().unique().sort().each(function(d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>');
                            });
                        }
                    });
                }
            });


            // Reset Filters Button Click Event
            $('#resetFilters').on('click', function() {
                // Clear all filters and reset the table
                table.columns().search('').draw();
                $('select').val('');  // Reset dropdowns
            });

        });
    </script>


  </body>

</html>
<?php }  ?>
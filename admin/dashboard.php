<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sportadmission']==0)) {
  header('location:logout.php');

  } 
  if ($_SESSION['role']=='accountant' ) {
    header('location:make_payment.php');
  
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>

  

  <title>Peace Sports School Admission System - Admin Dashboard</title>

  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <!-- full calendar css-->
  <link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
  <link href="assets/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" />
  <!-- easy pie chart-->
  <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen" />
  <!-- owl carousel -->
  <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">
  <link href="css/jquery-jvectormap-1.2.2.css" rel="stylesheet">
  <!-- Custom styles -->
  <link rel="stylesheet" href="css/fullcalendar.css">
  <link href="css/widgets.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet" />
  <link href="css/xcharts.min.css" rel=" stylesheet">
  <link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">
  <!-- =======================================================
    Theme Name: NiceAdmin
    Theme URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    Author: BootstrapMade
    Author URL: https://bootstrapmade.com
  ======================================================= -->
</head>

<body>
  <!-- container section start -->
  <section id="container" class="">


 <?php include_once('includes/header.php');?>
    <!--header end-->

    <!--sidebar start-->
    <?php include_once('includes/sidebar.php');?>
    <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <!--overview start-->
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-laptop"></i> Dashboard</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="fa fa-laptop"></i>Dashboard</li>
            </ol>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box brown-bg">
              <?php 
              $query=$pdoConnection-> query("Select * from season");
              $seasoncount = $query ->rowCount();  ?>
             <i class="fa fa-th-list"></i>
              <div class="count"><?php echo $seasoncount;?></div>
              <div class="title"> <a class="dropdown-item" href="viewall_seasons.php">All seasons</a></div>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->

          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box brown-bg">
              <?php 
               $query1=$pdoConnection-> query("Select * from sport");
               $sportscount = $query1 ->rowCount();
?>
              <i class="fa fa-flag"></i>
              <div class="count"><?php echo $sportscount;?></div>
              <div class="title"> <a class="dropdown-item" href="viewall_sports.php">All Sports</a></div>
            </div>
            <!--/.info-box-->
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box brown-bg">
              <?php 
               $query1=$pdoConnection-> query("Select * from trainers");
               $trainerscount = $query1 ->rowCount();
                ?>
              <i class="fa fa-users"></i>
              <div class="count"><?php echo $trainerscount;?></div>
              <div class="title"> <a class="dropdown-item" href="viewall_trainers.php">All Trainers</a></div>
            </div>
            <!--/.info-box-->
          </div>
        </div>
        <div class="row">
             <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box dark-bg">
              <?php 
              $query2=$pdoConnection-> query("Select * from trainees");
              $traineescount=$query2 ->rowCount();
              ?>
              <i class="fa fa-folder"></i>
              <div class="count"><?php echo $traineescount;?></div>
             <div class="title"> <a class="dropdown-item" href="viewall_trainees.php">All Trainees</a></div>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->

          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box dark-bg">
              <?php 
               $query2=$pdoConnection-> query("Select * from groups where state = 'open'");
               $groupscount=$query2  ->rowCount();
?>
              <i class="fa fa-list"></i>
              <div class="count"><?php echo $groupscount;?></div>
              <div class="title"> <a class="dropdown-item" href="viewall_groups.php">All Groups</a></div>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->

          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box dark-bg">
              <?php 
              $query2=$pdoConnection-> query("Select * from enrollment where state = 'on'");
              $enrollmentcount=$query2 ->rowCount();
              
             
?>
              <i class="fa fa-gears"></i>
              <div class="count"><?php echo $enrollmentcount;?></div>
             <div class="title"> <a class="dropdown-item" href="viewall_enrollments.php">All Enrollments</a></div>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->
         
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box dark-bg">
              <?php 
              $query2=$pdoConnection-> query("Select * from payment");
              $paymentcount=$query2 ->rowCount();
              
             
?>
              <i class="fa fa-money"></i>
              <div class="count"><?php echo $paymentcount;?></div>
             <div class="title"> <a class="dropdown-item" href="viewall_payments.php">All Payments</a></div>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->

         
        </div>
        <!--/.row-->
<?php include_once('includes/footer.php');?>


      </section>
     
    </section>
    <!--main content end-->
  </section>
  <!-- container section start -->

  <!-- javascripts -->
  <script src="js/jquery.js"></script>
  <script src="js/jquery-ui-1.10.4.min.js"></script>
  <script src="js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
  <!-- bootstrap -->
  <script src="js/bootstrap.min.js"></script>
  <!-- nice scroll -->
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
  <!-- charts scripts -->
  <script src="assets/jquery-knob/js/jquery.knob.js"></script>
  <script src="js/jquery.sparkline.js" type="text/javascript"></script>
  <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
  <script src="js/owl.carousel.js"></script>
  <!-- jQuery full calendar -->
  <<script src="js/fullcalendar.min.js"></script>
    <!-- Full Google Calendar - Calendar -->
    <!-- <script src="assets/fullcalendar/fullcalendar/fullcalendar.js"></script> -->
    <!--script for this page only-->
    <script src="js/calendar-custom.js"></script>
    <script src="js/jquery.rateit.min.js"></script>
    <!-- custom select -->
    <script src="js/jquery.customSelect.min.js"></script>
    <script src="assets/chart-master/Chart.js"></script>

    <!--custome script for all page-->
    <script src="js/scripts.js"></script>
    <!-- custom script for this page-->
    <script src="js/sparkline-chart.js"></script>
    <script src="js/easy-pie-chart.js"></script>
    <script src="js/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="js/jquery-jvectormap-world-mill-en.js"></script>
    <script src="js/xcharts.min.js"></script>
    <script src="js/jquery.autosize.min.js"></script>
    <script src="js/jquery.placeholder.min.js"></script>
    <script src="js/gdp-data.js"></script>
    <script src="js/morris.min.js"></script>
    <script src="js/sparklines.js"></script>
    <script src="js/charts.js"></script>
    <script src="js/jquery.slimscroll.min.js"></script>

    <!-- <script>
      //knob
      $(function() {
        $(".knob").knob({
          'draw': function() {
            $(this.i).val(this.cv + '%')
          }
        })
      });

      //carousel
      $(document).ready(function() {
        $("#owl-slider").owlCarousel({
          navigation: true,
          slideSpeed: 300,
          paginationSpeed: 400,
          singleItem: true

        });
      });

      //custom select box

      $(function() {
        $('select.styled').customSelect();
      });

      /* ---------- Map ---------- */
      $(function() {
        $('#map').vectorMap({
          map: 'world_mill_en',
          series: {
            regions: [{
              values: gdpData,
              scale: ['#000', '#000'],
              normalizeFunction: 'polynomial'
            }]
          },
          backgroundColor: '#eef3f7',
          onLabelShow: function(e, el, code) {
            el.html(el.html() + ' (GDP - ' + gdpData[code] + ')');
          }
        });
      });
    </script> -->

</body>

</html>

<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
// $sql = "SELECT photo_path FROM photos";
// $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);
        
        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <meta charset="utf-8">
    <title>P.S.S - Contact Us</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="https://cdn0.iconfinder.com/data/icons/sports-59/512/Soccer-1024.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <style>


.heading_container {
    text-align: center;
}

.home-button {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #063547;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

        </style>
</head>

<body>

    <!-- Header Start -->
    <?php include('includes/header.php'); ?>
    <!-- Header End -->

    <div class="container">
      <div class="heading_container heading_center ">
        <h2>
          Thank you for contacting us!<br> We will make sure to reply to you soon.
        </h2>

      <br>
      <br>
      <div style="text-align: center;">
      <a href="index.php" class="btn btn-primary py-3 px-4 rounded" type="button">Go To Home Page</a>

      </div>
      </div>
    </div>


         <!-- Footer Start -->
         <?php include('includes/footer.php'); ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>    
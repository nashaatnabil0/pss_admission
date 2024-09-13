<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
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
    <title>P.S.S - Home</title>
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
.content-section {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 20px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
}

.photo-section {
    flex: 1;
    max-width: 100%; 
    overflow: hidden; 
}

.photo-section img {
    width: 100%;
    height: auto;
    border-radius: 10px; 
}

        .content-section .text-section {
            flex: 2;
            padding-left: 20px;
        }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            padding: 20px;
        }

        .image-grid img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <!-- Header Start -->
    <?php include('includes/header.php'); ?>
    <!-- Header End -->

    <!-- New Content Section Start -->
    <div class="content-section">
        <div class="photo-section">
            <img src="img/new.jpg" alt="new">
        </div>
        <div class="text-section">
            <h2>New Season Announcement</h2>
            <p>𝗣𝗲𝗮𝗰𝗲 𝗦𝗽𝗼𝗿𝘁𝘀 𝗦𝗰𝗵𝗼𝗼𝗹 🏆
‏Soccer For Girls ⚽️
‏Summer 2024 ☀️
‏‎متحمسين جداً اننا نبدأ سوا تمرين جديد💥
‏‎كرة قدم للبنات 🥳⚽️
‏‎ولأن رؤيتنا هي مش بس تعليم مهارات الاساسية للرياضيات المختلفة لكن كمان هي زرع مبادئ مسيحية في حياة كل لاعب و لاعبة 🌟
بنات من سن 14-20 سنة 
‏‎</p>
    </br>
    <div class="text-center">
    <a href="login.php" class="btn btn-primary py-1 px-2" style="font-size: 1.5rem;">Enroll Now</a>
</div>
    <!-- <a href="login.php" class="btn btn-primary py-2 px-4 d-block d-lg-none">Enroll Now</a> -->


            <!-- <p>Our portfolio showcases a diverse range of projects that highlight our ability to create unique and memorable designs.</p> -->
        </div>
    </div>
    <!-- New Content Section End -->

    <div class="image-grid">
        <img src="img/image1.jpg" alt="Image 1">
        <img src="img/image2.jpg" alt="Image 2">
        <img src="img/image3.jpg" alt="Image 3">
        <img src="img/image4.jpg" alt="Image 4">
        <img src="img/image5.jpg" alt="Image 5">
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

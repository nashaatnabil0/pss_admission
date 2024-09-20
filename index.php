<?php
session_start();
error_reporting(0);

// Database connection using PDO
try {
    $dsn = "mysql:host=localhost;dbname=sportadmission";
    $username = "root";
    $password = "";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
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
        .grid-img:hover {
            transform: scale(1.05);
        }

        .lightbox {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.8);
                justify-content: center;
                align-items: center;
            }
            
        .lightbox-img {
            max-width: 90%;
            max-height: 90%;
            }

            .close {
                position: absolute;
                top: 20px;
                right: 20px;
                font-size: 30px;
                color: white;
                cursor: pointer;
            }

    </style>
</head>

<body>

    <!-- Header Start -->
    <?php include('includes/header.php'); ?>
    <!-- Header End -->

    <!-- New Content Section Start -->
    <?php
    try {
        $query = "SELECT * FROM season WHERE state = 'on' ORDER BY startDate DESC LIMIT 1";
        $stmt = $pdo->query($query);

        if ($row = $stmt->fetch()) {
    ?>
    <div class="content-section d-flex flex-column flex-md-row align-items-center justify-content-between">

    <div class="photo-section mb-4 mb-md-0">
    <img src="admin/images/<?php echo htmlspecialchars($row['image']); ?>" alt="Season Image" class="img-fluid" style="max-width: 100%; height: auto;">
    </div>
    <div class="text-section text-center text-md-left">
        <h1 >New Season open!</h1>
        <h2><?php echo htmlspecialchars($row['name']); ?></h2>
        <p><strong>Start Date:</strong> <?php echo date('F d, Y', strtotime($row['startDate'])); ?></p>
        <br />
            <a href="login.php" class="btn btn-primary py-2 px-2">Enroll Now</a>
    </div>
    <?php
        } else {
            // echo "<p>No seasons available at the moment.</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</div>



    <!-- New Content Section End -->

    <div class="image-grid">
    <img src="img/image1.jpg" alt="Image 1" class="grid-img">
    <img src="img/image2.jpg" alt="Image 2" class="grid-img">
    <img src="img/image3.jpg" alt="Image 3" class="grid-img">
    <img src="img/image4.jpg" alt="Image 4" class="grid-img">
    <img src="img/image5.jpg" alt="Image 5" class="grid-img">
</div>

<!-- Lightbox overlay -->
<div id="lightbox" class="lightbox">
    <span class="close">&times;</span>
    <img class="lightbox-img" id="expanded-img">
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

    <script>
        // Get elements
const images = document.querySelectorAll('.grid-img');
const lightbox = document.getElementById('lightbox');
const expandedImg = document.getElementById('expanded-img');
const closeBtn = document.querySelector('.close');

// Add click event for each image
images.forEach(image => {
    image.addEventListener('click', function() {
        lightbox.style.display = 'flex';
        expandedImg.src = this.src;
    });
});

// Close the lightbox
closeBtn.addEventListener('click', function() {
    lightbox.style.display = 'none';
});

// Close lightbox when clicking outside of the image
lightbox.addEventListener('click', function(e) {
    if (e.target !== expandedImg) {
        lightbox.style.display = 'none';
    }
});

    </script>
</body>
</html>

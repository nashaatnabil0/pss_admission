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
            width: 80%;
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
            width: 80%;
            height: auto;
            border-radius: 10px;
        }
        .grid-img:hover {
    transform: scale(1.05);
}

/* Ensure each item in the carousel has a proper structure */
.owl-carousel .item {
    display: flex;
    flex-direction: column; /* Stack title and image vertically */
    align-items: center; /* Center both title and image */
}

/* Style for the image title */
.slider-title {
    font-weight: bold;
    text-align: center;
    margin-bottom: 10px; /* Space between title and image */
    font-size: 1.2em;
}

/* Fixed size for the images */
.owl-carousel .item img {
    width: 300px; /* Set a fixed width */
    height: 200px; /* Set a fixed height */
    object-fit: cover; /* Ensure images fill the set size without distortion */
    border-radius: 10px;
}


.owl-prev, .owl-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%); /* Vertically center the buttons */
    background-color: #FF4800; /* Semi-transparent background */
    border-radius: 50%;
    color: white;
    padding: 10px;
    cursor: pointer;
    font-size: 24px;
    z-index: 1000;
}

.owl-prev {
    left: 10px; /* Move the previous button to the left side */
}

.owl-next {
    right: 10px; /* Move the next button to the right side */
}

.owl-prev:hover, .owl-next:hover {
    background-color: rgba(0, 0, 0, 0.8); /* Darker background on hover */
}




/* Lightbox styles */
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
    z-index: 1000;  /*lightbox appear on top*/ 
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

    <div class="owl-carousel owl-theme">
    <?php
    // Fetch images from the database
    try {
        $query = "SELECT * FROM slider_images";
        $stmt = $pdo->query($query);
        
        // Loop through the results and display images in the slider
        while ($row = $stmt->fetch()) {
            echo '<div class="item">';
            if (!empty($row['title'])) {
                echo '<h3 class="slider-title">' . htmlspecialchars($row['title']) . '</h3>';
            }
            echo '<img src="admin/images/' . htmlspecialchars($row['image']) . '" alt="Image" class="grid-img">';
            echo '</div>';
        }
        
    } catch (PDOException $e) {
        echo "Error fetching images: " . $e->getMessage();
    }
    ?>
</div>



<!-- Lightbox overlay -->
<div id="lightbox" class="lightbox">
    <span class="close">&times;</span>
    <img class="lightbox-img" id="expanded-img">
</div>

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

        <!-- Language Function -->
        <script src="js/lang.js"></script>

        <script>
$(document).ready(function(){
    $('.owl-carousel').owlCarousel({
        loop: true, // Loop through the images
        margin: 10,
        nav: true,  // Enable navigation arrows
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],  // Add custom icons
        autoplay: true,  // Enable auto-play
        autoplayTimeout: 5000,  // 5000ms = 5 seconds
        autoplayHoverPause: true,  // Pause on hover
        items: 1,  // Display one image at a time
        responsive:{
            0:{ items: 1 },
            600:{ items: 1 },
            1000:{ items: 1 }
        }
    });
});


        </script>

</body>
</html>

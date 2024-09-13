<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Check if the user is logged in. If not, redirect to the login page.
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Establish a PDO connection to db
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sportadmission";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

try {
    $sql = "SELECT * FROM trainees WHERE NID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Handle case where no user is found (e.g., user does not exist)
        echo "No user data found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

// Close db connection
$conn = null;
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
    <title>P.S.S - User Account</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="User Account Page" name="keywords">
    <meta content="User Account Page" name="description">

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
</head>

<body>

    <!-- Header Start -->
    <!-- Topbar Start -->
    <div class="container-fluid bg-dark">
        <div class="row py-2 px-lg-5">
            <div class="col-lg-6 text-center text-lg-left mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center text-white">
                    <small><i class="fa fa-phone-alt mr-2"></i>+01205557683</small>
                    <small class="px-3">|</small>
                    <small><i class="fa fa-envelope mr-2"></i>pssassiut1@gmail.com</small>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-white px-2" href="https://www.facebook.com/people/Peace-Sports-School-Assuit/100091623236982/">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <!-- <a class="text-white px-2" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-white px-2" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a> -->
                    <a class="text-white px-2" href="https://www.instagram.com/pss_assuit/">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <!-- <a class="text-white pl-2" href="">
                        <i class="fab fa-youtube"></i>
                    </a> -->
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-lg-5">
            <a href="index.php" class="navbar-brand ml-lg-3">
            <img src="img/aabout.jpg" alt="P.S.S Logo" class="img-fluid" style="max-height: 130px;"> 
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
                <div class="navbar-nav m-auto py-0">
                    <a href="index.php" class="nav-item nav-link active">Home</a>
                    <a href="about.php" class="nav-item nav-link">About</a>
                    <!-- <a href="login.php" class="nav-item nav-link">Login</a>
                    <a href="account.php" class="nav-item nav-link">Account</a> -->
                    
                    <!-- <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="blog.html" class="dropdown-item">Blog Grid</a>
                            <a href="single.html" class="dropdown-item">Blog Detail</a>
                        </div>
                    </div> -->
                    <a href="contact.php" class="nav-item nav-link">Contact</a>

        </nav>
    </div>    <!-- Header End -->

    <!-- User Account Section Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <h2 class="text-center mb-4">User Account</h2>
            <div class="row">
                <div class="col-lg-4">
                    <div class="bg-light p-4 rounded">
                        <h4 class="text-primary">Personal Information</h4>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['Name']); ?></p>
                        <p><strong>Birth Date:</strong> <?php echo htmlspecialchars($user['birthDate']); ?></p>
                        <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
                        <p><strong>Contact Mobile Number:</strong> <?php echo htmlspecialchars($user['contactMobNum']); ?></p>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="bg-light p-4 rounded">
                        <h4 class="text-primary">Family Information</h4>
                        <p><strong>Father's Name:</strong> <?php echo htmlspecialchars($user['fatherName']); ?></p>
                        <p><strong>Father's Mobile Number:</strong> <?php echo htmlspecialchars($user['fatherMobNum']); ?></p>
                        <p><strong>Father's Job:</strong> <?php echo htmlspecialchars($user['fatherJob']); ?></p>
                        <p><strong>Mother's Name:</strong> <?php echo htmlspecialchars($user['motherName']); ?></p>
                        <p><strong>Mother's Mobile Number:</strong> <?php echo htmlspecialchars($user['motherMobNum']); ?></p>
                        <p><strong>Mother's Job:</strong> <?php echo htmlspecialchars($user['motherJob']); ?></p>
                        <p><strong>Notes:</strong> <?php echo htmlspecialchars($user['Notes']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- User Account Section End -->

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
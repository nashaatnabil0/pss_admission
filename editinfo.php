<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Check if the user is logged in. If not, redirect to the login page.
// if (!isset($_SESSION['user_id'])) {
//     header('Location: login.php');
//     exit();
// }

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $contactMobNum = $_POST['contactMobNum'];
    $fatherName = $_POST['fatherName'];
    $fatherMobNum = $_POST['fatherMobNum'];
    $fatherJob = $_POST['fatherJob'];
    $motherName = $_POST['motherName'];
    $motherMobNum = $_POST['motherMobNum'];
    $motherJob = $_POST['motherJob'];
    $notes = $_POST['notes'];

    try {
        $sql = "UPDATE trainees SET Name = ?, contactMobNum = ?, fatherName = ?, fatherMobNum = ?, fatherJob = ?, motherName = ?, motherMobNum = ?, motherJob = ?, Notes = ? WHERE NID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $contactMobNum, $fatherName, $fatherMobNum, $fatherJob, $motherName, $motherMobNum, $motherJob, $notes, $user_id]);

        // Redirect to account.php after successful update
        header('Location: account.php');
        exit(); // Make sure to exit after redirection
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
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
    <title>P.S.S - Login</title>
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
                .center-text {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 30vh; /* Full viewport height */
            text-align: center;
            flex-direction: column; /* Stack elements vertically */
        }
        </style>
</head>

<body>

    <!-- Header Start -->
    <?php include('includes/header.php'); ?>
    <!-- Header End -->
    <!-- User Account Section Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <h2 class="text-center mb-4">User Account</h2>
            <div class="row">
                <div class="col-lg-4">
                    <div class="bg-light p-4 rounded">
                        <h4 class="text-primary">Personal Information</h4>
                        <form method="post">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['Name']); ?>" >
                            </div>

                            <div class="form-group">
                                <label for="contactMobNum">Contact Mobile Number:</label>
                                <input type="text" class="form-control" id="contactMobNum" name="contactMobNum" value="<?php echo htmlspecialchars($user['contactMobNum']); ?>" >
                            </div>

                            <div class="form-group">
                                <label for="birthDate">Birth Date:</label>
                                <input type="text" class="form-control" id="birthDate" value="<?php echo htmlspecialchars($user['birthDate']); ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="gender">Gender:</label>
                                <input type="text" class="form-control" id="gender" value="<?php echo htmlspecialchars($user['gender']); ?>" readonly>
                            </div>

                            <h4 class="text-primary mt-4">Family Information</h4>
                            <div class="form-group">
                                <label for="fatherName">Father's Name:</label>
                                <input type="text" class="form-control" id="fatherName" name="fatherName" value="<?php echo htmlspecialchars($user['fatherName']); ?>" >
                            </div>

                            <div class="form-group">
                                <label for="fatherMobNum">Father's Mobile Number:</label>
                                <input type="text" class="form-control" id="fatherMobNum" name="fatherMobNum" value="<?php echo htmlspecialchars($user['fatherMobNum']); ?>" >
                            </div>

                            <div class="form-group">
                                <label for="fatherJob">Father's Job:</label>
                                <input type="text" class="form-control" id="fatherJob" name="fatherJob" value="<?php echo htmlspecialchars($user['fatherJob']); ?>" >
                            </div>

                            <div class="form-group">
                                <label for="motherName">Mother's Name:</label>
                                <input type="text" class="form-control" id="motherName" name="motherName" value="<?php echo htmlspecialchars($user['motherName']); ?>" >
                            </div>

                            <div class="form-group">
                                <label for="motherMobNum">Mother's Mobile Number:</label>
                                <input type="text" class="form-control" id="motherMobNum" name="motherMobNum" value="<?php echo htmlspecialchars($user['motherMobNum']); ?>" >
                            </div>

                            <div class="form-group">
                                <label for="motherJob">Mother's Job:</label>
                                <input type="text" class="form-control" id="motherJob" name="motherJob" value="<?php echo htmlspecialchars($user['motherJob']); ?>" >
                            </div>

                            <div class="form-group">
                                <label for="notes">Notes:</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"><?php echo htmlspecialchars($user['Notes']); ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
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

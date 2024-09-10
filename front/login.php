<?php
session_start();
error_reporting(0);

// Include the PDO database connection file
include('includes/dbconnection.php'); // Make sure this file contains the $pdoConnection variable

// Use the existing PDO connection from the included file
$conn = $pdoConnection;  // Reusing the connection from dbconnection.php

// Initialize a message variable
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the user's entered NID
    $entered_nid = isset($_POST['nid']) ? trim($_POST['nid']) : '';

    // Validate input
    if (empty($entered_nid)) {
        $message = "Please enter a valid NID.";
    } else {
        try {
            // Prepare and execute the query to check if the NID exists
            $sql = "SELECT NID FROM trainees WHERE NID = :nid";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nid', $entered_nid, PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if the NID is already available in the database
            if ($row) { // If a row is found, the NID exists
                // Set the session for the logged-in user
                $_SESSION['user_id'] = $entered_nid;

                // Redirect to account.php if NID is registered
                header("Location: account.php");
                exit(); // Stop further script execution
            } else {
                // Redirect to register.php if NID is not registered
                header("Location: register.php");
                exit(); // Stop further script execution
            }
        } catch (PDOException $e) {
            // Handle any potential exceptions
            $message = "An error occurred: " . $e->getMessage();
        }
    }
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

    <!-- <div class="jumbotron jumbotron-fluid mb-5"> -->
        <!-- <div class="container text-center py-5"> -->
        <div class="center-text">
        <h1 class="text-primary mb-4">To enroll / register:</h1>
        <h1 class="text-white display-3 mb-5" style="color: black !important;">Enter Your National ID Number</h1>
    </div>
            <div class="mx-auto" style="width: 100%; max-width: 600px;">
                <form method="post" action="">
                    <div class="input-group">
                        <input type="text" name="nid" class="form-control border-light" style="padding: 30px;" placeholder="Enter NID">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary px-3">Submit</button>
                        </div>
                    </div>
                </form>
                <?php if ($message): ?>
                    <div class="alert alert-info mt-3"><?php echo $message; ?></div>
                <?php endif; ?>
            </div>
        <!-- </div>
    </div> -->

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

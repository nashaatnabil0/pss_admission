<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');  

// Allowed extensions
$allowed_extensions = array (".jpg", "jpeg", ".png", ".gif");

// Function to handle image uploads
function uploadImages($imageFile, $allowed_extensions) {
    if ($imageFile["name"] != "") {
        $extension = strtolower(substr($imageFile["name"], strrpos($imageFile["name"], '.')));
        if (in_array($extension, $allowed_extensions)) {
            $newImageName = md5($imageFile["name"]) . time() . $extension;
            move_uploaded_file($imageFile["tmp_name"], "images/" . $newImageName);
            return $newImageName;
        } else {
            echo "<script>alert('Image " . $imageFile["name"] . " has an invalid format. Only jpg / jpeg / png / gif formats are allowed.');</script>";
            return null;
        }
    }
    return null;
}

// Initialize message variable
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['registerName'];
    $nid = $_POST['NID'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $fatherName = $_POST['fatherName'];
    $fatherNum = $_POST['fatherNum'];
    $fatherJob = $_POST['fatherJob'];
    $motherName = $_POST['motherName'];
    $motherNum = $_POST['motherNum'];
    $motherJob = $_POST['motherJob'];
    $notes = isset($_POST['notes']) ? $_POST['notes'] : '';  // Assuming 'notes' is an optional field
    $contactMobNum = $_POST['contactMobNum'];  // Add a new field if it is in the form

    // Upload the images
    $personalPhoto = uploadImages($_FILES['personalPhoto'], $allowed_extensions);
    $idPhoto = uploadImages($_FILES['idPhoto'], $allowed_extensions);

    // Check if all required fields are filled
    if (!empty($name) && !empty($nid) && !empty($gender) && !empty($dob) && !empty($fatherName) && !empty($fatherNum) && !empty($fatherJob) && !empty($motherName) && !empty($motherNum) && !empty($motherJob) && $personalPhoto !== null && $idPhoto !== null) {
        $sql = "INSERT INTO trainees (Name, NID, birthDate, gender, photo, birthCertificate, contactMobNum, fatherName, fatherMobNum, fatherJob, motherName, motherMobNum, motherJob, Notes) 
                VALUES ('$name', '$nid','$dob', '$gender', '$personalPhoto', '$idPhoto', '$contactMobNum', '$fatherName', '$fatherNum', '$fatherJob', '$motherName', '$motherNum', '$motherJob', '$notes')";
        
        $query = $pdoConnection->query($sql);
       /* $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':nid', $nid, PDO::PARAM_STR);
        $query->bindParam(':birthDate', $birthDate, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':photo', $personalPhoto, PDO::PARAM_STR);
        $query->bindParam(':birthCertificate', $idPhoto, PDO::PARAM_STR);
        $query->bindParam(':contactMobNum', $contactMobNum, PDO::PARAM_STR);
        $query->bindParam(':fatherName', $fatherName, PDO::PARAM_STR);
        $query->bindParam(':fatherMobNum', $fatherNum, PDO::PARAM_STR);
        $query->bindParam(':fatherJob', $fatherJob, PDO::PARAM_STR);
        $query->bindParam(':motherName', $motherName, PDO::PARAM_STR);
        $query->bindParam(':motherMobNum', $motherNum, PDO::PARAM_STR);
        $query->bindParam(':motherJob', $motherJob, PDO::PARAM_STR);
        $query->bindParam(':notes', $notes, PDO::PARAM_STR);*/

        // Execute query
        if ($query) {
            echo "<script>alert('Registration successful!');</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Please fill all the fields correctly and upload all required images.');</script>";
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
    <title>P.S.S - Register</title>
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
</head>

<body>
    <!--header section start -->
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
                    <a class="text-white pl-2" href="https://wa.me/201205557683">
                        <i class="fab fa-whatsapp"></i>
                    </a>
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
    </div>    <!-- header section end -->

    <div class="container">
        <h2 class="about_text_2"><strong>In order to enroll, please register first!</strong></h2>
        <section class="login_register_section layout_padding">
            <div class="container">
                <div class="heading_container heading_center">
                    <p>
                        *Please fill all the fields.
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="register_form">
                            <form id="registerForm" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="registerName">*Full Name</label>
                                    <input type="text" class="form-control" name="registerName" id="registerName" placeholder="Enter full name" required>
                                </div>
                                <div class="form-group">
                                    <label for="NID">*National ID</label>
                                    <input
                                    type="text"
                                    class="form-control"
                                    name="NID"
                                    id="NID"
                                    placeholder="Enter your National ID"
                                    required>
                                    <!-- Error message placeholder -->
                                     <span id="nidError" style="color: red; display: none;">Please enter a valid 14-digit National ID where the 4th and 5th digits form a number less than or equal to 12, and the 6th and 7th digits form a number less than or equal to 31.</span>
                                    </div>

                                <div class="form-control">
                                    <label for="gender" class="form-label">*Gender</label> 
                                    <input type="radio" name="gender" value="male" required>Male
                                    <input type="radio" name="gender" value="female" required>Female
                                </div> <br>
                                <div class="form-group">
                                    <label for="phoneNum">*Enter phone number that has WhatsApp</label>
                                    <input type="text" class="form-control" name="contactMobNum" id="contactMobNum" placeholder="Enter phone number" required>
                                </div>
                                <div class="form-group">
                                    <label for="dob">*Date of Birth</label>
                                    <input type="date" class="form-control" name="dob" id="dob" required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">*Personal Photo</label>
                                    <input type="file" class="form-control" name="personalPhoto" id="personalPhoto" required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">*National ID/Birth Certificate Photo</label>
                                    <input type="file" class="form-control" name="idPhoto" id="idPhoto" required>
                                </div>
                                <div class="form-group">
                                    <label for="fatherName">*Father Name</label>
                                    <input type="text" class="form-control" name="fatherName" id="fatherName" placeholder="Enter father name" required>
                                </div>
                                <div class="form-group">
                                    <label for="fatherNum">*Father Phone Number</label>
                                    <input type="text" class="form-control" name="fatherNum" id="fatherNum" placeholder="Enter father phone number" required>
                                </div>
                                <div class="form-group">
                                    <label for="fatherJob">*Father Job</label>
                                    <input type="text" class="form-control" name="fatherJob" id="fatherJob" placeholder="Enter father job" required>
                                </div>
                                <div class="form-group">
                                    <label for="motherName">*Mother Name</label>
                                    <input type="text" class="form-control" name="motherName" id="motherName" placeholder="Enter mother name" required>
                                </div>
                                <div class="form-group">
                                    <label for="motherNum">*Mother Phone Number</label>
                                    <input type="text" class="form-control" name="motherNum" id="motherNum" placeholder="Enter mother phone number" required>
                                </div>
                                <div class="form-group">
                                    <label for="motherJob">*Mother Job</label>
                                    <input type="text" class="form-control" name="motherJob" id="motherJob" placeholder="Enter mother job" required>
                                </div>
                                <div class="control-group">
                                <textarea class="form-control border-1 py-3 px-4" rows="3" id="Notes" name ="notes" placeholder="Notes"
                                    
                                    data-validation-required-message="If you have notes regarding health or any thing, please write it here."></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                                <div>
                                <button type="submit" style="background-color: #063547" class="btn btn-primary">Register</button>
                            </form>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

        <!-- footer section start -->
        <?php include('includes/footer.php'); ?>
        <!-- footer section end -->
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
    document.addEventListener("DOMContentLoaded", function () {
        const nidInput = document.getElementById("NID");
        const nidError = document.getElementById("nidError");

        // Regular expression for validating National ID
        const nidPattern = /^\d{3}(0[0-9]|1[0-2])([0-2][0-9]|3[01])\d{7}$/;

        nidInput.addEventListener("input", function () {
            // Check if the input value matches the pattern
            if (!nidPattern.test(nidInput.value)) {
                nidError.style.display = "block"; // Show error message
            } else {
                nidError.style.display = "none"; // Hide error message
            }
        });
    });
</script>

</body>

</html>

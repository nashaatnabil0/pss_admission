<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');  

// Allowed extensions
$allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");

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

    // Upload the images
    $personalPhoto = uploadImages($_FILES["personalPhoto"], $allowed_extensions);
    $idPhoto = uploadImages($_FILES["idPhoto"], $allowed_extensions);

    // Check if all required fields are filled
    if (!empty($name) && !empty($nid) && !empty($gender) && !empty($dob) && !empty($fatherName) && !empty($fatherNum) && !empty($fatherJob) && !empty($motherName) && !empty($motherNum) && !empty($motherJob) && $personalPhoto !== null && $idPhoto !== null) {
        $sql = "INSERT INTO trainees (name, nid, gender, dob, personal_photo, id_photo, father_name, father_num, father_job, mother_name, mother_num, mother_job) 
                VALUES (:name, :nid, :gender, :, :dob, :personal_photo, :id_photo, :father_name, :father_num, :father_job, :mother_name, :mother_num, :mother_job)";
        
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':nid', $nid, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':personal_photo', $personalPhoto, PDO::PARAM_STR);
        $query->bindParam(':id_photo', $idPhoto, PDO::PARAM_STR);
        $query->bindParam(':father_name', $fatherName, PDO::PARAM_STR);
        $query->bindParam(':father_num', $fatherNum, PDO::PARAM_STR);
        $query->bindParam(':father_job', $fatherJob, PDO::PARAM_STR);
        $query->bindParam(':mother_name', $motherName, PDO::PARAM_STR);
        $query->bindParam(':mother_num', $motherNum, PDO::PARAM_STR);
        $query->bindParam(':mother_job', $motherJob, PDO::PARAM_STR);

        // Execute query
        if ($query->execute()) {
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
    <?php include('includes/header.php'); ?>
    <!-- header section end -->

    <div class="container">
        <h1 class="about_text_2"><strong>Register</strong></h1>
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
                                    <label for="registerName">Full Name</label>
                                    <input type="text" class="form-control" name="registerName" id="registerName" placeholder="Enter full name" required>
                                </div>
                                <div class="form-group">
                                    <label for="NID">National ID</label>
                                    <input
                                    type="text"
                                    class="form-control"
                                    name="NID"
                                    id="NID"
                                    placeholder="Enter your National ID"
                                    required
                                    pattern="^\d{3}(0[0-9]|1[0-2])([0-2][0-9]|3[01])\d{7}$"
                                    title="Please enter a 14-digit National ID where the 4th and 5th digits form a number less than or equal to 12, and the 6th and 7th digits form a number less than or equal to 31.">
                                </div>

                                <div class="form-control">
                                    <label for="gender" class="form-label">Gender</label> 
                                    <input type="radio" name="gender" value="male" required>Male
                                    <input type="radio" name="gender" value="female" required>Female
                                </div> <br>
                                <div class="form-group">
                                    <label for="phoneNum">Enter phone number that has WhatsApp</label>
                                    <input type="text" class="form-control" name="phonerNum" id="phonerNum" placeholder="Enter phone number" required>
                                </div>
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" class="form-control" name="dob" id="dob" required>
                                </div>
                                <div class="form-group">
    <label class="control-label">Personal Photo</label>
    <input type="file" class="form-control" name="personalPhoto" id="personalPhoto" required>
</div>
<div class="form-group">
    <label class="control-label">National ID/Birth Certificate Photo</label>
    <input type="file" class="form-control" name="idPhoto" id="idPhoto" required>
</div>
                                <div class="form-group">
                                    <label for="fatherName">Father Name</label>
                                    <input type="text" class="form-control" name="fatherName" id="fatherName" placeholder="Enter father name" required>
                                </div>
                                <div class="form-group">
                                    <label for="fatherNum">Father Phone Number</label>
                                    <input type="text" class="form-control" name="fatherNum" id="fatherNum" placeholder="Enter father phone number" required>
                                </div>
                                <div class="form-group">
                                    <label for="fatherJob">Father Job</label>
                                    <input type="text" class="form-control" name="fatherJob" id="fatherJob" placeholder="Enter father job" required>
                                </div>
                                <div class="form-group">
                                    <label for="motherName">Mother Name</label>
                                    <input type="text" class="form-control" name="motherName" id="motherName" placeholder="Enter mother name" required>
                                </div>
                                <div class="form-group">
                                    <label for="motherNum">Mother Phone Number</label>
                                    <input type="text" class="form-control" name="motherNum" id="motherNum" placeholder="Enter mother phone number" required>
                                </div>
                                <div class="form-group">
                                    <label for="motherJob">Mother Job</label>
                                    <input type="text" class="form-control" name="motherJob" id="motherJob" placeholder="Enter mother job" required>
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

</body>

</html>

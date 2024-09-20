<?php
error_reporting(0);
include('includes/dbconnection.php');  

try {
    if(isset($_GET['nid'])){
    $user_id = $_GET['nid'];
    }else{
        echo "<script>location.href='index.php'</script>";
    }
    $sql = "SELECT * FROM trainees WHERE NID = ?";
    $stmt = $pdoConnection->prepare($sql);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Handle case where no user is found (e.g., user does not exist)
        echo "<script>alert('There is a ready account for you! You can enroll if it is available or you can edit your profile');  location.href='login.php'</script>";
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
        $nationalId = $_GET['nid'];

    // Extract birth date from the ID (assuming a specific format)
        $gen = substr($nationalId, 0, 1);
        $birthDate = substr($nationalId, 1, 6);
        $birthYear = substr($birthDate, 0, 2);
        $birthMonth = substr($birthDate, 2, 2);
        $birthDay = substr($birthDate, 4, 2);

        // Calculate the birth date as a DateTime object
        $birthDate = new DateTime("$birthYear-$birthMonth-$birthDay");

        // Get the current date
        $currentDate = new DateTime();

        // Calculate the age in years
        $age = $currentDate->diff($birthDate)->y;
        if($gen ==2){
            $dateOfBirthFormatted = "19$birthYear-$birthMonth-$birthDay";
        }else{
            $dateOfBirthFormatted = "20$birthYear-$birthMonth-$birthDay";
        }

        $genderDigit = $nationalId[12]; // Get the 13th digit (index 12)
    // end of extract birthdate

    $allowed_extensions = ["jpg", "jpeg", "png", "gif"];

   
    function uploadImages($imageFile, $name, $NID ) {
      
      if ($imageFile["name"] != "") {
        $extension = strtolower(pathinfo($imageFile["name"], PATHINFO_EXTENSION));
              $newImageName = $NID .'-'. $name. '.' . $extension;
              move_uploaded_file($imageFile["tmp_name"], "admin/images/" . $newImageName);
              return $newImageName;
          } else {
            return null;
          }
      
      return null;
    }

    function checkExtensions($imageFile, $allowed_extensions, $fileInputName ) {
      if ($imageFile["name"] != "") {
          $extension = strtolower(pathinfo($imageFile["name"], PATHINFO_EXTENSION));
          if (!in_array($extension, $allowed_extensions)) {
            $errors[$fileInputName] = "Invalid format. Only jpg / jpeg / png / gif format allowed.";
          }
      }
    }

 $errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $mobnumPattern = '/^(011|010|015|012)[0-9]{8}$/';
    $namePattern = '/^([a-zA-Z]+(?:\s+[a-zA-Z]+)*|[\p{Arabic}]+(?:\s+[\p{Arabic}]+)*)$/u';
    $name = trim($_POST['registerName']);
    if (empty($name)) {
        $errors['Name'] = "Name cannot be empty";
    }elseif (!preg_match( $namePattern , $name)) {
        $errors['Name'] = "Name must be two words at least and contain letters only ";
     }

    $nid = $nationalId;
    if ($genderDigit % 2 == 0) { $gender = "female"; }else $gender="male";
    $dob = $_POST['dob'];

    $contactMobNum = trim($_POST['contactMobNum']);  
    if (empty($contactMobNum)) {
        $errors['contactMobNum'] = "Phone number cannot be empty";
    } elseif (!preg_match($mobnumPattern, $contactMobNum)) {
        $errors['contactMobNuminvalid'] = "Invalid phone number format Must be 11 digits & start with (012 / 011 / 015 / 010)";
    }

    // Father
    $fatherName = trim($_POST['fatherName']);
    if (empty($fatherName)) {
    $errors['fatherName'] = "Father full name can't be empty";
    }elseif (!preg_match( $namePattern , $fatherName)) {
        $errors['fatherName'] = "Name must be two words at least and contain letters only ";
       }

    $alphapetPattern = '/^([a-zA-Z\s]+|[\p{Arabic}\s]+)$/u';

    $fatherJob = trim($_POST['fatherJob']);
    if (empty($fatherJob)) {
    $errors['fatherJob'] = "Father job can't be empty";
    }elseif(!preg_match($alphapetPattern , $fatherJob)){
      $errors['fatherJob'] = "Father job should be letters only.";
    }

    $fatherNum = trim($_POST['fatherNum']);
    if (empty($fatherNum)) {
        $errors['fatherNum'] = "Phone number cannot be empty";
    } elseif (!preg_match($mobnumPattern, $fatherNum)) {
        $errors['fatherMobNuminvalid'] = "Invalid phone number format Must be 11 digits & start with (012 / 011 / 015 / 010)";
    }

    // Mother
    $motherName = trim($_POST['motherName']);
    if (empty($motherName)) {
    $errors['motherName'] = "Mother full name can't be empty";
    }elseif (!preg_match( $namePattern , $motherName)) {
        $errors['motherName'] = "Name must be two words at least and contain letters only ";
       }
    $motherJob = trim($_POST['motherJob']);
    if (empty($motherName)) {
    $errors['motherJob'] = "Mother job can't be empty";
    }elseif(!preg_match($alphapetPattern , $motherJob)){
      $errors['motherJob'] = "Mother job should be letters only.";
    }

    $motherNum = trim($_POST['motherNum']);
    if (empty($motherNum)) {
        $errors['motherNum'] = "Phone number cannot be empty";
    } elseif (!preg_match($mobnumPattern, $motherNum)) {
        $errors['motherMobNuminvalid'] = "Invalid phone number format Must be 11 digits & start with (012 / 011 / 015 / 010)";
    }
            
    // $personalPhoto = uploadImages($_FILES['personalPhoto'], $allowed_extensions, 'proimg', $nid, "personalPhoto");
    // if (empty($personalPhoto)) {
    //     $errors['traineePicempty'] = "Please upload a photo of the trainee.";
    // }

    // $idPhoto = uploadImages($_FILES['idPhoto'], $allowed_extensions, 'certimg' , $nid, "idPhoto");
    // if (empty($idPhoto)) {
    //     $errors['bdimgempty'] = "Please upload a Birth Certificate or National ID photo.";
    // }
    
    $traineeImg = trim($_FILES['personalPhoto']['name']);
    if (empty($traineeImg)){
    $errors['traineePicempty'] = "Please upload trainee Photo.";
    }else{
    checkExtensions($_FILES["traineePic"], $allowed_extensions,'traineePic');
    }
    
    $certImg = trim($_FILES['idPhoto']['name']);
    if (empty($certImg)){
    $errors['bdimgempty'] = "Please upload Birth Certificate or National ID photo.";
    }else{
    checkExtensions($_FILES["bdimg"], $allowed_extensions,'bdimg');
    }

    $notes =trim($_POST['notes']);
    if ($notes == "") {
        $notes = null;
    }
    //var_dump($_FILES['idPhoto']);
    //var_dump($errors);

    if(empty($errors)){
        $personalPhoto = uploadImages($_FILES["personalPhoto"],'proimg', $nid);
        $idPhoto = uploadImages($_FILES["idPhoto"], 'certimg', $nid);
            $query = $pdoConnection->query("INSERT INTO trainees (Name, NID, birthDate, gender, photo, birthCertificate,contactMobNum,fatherName,fatherMobNum,fatherJob,motherName,motherMobNum,motherJob,Notes) VALUES ('$name', '$nationalId','$dob', '$gender', '$personalPhoto','$idPhoto','$contactMobNum','$fatherName','$fatherNum','$fatherJob','$motherName','$motherNum','$motherJob','$notes')");
        
                if ($query) {
                    echo "<script>alert('Profile Created Successfully\n.');</script>";
                    echo "<script>window.location.href ='account.php?nid=$nid'</script>";
                } else {
                    echo "<script>alert('Something Went Wrong. Please try again.');</script>";
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
                    <a class="text-white px-2" href="https://www.facebook.com/people/Peace-Sports-School-Assuit/100091623236982/" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    
                    <a class="text-white px-2" href="https://www.instagram.com/pss_assuit/" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-white pl-2" href="https://wa.me/201205557683" target="_blank">
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
                    <a href="index.php" class="nav-item nav-link ">Home</a>
                    <a href="about.php" class="nav-item nav-link">About</a>                    
                    <a href="contact.php" class="nav-item nav-link">Contact</a>
                </div>
            </div>

                </nav>
    </div>
    <div class="container">
        <h2 class="about_text_2"><strong>In order to enroll, please create your profile first!</strong></h2>
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
                            <form id="registerForm" method="POST"  enctype="multipart/form-data" novalidate>
                                <div class="form-group">
                                    <label for="registerName">*Full Name</label>
                                    <input type="text" class="form-control" name="registerName" id="registerName" placeholder="Enter full name" required>
                                    <?php if( isset($_POST['submit']) && isset($errors['Name'])){ ?>
                                        <span style="color:red;display:block;text-align:left"><?php echo $errors['Name']; ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="NID">*National ID</label>
                                    <input
                                    type="text"
                                    class="form-control"
                                    name="NID"
                                    id="NID"
                                    value=<?php echo $nationalId; ?>
                                    disabled
                                    required>
                                    <?php echo "Your age is: " . $age;?>
                                    </div>
                                <div class="form-group">
                                    <label for="gender" class="form-label"  style="margin:7px">*Gender</label>
                                <div class="form-control">
                                    <input type="radio" name="genderele" value="male" required 
                                    <?php if ($genderDigit % 2 != 0) { echo "checked"; } ?> disabled > Male 
                                    <input type="radio" name="genderele" value="female" required
                                    <?php if ($genderDigit % 2 == 0) { echo "checked"; } ?> disabled style="margin-left:40px"> Female
                                </div>
                                </div>
                                <div class="form-group">
                                    <label for="phoneNum">*Enter phone number that has WhatsApp</label>
                                    <input type="text" class="form-control" name="contactMobNum" id="contactMobNum" placeholder="Enter phone number">
                                    <?php if(isset($_POST['submit']) && isset($errors['contactMobNum'])) { ?>
                                        <span style="color:red;display:block;text-align:left"><?php echo $errors['contactMobNum']; ?></span>
                                    <?php } ?>
                                    <?php if( isset($_POST['submit']) && isset($errors['contactMobNuminvalid'])) { ?>
                                        <span style="color:red;display:block;text-align:left"><?php echo $errors['contactMobNuminvalid']; ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" class="form-control"  id="dob" name="dob" value=<?php echo  $dateOfBirthFormatted;?> required  readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">*Personal Photo</label>
                                    <input type="file" class="form-control" name="personalPhoto" id="personalPhoto" required>
                                    <?php if( isset($_POST['submit']) && isset($errors['traineePic'])) { ?>
                                        <span style="color:red;display:block;text-align:left"><?php echo $errors['traineePic']; ?></span>
                                    <?php } ?>
                                    <?php if( isset($_POST['submit']) && isset($errors['traineePicempty'])) { ?>
                                        <span style="color:red;display:block;text-align:left"><?php echo $errors['traineePicempty']; ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">*National ID/Birth Certificate Photo</label>
                                    <input type="file" class="form-control" name="idPhoto" id="idPhoto" required>
                                    <?php if(isset($_POST['submit']) && isset($errors['bdimg'])) { ?>
                                        <span style="color:red;display:block;text-align:left"><?php echo $errors['bdimg']; ?></span>
                                    <?php } ?>
                                    <?php if(isset($_POST['submit']) && isset($errors['bdimgempty'])) { ?>
                                        <span style="color:red;display:block;text-align:left"><?php echo $errors['bdimgempty']; ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="fatherName">*Father Name</label>
                                    <input type="text" class="form-control" name="fatherName" id="fatherName" placeholder="Enter father name" required>
                                    <?php if(isset($_POST['submit']) && isset($errors['fatherName'])){ ?>
                                        <span style="color:red;display:block;text-align:left"><?php echo $errors['fatherName']; ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="fatherNum">*Father Phone Number</label>
                                    <input type="text" class="form-control" name="fatherNum" id="fatherNum" placeholder="Enter father phone number" required>
                                    <?php if(isset($_POST['submit']) && isset($errors['fatherNum'])){  ?>
                                    <span style="color:red;display:block;text-align:left"><?php echo $errors['fatherNum'];  ?></span>
                                    <?php } ?>
                                    <?php if(isset($_POST['submit']) && isset($errors['fatherMobNuminvalid'])){ ?>
                                    <span style="color:red;display:block;text-align:left"><?php echo $errors['fatherMobNuminvalid'] ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="fatherJob">*Father Job</label>
                                    <input type="text" class="form-control" name="fatherJob" id="fatherJob" placeholder="Enter father job" required>
                                    <?php if(isset($_POST['submit']) && isset($errors['fatherJob'])){  ?>
                                    <span style="color:red;display:block;text-align:left"><?php echo $errors['fatherJob'];  ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="motherName">*Mother Name</label>
                                    <input type="text" class="form-control" name="motherName" id="motherName" placeholder="Enter mother name" required>
                                    <?php if(isset($_POST['submit']) && isset($errors['motherName'])){  ?>
                                    <span style="color:red;display:block;text-align:left"><?php echo $errors['motherName'];  ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="motherNum">*Mother Phone Number</label>
                                    <input type="text" class="form-control" name="motherNum" id="motherNum" placeholder="Enter mother phone number" required>
                                    <?php if(isset($_POST['submit']) && isset($errors['motherNum'])){  ?>
                                    <span style="color:red;display:block;text-align:left"><?php echo $errors['motherNum'];  ?></span>
                                    <?php } ?>
                                    <?php if(isset($_POST['submit']) && isset($errors['motherMobNuminvalid'])){ ?>
                                    <span style="color:red;display:block;text-align:left"><?php echo $errors['motherMobNuminvalid'] ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="motherJob">*Mother Job</label>
                                    <input type="text" class="form-control" name="motherJob" id="motherJob" placeholder="Enter mother job" required>
                                    <?php if(isset($_POST['submit']) && isset($errors['motherJob'])){  ?>
                                    <span style="color:red;display:block;text-align:left"><?php echo $errors['motherJob'];  ?></span>
                                    <?php } ?>
                                </div>
                                <div class="control-group">
                                <textarea class="form-control border-1 py-3 px-4" rows="3" id="notes" name ="notes" 
                                placeholder="If you have notes regarding health or any thing, please write it here."></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                                <div>
                                <button type="submit" name="submit" id="submit" class="btn btn-primary rounded">Register</button>
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

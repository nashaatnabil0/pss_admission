<?php
// error_reporting(0);
include('includes/dbconnection.php');  

try {
    $nationalId = $_GET['nid'];
    $traineeName = $_GET['traineeName'];
    $sql = "SELECT * FROM trainees WHERE NID = ?";
    $stmt = $pdoConnection->prepare($sql);
    $stmt->execute([$nationalId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Handle case where no user is found
        echo "<script>alert('you do not have an account with us ');  location.href='login.php'</script>";
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     // Retrieve form data
    //     $errors = [];
    //     $mobnumPattern = '/^(011|010|015|012)[0-9]{8}$/';
    //     $name = $_POST['registerName'];
    //     if (empty($name)) {
    //         $errors['Name'] = "Name cannot be empty";
    //     }

    //     $nid = $nationalId;
    //     if ($genderDigit % 2 == 0) { $gender = "female"; }else $gender="male";
    //     $dob = $_POST['dob'];

    //     $contactMobNum = $_POST['contactMobNum'];  
    //     if (empty($contactMobNum)) {
    //         $errors['contactMobNum'] = "Phone number cannot be empty";
    //     } elseif (!preg_match($mobnumPattern, $contactMobNum)) {
    //         $errors['contactMobNuminvalid'] = "Invalid phone number format Must be 11 digits & start with (012 / 011 / 015 / 010)";
    //     }

    //     // Father
    //     $fatherName = $_POST['fatherName'];
    //     if (empty($fatherName)) {
    //     $errors['fatherName'] = "Father full name can't be empty";
    //     }
    //     $fatherJob = $_POST['fatherJob'];
    //     if (empty($fatherJob)) {
    //     $errors['fatherJob'] = "Father job can't be empty";
    //     }
    //     $fatherNum = $_POST['fatherNum'];
    //     if (empty($fatherNum)) {
    //         $errors['fatherMobNum'] = "Phone number cannot be empty";
    //     } elseif (!preg_match($mobnumPattern, $fatherNum)) {
    //         $errors['fatherMobNuminvalid'] = "Invalid phone number format Must be 11 digits & start with (012 / 011 / 015 / 010)";
    //     }

    //     // Mother
    //     $motherName = $_POST['motherName'];
    //     if (empty($motherName)) {
    //     $errors['motherName'] = "Mother full name can't be empty";
    //     }
    //     $motherJob = $_POST['motherJob'];
    //     if (empty($motherName)) {
    //     $errors['motherJob'] = "Mother job can't be empty";
    //     }
    //     $motherNum = $_POST['motherNum'];
    //     if (empty($motherNum)) {
    //         $errors['motherMobNum'] = "Phone number cannot be empty";
    //     } elseif (!preg_match($mobnumPattern, $motherNum)) {
    //         $errors['motherMobNuminvalid'] = "Invalid phone number format Must be 11 digits & start with (012 / 011 / 015 / 010)";
    //     }
        
    //     if (empty($_FILES["personalPhoto"])){
    //         $errors['traineePicempty']= "Please upload trainee Photo.";
    //     }
    //     if (empty($_FILES["idPhoto"])){
    //         $errors['bdimgempty']= "Please upload Birth Certificate or National ID photo. ";
    //     }

    //     $notes =$_POST['notes'];
    //     // var_dump($_FILES['idPhoto']);
    //     var_dump($errors);

    //     if(empty($errors)){
    //         $personalPhoto = uploadImages($_FILES['personalPhoto'], $allowed_extensions, "proimg", $nid,"traineePic");
    //         $idPhoto = uploadImages($_FILES['idPhoto'], $allowed_extensions, "certimg", $nid,"bdimg");
    //         if(empty($notes)){
    //             $query = $pdoConnection->query("INSERT INTO trainees (Name, NID, birthDate, gender, photo, birthCertificate,contactMobNum,fatherName,fatherMobNum,fatherJob,motherName,motherMobNum,motherJob) VALUES ('$name', '$nationalId','$dob', '$gender', '$personalPhoto','$idPhoto','$contactMobNum','$fatherName','$fatherNum','$fatherJob','$motherName','$motherNum','$motherJob')");

    //         }else{
    //             $query = $pdoConnection->query("INSERT INTO trainees (Name, NID, birthDate, gender, photo, birthCertificate,contactMobNum,fatherName,fatherMobNum,fatherJob,motherName,motherMobNum,motherJob,Notes) VALUES ('$name', '$nationalId','$dob', '$gender', '$personalPhoto','$idPhoto','$contactMobNum','$fatherName','$fatherNum','$fatherJob','$motherName','$motherNum','$motherJob','$notes')");
    //         }
    //                 if ($query) {
    //                     echo "<script>alert('Profile Created Successfully\n.');</script>";
    //                     echo "<script>window.location.href ='account.php?nid=$nid'</script>";
    //                 } else {
    //                     echo "<script>alert('Something Went Wrong. Please try again.');</script>";
    //                 }
    //     }

    // }
    $query = "SELECT COUNT(groupId) AS groupCount 
    FROM enrollment 
    WHERE traineeNID = :traineeNID 
    AND state = 'on'";
    $stmt = $pdoConnection->prepare($query);
    $stmt->execute(['traineeNID' => $nationalId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $groupcounter= $result['groupCount'];
    $able_to_enroll = false;
    $diabledsportID =0;
    // If the count is less than 2, allow enrollment
    if ($groupcounter < 2 && $groupcounter >0) {
        // echo "<script>alert('can enroll in $groupcounter more group');</script>";
        $able_to_enroll = true;
        $query = "SELECT
            g.sportId,
            sp.name
        FROM 
            enrollment en 
        JOIN 
            groups g ON en.groupId = g.ID 
        JOIN 
            sport sp ON g.sportId = sp.ID 
        WHERE 
            en.traineeNID = :traineeNID 
        AND 
            en.state = 'on'";
        $stmt = $pdoConnection->prepare($query);
        $stmt->execute(['traineeNID' => $nationalId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $diabledsportID= $result['sportId'];


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

    }elseif($groupcounter == 0){
        $able_to_enroll = true;
    }
    else{
        echo "<script>alert('you can not enroll in more than $groupcounter diffreant sport groups - If you need any help with this contact the admins'); location.href='account.php?nid=$nationalId'</script>";

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
    <title>P.S.S - Group Enroll</title>
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
   
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .radio-card {
      cursor: pointer;
      border: 2px solid #ddd;
      border-radius: 8px;
      padding: 15px;
      transition: border-color 0.3s;
    }

    .radio-card:hover {
      border-color: #007bff;
    }

    .radio-card input[type="radio"] {
      display: none;
    }

    .radio-card input[type="radio"]:checked + .card {
      border-color: #007bff;
      background-color: #f1f8ff;
    }

    .radio-card .card {
      margin-bottom: 10px;
      padding: 15px;
    }

    .custom-control-label {
      font-weight: bold;
    }
  </style>

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
        </nav>
    </div>
    <div class="container">
        <h2 class="about_text_2"><strong>Let's Choses The Best Group For You</strong></h2>
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
                                    <input type="text" class="form-control" name="registerName" id="registerName" value="<?php echo $traineeName; ?>" readonly>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="NID">*National ID</label>
                                    <input
                                    type="text"
                                    class="form-control"
                                    name="NID"
                                    id="NID"
                                    value=<?php echo $nationalId; ?>
                                    readonly>
                                    <?php echo "Your age is: " . $age;?>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control m-bot15" name="sport" id="sport">
                                            <option value="">Choose a sport</option>
                                            <?php $query=$pdoConnection-> query("Select * from sport WHERE ID <> '$diabledsportID';");
                                                while($row=$query ->fetch(PDO:: FETCH_ASSOC))
                                                {
                                                ?>    
                                            <option value="<?php echo $row['ID'];?>"><?php echo $row['name'];?></option>
                                                <?php } ?> 
                                        </select>
                                        <?php if(isset($_POST['submit']) && isset($errors['sport'])) { ?>
                                            <span style="color:red;display:block;text-align:left"><?php echo $errors['sport']; ?></span>
                                            <?php } ?>
                                    </div>
                                        <!-- <select class="form-control m-bot15" name="group" id="group"> -->
                                            <!-- <option value="">Choose a group</option> -->
                                            <?php $query=$pdoConnection-> query("Select * from groups WHERE sportId <> '$diabledsportID';");
                                                while($row=$query ->fetch(PDO:: FETCH_ASSOC))
                                                {
                                                ?>    
        <div class="col-md-4">
        <label class="radio-card">
          <input type="radio" name="option" value="option1">
          <div class="card">
            <h5 class="custom-control-label">Option 1</h5>
            <p>Details about Option 1</p>
          </div>
        </label>
      </div>
                                            <!-- <option value="<?php echo $row['ID'];?>"><?php echo $row['Title'];?></option> -->
                                                <?php } ?> 
                                        <!-- </select> -->
                                        <?php if(isset($_POST['submit']) && isset($errors['groups'])) { ?>
                                            <span style="color:red;display:block;text-align:left"><?php echo $errors['sport']; ?></span>
                                            <?php } ?>
                                            
                                
      

                                
                                <!-- <div class="form-group">
                                    <label for="motherNum">*Mother Phone Number</label>
                                    <input type="text" class="form-control" name="motherNum" id="motherNum" placeholder="Enter mother phone number" required>
                                </div>
                                <div class="form-group">
                                    <label for="motherJob">*Mother Job</label>
                                    <input type="text" class="form-control" name="motherJob" id="motherJob" placeholder="Enter mother job" required>
                                </div>
                                <div class="control-group">
                                <textarea class="form-control border-1 py-3 px-4" rows="3" id="Notes" name ="notes" 
                                placeholder="If you have notes regarding health or any thing, please write it here."></textarea>
                                <p class="help-block text-danger"></p>
                            </div> -->
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
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Contact Javascript File -->
        <script src="mail/jqBootstrapValidation.min.js"></script>
        <script src="mail/contact.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
        <script>
            function toggleDropdown() {
                document.querySelector('.select-items').style.display = 
                document.querySelector('.select-items').style.display === 'block' ? 'none' : 'block';
            }

            function selectOption(elm) {
                document.querySelector('.selected-item').innerHTML = elm.innerHTML;
                document.querySelector('.select-items').style.display = 'none';
            }

            window.onclick = function(event) {
                if (!event.target.matches('.selected-item')) {
                document.querySelector('.select-items').style.display = 'none';
                }
            }
        </script>
</body>

</html>

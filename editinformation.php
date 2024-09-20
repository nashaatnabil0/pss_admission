<?php
session_start();
// error_reporting(0);

include('includes/dbconnection.php');  

if(!empty($_GET['editid'])){
    $user_id = $_GET['editid'];     
    }else{
        echo "<script>alert('Wrong Path');</script>";
        echo "<script>location.href='index.php'</script>";
    }

    $errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
  {
        // Trainee
        $namePattern = '/^([a-zA-Z]+(?:\s+[a-zA-Z]+)*|[\p{Arabic}]+(?:\s+[\p{Arabic}]+)*)$/u';
        $name = trim($_POST['Name']);
        if (empty($name)) {
            $errors['Name'] = "Name cannot be empty";
        }elseif (!preg_match( $namePattern , $name)) {
            $errors['Name'] = "Name must be two words at least and contain letters only ";
         }
        
        
        $contactmobnum = trim($_POST['contactMobNum']);
        $mobnumPattern = '/^(011|010|015|012)[0-9]{8}$/';
        if (empty($contactmobnum)) {
            $errors['contactMobNum'] = "Phone number cannot be empty";
        } elseif (!preg_match($mobnumPattern, $contactmobnum)) {
            $errors['contactMobNum'] = "Invalid phone number format Must be 11 digits & start with (012 / 011 / 015 / 010)";
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
        $fathermobnum = trim($_POST['fatherMobNum']);
        if (empty($fathermobnum)) {
            $errors['fatherMobNum'] = "Phone number cannot be empty";
        } elseif (!preg_match($mobnumPattern, $fathermobnum)) {
            $errors['fatherMobNum'] = "Invalid phone number format Must be 11 digits & start with (012 / 011 / 015 / 010)";
        }
    
        // Mother
        $motherName = trim($_POST['motherName']);
        if (empty($motherName)) {
          $errors['motherName'] = "Mother full name can't be empty";
        }elseif (!preg_match( $namePattern , $motherName)) {
            $errors['motherName'] = "Name must be two words at least and contain letters only ";
           }

        $motherJob = trim($_POST['motherJob']);
        if (empty($motherJob)) {
          $errors['motherJob'] = "Mother job can't be empty";
        }elseif(!preg_match($alphapetPattern , $motherJob)){
        $errors['motherJob'] = "Mother job should be letters only.";
        }

        $mothermobnum =trim($_POST['motherMobNum']);
        if (empty($mothermobnum)) {
            $errors['motherMobNum'] = "Phone number cannot be empty";
        } elseif (!preg_match($mobnumPattern, $mothermobnum)) {
            $errors['motherMobNum'] = "Invalid phone number format Must be 11 digits & start with (012 / 011 / 015 / 010)";
        }
    
            //notes
        $notes = trim($_POST['Notes']);
        if ($notes == "") {
            $notes = null;
        }
    
        // Photo & Birth Certificate/NID
        //fetching photos from the database to update
        $delete_image = $pdoConnection -> query("select photo , birthCertificate from trainees where NID='$user_id'");
        $image_data = $delete_image-> fetch(PDO:: FETCH_ASSOC);
      
        $existing_TraineePhoto = $image_data['photo'];
        $existing_birthcertificate = $image_data['birthCertificate'];

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


    $traineePhoto = trim($_FILES['personalPhoto']['name']);
       if (empty($traineePhoto)){
         $traineePhoto= $existing_TraineePhoto;
       }else{
        checkExtensions($_FILES["personalPhoto"], $allowed_extensions,'traineePic');
       }    
    $bdImage = trim($_FILES['idPhoto']['name']);
    if (empty($bdImage)){
         $bdImage = $existing_birthcertificate;
       }else{
        checkExtensions($_FILES["idPhoto"], $allowed_extensions,'bdimg');
       }
    
        if(empty($errors)){
            
            if ($traineePhoto != $existing_TraineePhoto) {
                $traineePhoto = uploadImages($_FILES["personalPhoto"],'proimg', $user_id);
              }
         
            if ($bdImage != $existing_birthcertificate) {
              $bdImage = uploadImages($_FILES["idPhoto"], 'certimg', $user_id);
             } 

        //insert into databse
                $query = $pdoConnection->query("UPDATE trainees SET Name= '$name', photo='$traineePhoto', birthCertificate='$bdImage',contactMobNum='$contactmobnum',fatherName='$fatherName',fatherMobNum='$fathermobnum',fatherJob='$fatherJob',motherName='$motherName',motherMobNum='$mothermobnum',motherJob='$motherJob', Notes ='$notes' WhERE NID = $user_id;");
            
                if ($query) {
                    if ($traineePhoto != $existing_TraineePhoto) {
                    unlink("admin/images/" . $existing_TraineePhoto);
                    }
                
                if ($bdImage != $existing_birthcertificate) {
                    unlink("admin/images/" . $existing_birthcertificate);
                    }   
                    echo "<script>alert('Profile information have been updated.');</script>";
                    echo "<script>window.location.href ='account.php?nid=$user_id'</script>";
                } else {
                    echo "<script>alert('Something Went Wrong. Please try again.');</script>";
                    }
            }    else {
                // var_dump($errors);
              
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
    <title>P.S.S - Update Profile</title>
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
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="about.php" class="nav-item nav-link">About</a>
                    <a href="contact.php" class="nav-item nav-link">Contact</a>
        </nav>
    </div>    
    <!-- header section end -->
                    <?php
                    $ret= $pdoConnection-> query("SELECT * FROM trainees where NID='$user_id'");
                    $userData = $ret->fetchAll();
                    if (empty($userData)) {
                        echo "<script>alert('you do not have an account with us yet');  location.href='login.php'</script>";
                        exit();
                    }else{
                    // while ($row=$ret->fetch(PDO::FETCH_ASSOC)) {
                        foreach($userData as $row) {
                  ?>
    <div class="container">
        <h1 class="center-text text-center mb-4"><strong>Update Information</strong></h1>
        <h4 class="text-primary">Personal Information</h4>
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
                                    <input type="text" class="form-control" name="Name" id="Name" placeholder="Enter full name" value="<?php  echo $row['Name'];?>" required>
                                    <?php if( isset($errors['Name'])){ ?>
                                        <span style="color:red;display:block;text-align:left"><?php echo $errors['Name']; ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="NID">National ID</label>
                                    <input
                                    type="text"
                                    class="form-control"
                                    name="NID"
                                    id="NID"
                                    value=<?php  echo $row['NID'];?>
                                    disabled
                                    required>
                                    <!-- Error message placeholder -->
                                     <span id="nidError" style="color: red; display: none;">Please enter a valid 14-digit National ID where the 4th and 5th digits form a number less than or equal to 12, and the 6th and 7th digits form a number less than or equal to 31.</span>
                                     <?php
                                      $currentDate = new DateTime();
                                      $birthDate = new DateTime($row['birthDate']);
                                      $age = $currentDate->diff($birthDate)->y;
                                     echo "Your age is: " . $age;?> 
                                </div>
                                    
                                <div class="form-group">
                                    <label for="gender" class="form-label"> Gender</label> 
                                    <input type="radio" name="gender" value="male" required <?php 
                                    if ($row['gender']==='male') {
                                        echo "checked";
                                    } 
                                    ?> disabled > Male
                                    <input type="radio" name="gender" value="female" required <?php 
                                    if ($row['gender']==='female') {
                                        echo "checked";
                                    } 
                                    ?> disabled style="margin-left:40px"> Female
                                </div>

                                <div class="form-group">
                                    <label for="phoneNum">Enter phone number that has WhatsApp</label>
                                    <input type="text" class="form-control" name="contactMobNum" id="contactMobNum" placeholder="Enter phone number" value="<?php  echo $row['contactMobNum'];?>" required>
                                    <?php if(isset($errors['contactMobNum'])) { ?>
                                        <span style="color:red;display:block;text-align:left"><?php echo $errors['contactMobNum']; ?></span>
                                    <?php } ?>
                                </div>

                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" class="form-control"  id="dob" value="<?php  echo $row['birthDate'];?>" disabled required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Trainee Photo</label>
                                    <div class="col-sm-10">
                                    <img src="admin/images/<?php echo $row['photo'];?>" width="150" height="200" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Change Trainee Photo</label>
                                    <div>
                                        <input type="file" class="form-control" name="personalPhoto" id="personalPhoto" >
                                        <?php if(isset($errors['traineePic'])) { ?>
                                            <span style="color:red;display:block;text-align:left"><?php echo $errors['traineePic']; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                </div><div class="form-group">
                                    <label>Birth Certificate / National ID Image</label>
                                    <div class="col-sm-10 ">
                                    <img src="admin/images/<?php echo $row['birthCertificate'];?>" width="150" height="200">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label >Update Birth Certificate / National ID Image</label>
                                    <div>
                                        <input type="file" class="form-control" name="idPhoto" id="idPhoto" value="<?php echo $row['birthCertificate']; ?>">
                                        <?php if( isset($errors['bdimg'])) { ?>
                                            <span style="color:red;display:block;text-align:left"><?php echo $errors['bdimg']; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                
                                <h4 class="text-primary">Family Information</h4>

                                <div class="form-group">
                                    <label for="fatherName">Father Name</label>
                                    <input type="text" class="form-control" name="fatherName" id="fatherName" placeholder="Enter father name" value="<?php  echo $row['fatherName'];?>" required>
                                    <?php if( isset($errors['fatherName'])){ ?>
                                        <span style="color:red;display:block;text-align:left"><?php echo $errors['fatherName']; ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="fatherMobNum">Father Phone Number</label>
                                    <input type="text" class="form-control" name="fatherMobNum" id="fatherMobNum" placeholder="Enter father phone number" value="<?php  echo $row['fatherMobNum'];?>" required>
                                    <?php if( isset($errors['fatherMobNum'])){  ?>
                                    <span style="color:red;display:block;text-align:left"><?php echo $errors['fatherMobNum'];  ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="fatherJob">Father Job</label>
                                    <input type="text" class="form-control" name="fatherJob" id="fatherJob" placeholder="Enter father job" value="<?php  echo $row['fatherJob'];?>" required>
                                    <?php if( isset($errors['fatherJob'])){  ?>
                                    <span style="color:red;display:block;text-align:left"><?php echo $errors['fatherJob'];  ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="motherName">Mother Name</label>
                                    <input type="text" class="form-control" name="motherName" id="motherName" placeholder="Enter mother name" value="<?php  echo $row['motherName'];?>" required>
                                    <?php if( isset($errors['motherName'])){  ?>
                                    <span style="color:red;display:block;text-align:left"><?php echo $errors['motherName'];  ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="motherMobNum">Mother Phone Number</label>
                                    <input type="text" class="form-control" name="motherMobNum" id="motherMobNum" placeholder="Enter mother phone number" value="<?php  echo $row['motherMobNum'];?>" required>
                                    <?php if( isset($errors['motherMobNum'])){  ?>
                                    <span style="color:red;display:block;text-align:left"><?php echo $errors['motherMobNum'];  ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="motherJob">Mother Job</label>
                                    <input type="text" class="form-control" name="motherJob" id="motherJob" placeholder="Enter mother job" value="<?php  echo $row['motherJob'];?>" required>
                                    <?php if( isset($errors['motherJob'])){  ?>
                                    <span style="color:red;display:block;text-align:left"><?php echo $errors['motherJob'];  ?></span>
                                    <?php } ?>
                                </div>
                                <div class="control-group">
                                <textarea class="form-control border-1 py-3 px-4" rows="3" id="Notes" name="Notes"
                                value="<?php  echo $row['Notes'];?>"   
                                placeholder="If you have notes regarding health or any thing, please write it here."></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                            <?php } } ?>
                                <div>
                                <button type="submit" class="btn btn-primary rounded" >Update</button>
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

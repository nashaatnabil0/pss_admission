<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
error_reporting(0);
if (strlen($_SESSION['contactno']==0)||strlen($_SESSION['email']==0)) {
  header('location:forgot-password.php');
  }
if(isset($_POST['submit']))
  {
    $errors = [];   
    $contactno=$_SESSION['contactno']; 
    
    $email=$_SESSION['email'];
    $password=$_POST['newpassword'];
    $Confpassword=$_POST['confirmpassword'];

    $passwordPattern= '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    if(preg_match($passwordPattern,$password)){
      // Password Accepted
          if ($Confpassword === $password) {
            //Password match

            $password=md5($_POST['newpassword']);
              $query= $pdoConnection->query("UPDATE `users` SET `password`='$password' WHERE `MobileNumber`='$contactno' and `Email`='$email'" );
              if($query)
              {
              echo "<script>alert('Password successfully changed');</script>";
              echo "<script type='text/javascript'> document.location ='login.php'; </script>";
              session_destroy();
              }else{
               echo "<script>alert('Somthing Wrong');</script>";
              }

          } else {
                //not match
          $errors['PassMatch'] = "Confirmation Password not match";
          }

    }else{
            //Weak Password Rejected
      $errors['PassWeak'] = "Password must have Uppercase, lowercase, digit, spicial char, and length must be 8 or more";
    }
  }
  ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <title>Reset Password| Galerie Management System</title>

  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet" />

</head>

<body class="login-img3-body">

  <div class="container">

    <form class="login-form" method="post" name="changepassword" >
        <div class="login-wrap">
        <p class="login-img"><i class="icon_lock_alt"></i></p>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_key_alt"></i></span>
          <input type="password" class="form-control" name="newpassword" placeholder="New Password" required="true">
        </div>
        <span style="color:red;display:block;text-align:left"><?php echo (isset($errors['PassWeak']))?$errors['PassWeak']:'';?></span>
        <br>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_key_alt"></i></span>
          <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm Password" required="true">
        </div>
        <span style="color:red;display:block;text-align:left"><?php echo (isset($errors['PassMatch']))?$errors['PassMatch']:'';?></span>
        <br>
        <button class="btn btn-primary btn-lg btn-block" type="submit" name="submit">Reset</button>
        <span class="pull-right"> <a href="login.php"> Signin</a></span>
      </div>
    </form>
   
  </div>


</body>

</html>

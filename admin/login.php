<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['login']))
  {
    $adminuser=trim($_POST['username']);
    $password=md5(trim($_POST['password']));
    $query=$pdoConnection-> query("SELECT ID,role from users where name='$adminuser' AND Password= '$password'");
    $ret = $query ->fetch(PDO:: FETCH_ASSOC);
    if($ret>0){
      $_SESSION['sportadmission']=$ret['ID'];
      $_SESSION['role']=$ret['role'];
      echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
    }
    else{
    //echo "<script>alert('Wrong name or password ');</script>";
         $errors = "Wrong Name or password";
    }
  }

  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login| Peace Sports School Admission System</title>

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

    <form class="login-form" action="" method="post">
      
      <div class="login-wrap">
        <p class="login-img"><i class="icon_lock_alt"></i></p>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_profile"></i></span>
          <input type="text" class="form-control" name="username" placeholder="Username" autofocus >
        </div>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_key_alt"></i></span>
          <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        <div>
        <?php if(isset($errors)){ ?>
           <span style="color:red;display:block;text-align: center ; font-weight: bold " ><?php echo $errors ; ?></span>
         <?php } ?>
        </div> <br>      
                <lable><span class="pull-right"> <a href="forgot-password.php"> Forgot Password?</a></span>
            </label>
        <button class="btn btn-primary btn-lg btn-block" type="submit" name="login">Login</button>
            <p style="margin-top:3%; font-weight:bold"><a href="../index.php" >Back to Home page</a></p>
      </div>
    </form>

   
  </div>


</body>

</html>

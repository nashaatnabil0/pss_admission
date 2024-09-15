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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $errors = [];
        $name = $_POST['registerName'];
        if (empty($name)) {
            $errors['Name'] = "Name cannot be empty";
        }
        $group = $_POST['group'];
        $enrollstate = $_POST['enrollStat'];
        var_dump($_POST);
        if(empty($errors)){    
            try{            
                $query = $pdoConnection->query("INSERT INTO enrollment (traineeNID, groupId, paymentPlan, state) VALUES ('$nationalId', '$group','full', '$enrollstate')");
                    
                    if ($query) {
                        echo "<script>alert('Enrolled succsessfully.');</script>";
                        echo "<script>window.location.href ='account.php?nid=$nationalId'</script>";
                    } else {
                        echo "<script>alert('Something Went Wrong. Please try again.');</script>";
                    }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                exit();
            }
        }

    }
    $query = "SELECT COUNT(groupId) AS groupCount 
    FROM enrollment 
    WHERE traineeNID = :traineeNID 
    AND state IN ('on', 'waiting')";

    // AND state = 'on'";

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
            g.sportId
        FROM 
            enrollment en 
        JOIN 
            groups g ON en.groupId = g.ID 
        JOIN 
            sport sp ON g.sportId = sp.ID 
        WHERE 
            en.traineeNID = :traineeNID 
        AND 
            en.state IN ('on', 'waiting');";
        $stmt = $pdoConnection->prepare($query);
        $stmt->execute(['traineeNID' => $nationalId]);
        
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $diabledsportArr = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
    }elseif($groupcounter == 0){
        $able_to_enroll = true;
    }
    else{
        echo "<script>alert('you can not enroll in more than $groupcounter diffreant sport groups - If you need any help with this contact the admins'); location.href='account.php?nid=$nationalId'</script>";

    }
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
        $ageY = ($currentDate->diff($birthDate)->y)-8;
        $ageM = $currentDate->diff($birthDate)->m;
        if($ageM > 6){
            $ageY +=1;
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
   
    <style>
        .radio-card-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        }

        .radio-card {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 20px;
        width: 100%;
        max-width: 300px;
        text-align: center;
        margin: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        }

        .radio-card:hover {
        border-color: #007bff;
        transform: scale(1.05);
        }

        .radio-card input[type="radio"] {
        display: none;
        }

        .radio-card input[type="radio"]:checked + .card-content {
        border-color: #007bff;
        background-color: #e7f1ff;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.2);
        }

        .radio-card .card-content {
        padding: 15px;
        border: 2px solid transparent;
        border-radius: 8px;
        }

        .radio-card h5 {
        margin-bottom: 15px;
        }

        .radio-card p {
        font-size: 14px;
        color: #666;
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
                </div>
            </div>
        </nav>
    </div>
    <div class="container">
        <h2 class="about_text_2" style="text-align: center;"><strong>Let's Choses The Best Group For You</strong></h2>
        <section class="login_register_section layout_padding">
            <div class="container">
                <div class="heading_container" style="text-align: center;">
                    <p>*Please fill all the fields.</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-9">
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
                                    <input value='<?php echo $ageY; ?>' traineeMonth="<?php echo $ageM; ?>" id="traineeAge" readonly hidden>
                                    <?php if($ageM>6){echo "Your age is: " .($ageY-1)."y and ".$ageM.'m';}else{ echo "Your age is: " .$ageY."y and ".$ageM.'m';} ?>
                                </div>
                                <div class="form-group">
                                    <label for="NID">*Sport</label>
                                    <select class="form-control m-bot15" name="sport" id="sport" required>
                                        <option value="">Choose a sport</option>
                                        <?php 

                                            if (!empty($diabledsportArr)) {
                                                // Create placeholders for the IDs
                                                $placeholders = implode(',', array_fill(0, count($diabledsportArr), '?'));

                                                // Main query to select from 'sport' excluding certain IDs
                                                $sql = "SELECT * FROM sport WHERE ID NOT IN ($placeholders)";
                                                
                                                // Prepare and execute the query
                                                $stmt = $pdoConnection->prepare($sql);
                                                $stmt->execute($diabledsportArr);

                                                // Fetch the results
                                                // $results = $stmt->fetchAll();
                                            } else {
                                                // Handle case when no values are returned from the exclusion query
                                                $sql = "SELECT * FROM sport";
                                                $stmt = $pdoConnection->prepare($sql);
                                                $stmt->execute();
                                            }
                                    
                                        while($row=$stmt ->fetch(PDO:: FETCH_ASSOC))
                                        {?>    
                                            <option value="<?php echo $row['ID'];?>"><?php echo $row['name'];?></option>
                                        <?php } ?> 
                                        </select>
                                        <?php if(isset($_POST['submit']) && isset($errors['sport'])) { ?>
                                            <span style="color:red;display:block;text-align:left"><?php echo $errors['sport']; ?></span>
                                            <?php } ?>
                                </div>
                                <div class="radio-card-container">

                                        <?php 
                                        $query=$pdoConnection-> query("Select g.*,(SELECT COUNT(*) FROM enrollment en WHERE en.groupId = g.ID AND en.state = 'on') as totalEnrollments from groups g ;");
                                        while($row=$query ->fetch(PDO:: FETCH_ASSOC))
                                        {
                                            $totalEnrollments = $row['totalEnrollments']+29;
                                            $isWaiting = $totalEnrollments >= $row['capacity'] ? true : false; // Check if enrollments exceed 30
                                        ?>    
                                                <!-- Option 1 -->
                                                <label class="radio-card" style="display: none;" Sportdata="<?php echo $row['sportId'];?>" minAge="<?php echo $row['minAge']; ?>" maxAge="<?php echo $row['maxAge']; ?>">
                                                    <input type="radio" name="group" id="group" value="<?php echo $row['ID'];?>" required>
                                                    <div class="card-content">
                                                        <h5 class="text-primary"><?php echo $row['Title'];?></h5>
                                                        <p style="text-align: left;"><strong>Days:</strong> <?php echo $row['days'];?> - timing: <?php echo $row['Timeslot'];?></p>
                                                        <p style="text-align: left;"><strong>Age:</strong> <?php echo $row['minAge']; ?>y to <?php echo $row['maxAge']; ?>y</p>
                                                        <p style="text-align: left;"><strong>Location:</strong> <?php echo $row['place'];?></p>
                                                        <p style="text-align: left;"><strong>Fees:</strong> <?php echo $row['price'].' EGP';?></p>
                                                    
                                                        <!-- Show "Waiting" label if totalEnrollments exceed 30 -->
                                                        <?php if ($isWaiting) { ?>
                                                            <p style="color: red; text-align: left;"><strong>Status:</strong> Waiting List</p>
                                                            <input value='waiting' name="enrollStat" id="enrollStat" readonly hidden>
                                                        <?php } else { ?>
                                                            <p style="color: green; text-align: left;"><strong>Status:</strong> Available</p>
                                                            <input value='on' name="enrollStat" id="enrollStat" readonly hidden>
                                                        <?php } ?>
                                                    
                                                    </div>
                                                </label>

                                            <?php } ?>
                                </div>
                                <div class="alert alert-danger" role="alert" hidden >
                                    This is a danger alert—check it out!
                                </div>
                                        <?php if(isset($_POST['submit']) && isset($errors['groups'])) { ?>
                                            <span style="color:red;display:block;text-align:left"><?php echo $errors['sport']; ?></span>
                                        <?php } ?>
                                            
                                <button type="submit"  class="btn btn-primary">Register</button>
                            </form>
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
       
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Contact Javascript File -->
        <script src="mail/jqBootstrapValidation.min.js"></script>
        <script src="mail/contact.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
        
        <!-- JavaScript to Filter Cards -->
        <script>
            document.getElementById('sport').addEventListener('change', function() {
                var selectedSportId = this.value;
                var traineeAgeY = document.getElementById('traineeAge').value;
                // var traineeAgeM = parseInt(document.getElementById('traineeAge').getAttribute('traineeMonth'));
                var cards = document.querySelectorAll('.radio-card');
                
                cards.forEach(function(card) {
                    var cardSportId = card.getAttribute('Sportdata');
                    var minAge = parseInt(card.getAttribute('minAge'));
                    var maxAge = parseInt(card.getAttribute('maxAge'));
                    
                    // Show card if the sport ID matches, otherwise hide it
                    if (selectedSportId === cardSportId &&
                    (traineeAgeY >= minAge && traineeAgeY <= maxAge)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        </script>
</body>

</html>

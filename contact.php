<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
// $sql = "SELECT photo_path FROM photos";
// $result = $conn->query($sql);
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
    <title>P.S.S - Contact Us</title>
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

    <!-- <style>
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
            padding: 20px;
        }
        .photo-grid img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style> -->
</head>

<body>

    <!-- Header Start -->
    <?php include('includes/header.php'); ?>
    <!-- Header End -->

        <!-- Contact Start -->
        <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 pb-4 pb-lg-0 mx-auto">
                    <div class=" text-dark text-center p-4">
                        <h1 class="m-0" style="color: #FF4800;"><i class=" text-white mr-2"></i>Get In Touch</p>
                    </div> 
                    <div class="col-md-8 mb-5 mx-auto text-center">
                    <a href="https://maps.app.goo.gl/VyMNrRsB7VuPTFGF8" target="_blank">
                        <h5><i class="fa fa-map-marker-alt mr-2"></i>شارع الجمهوريه أمام ميدان ام البطل , Asyut, Egypt</h5>
                    </a>
                    <a href="https://wa.me/201205557683" target="_blank">
                        <h5><i class="fa fa-phone-alt mr-2"></i>+01205557683</h5>
                    </a>
                    <a href="mailto:pssassiut1@gmail.com" target="_blank">
                        <h5><i class="fa fa-envelope mr-2"></i>pssassiut1@gmail.com</h5>
                    </a>
                    </div>
                    <div class=" text-dark text-center p-4">
                        <h1 class="m-0" style="color: #FF4800;"><i class=" text-white mr-2"></i>Our Social Media</h1>
                    </div> 
                    <div class="col-md-8 mb-5 mx-auto text-center">
                    <a href="https://maps.app.goo.gl/VyMNrRsB7VuPTFGF8" target="_blank">
                        <h5><i class="fab fa-facebook"></i> Facebook</h5>
                    </a>
                    <a href="https://www.instagram.com/pss_assuit/" target="_blank">
                        <h5><i class="fab fa-instagram"></i> Instagram</h5>
                    </a>
                    <a href="https://wa.me/201205557683" target="_blank">
                        <h5><i class="fab fa-whatsapp"></i> WhatsApp</h5>
                    </a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <h6 class="text-primary text-uppercase font-weight-bold">If you have any query</h6>
                    <h1 class="mb-4">Leave us a message here!</h1>
                    <div class="contact-form bg-secondary" style="padding: 30px;">
                        <div id="success"></div>
                        <!-- <form name="sentMessage" id="contactForm" novalidate="novalidate"> -->
                        <form action="https://formsubmit.co/nashaatnabil8@gmail.com" method="POST">
                            <!-- <div class="control-group">
                                <input type="text" class="form-control border-0 p-4" id="name" placeholder="Your Name"
                                    required="required" data-validation-required-message="Please enter your name" />
                                <p class="help-block text-danger"></p>
                            </div> -->
                            <!-- <div class="control-group">
                                <input type="text" class="form-control border-0 p-4" id="phoneNumber" placeholder="Your Phone Number"
                                    required="required" data-validation-required-message="Please enter your phone number" />
                                <p class="help-block text-danger"></p>
                            </div> -->
                            <div class="control-group">
                                <input type="email" class="form-control border-0 p-4" id="email" name="email" placeholder="Your Email"
                                    required="required" data-validation-required-message="Please enter your email" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <input type="text" class="form-control border-0 p-4" id="subject" name="_subject" placeholder="Subject"
                                    required="required" data-validation-required-message="Please enter a subject" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <textarea class="form-control border-0 py-3 px-4" rows="3" id="message" name="message" placeholder="Message"
                                    required="required"
                                    data-validation-required-message="Please enter your message"></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                            <input type="hidden" name="_next" value="https://yourdomain.co/thanks.html">
                            <div>
                                <button class="btn btn-primary py-3 px-4" type="submit" id="sendMessageButton">Send
                                    Email</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
    
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
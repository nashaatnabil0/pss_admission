<?php 
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

?>
<!-- Topbar Start -->
    <div class="container-fluid bg-dark">
        <div class="row py-2 px-lg-5">
            <div class="col-lg-6 text-center text-lg-left mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center text-white">
                    <small><i class="fa fa-phone-alt mr-2"></i>+01205557683</small>
                    <small class="px-3">|</small>
                    <small><i class="fa fa-envelope mr-2"></i>pssassiut1@gmail.com</small>
                </div>
                <div class="d-inline-flex align-items-center" id="google_translate_element"></div>
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
            <img src="img/aabout.jpg" alt="P.S.S Logo" class="img-fluid" style="max-height: 150px;"> 
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
                <div class="navbar-nav m-auto py-0">
                    <a href="index.php" class="lang en nav-item nav-link rounded <?php if (strpos($url,'index') == true) { echo ' active'; } ?>">Home Page</a>
                    <a href="about.php" class="lang en nav-item nav-link rounded <?php if (strpos($url,'about') == true) { echo ' active'; } ?>" >About Us</a>
                    <a href="contact.php" class="lang en nav-item nav-link rounded <?php if (strpos($url,'contact') == true) { echo ' active'; } ?>">Contact Us</a>
                </div>
                <a href="login.php" class="btn btn-primary py-2 px-4 d-none d-lg-block rounded">Register / Enroll</a>
                <a href="login.php" class="btn btn-primary py-2 px-4 d-block d-lg-none rounded">Register / Enroll</a>
                </div>
            </div>
        </nav>
    </div>
    <script type="text/javascript">
            function googleTranslateElementInit(){
                new google.translate.TranslateElement(
                    {PageLangauage: 'en'},
                    'google_translate_element'
                );
            }
            </script>
            <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>


    <!-- Navbar End -->
     <!-- Header Start -->

         <!-- Header End -->

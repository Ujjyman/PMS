<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->


    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Style CSS -->
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .modal-header, h4, .close {
            background-color: white;
            color: white !important;
            text-align: center;
            font-size: 30px;
            margin-top: auto;
            margin-bottom: auto;
        }

        .modal-footer {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
<!-- Preloader -->
<div id="preloader">
    <div class="medilife-load"></div>
</div>

<!-- ***** Header Area Start ***** -->
<header class="header-area">
    <!-- Top Header Area -->
    <div class="top-header-area">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-12 h-100">
                    <div class="h-100 d-md-flex justify-content-between align-items-center">
                        <p>Welcome to Polyclinic no. 5</p>
                        <p>Opening Hours : Monday to Saturday - 8am to 10pm Contact : <span>04 225 8174</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header Area -->
    <div class="main-header-area" id="stickyHeader">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12 h-100">
                    <div class="main-menu h-100">
                        <nav class="navbar h-100 navbar-expand-lg">
                            <!-- Logo Area  -->
                            <a class="navbar-brand" href="index.php"><img src="img/core-img/logo.png" alt="Logo"></a>

                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#medilifeMenu" aria-controls="medilifeMenu" aria-expanded="false"
                                    aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

                            <div class="collapse navbar-collapse" id="medilifeMenu">
                                <!-- Menu Area -->
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="contact.php">Contact</a>
                                    </li>
                                </ul>
                                <!-- Login Button -->
                                <a href="login.php" class="btn medilife-appoint-btn ml-30"> <span>To Login</span> Click
                                    here</a>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- ***** Header Area End ***** -->

<!-- ***** Hero Area Start ***** -->
<section class="hero-area">
    <div class="hero-slides owl-carousel">
        <!-- Single Hero Slide -->
        <div class="single-hero-slide bg-img bg-overlay-white"
             style="height:800px; background-image: url(img/bg-img/g7.jpg);">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="offset-1 col-10">
                        <div class="hero-slides-content">
                            <h2 data-animation="fadeInUp" data-delay="100ms">Trained medical staff approved from the
                                Ministry of Health and Social Protection.</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Single Hero Slide -->
        <div class="single-hero-slide bg-img bg-overlay-white"
             style="height:800px; background-image: url(img/bg-img/g6.jpg);">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="offset-1 col-10">
                        <div class="hero-slides-content">
                            <h2 data-animation="fadeInUp" data-delay="100ms">Continuously improved health system and
                                modern environments.</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Single Hero Slide -->
        <div class="single-hero-slide bg-img bg-overlay-white"
             style="height:800px; background-image: url(img/bg-img/g5.jpg);">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="offset-1 col-10">
                        <div class="hero-slides-content">
                            <h2 data-animation="fadeInUp" data-delay="100ms">The public health system in Albania offers
                                free examinations for each citizen.</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Hero Area End ***** -->
<!-- ***** Cool Facts Area Start ***** -->
<section class="medilife-cool-facts-area section-padding-100-0">
    <div class="container">
        <div class="row">
            <!-- Single Cool Fact-->
            <?php
            require_once "database_class.php";
            $con = new \core\database();
            $count_patients_query = "SELECT count(*) nr FROM `medical_record`";
            $patients_result = \mysqli_query($con->connect(), $count_patients_query);
            $patients_row = \mysqli_fetch_array($patients_result, MYSQLI_ASSOC);

            $avg_visits_query = "SELECT avg(cnt) from (SELECT count(*) as cnt FROM `medical_visit` group by date_created) as avg";
            $avg_visits_result = \mysqli_query($con->connect(), $avg_visits_query);
            $avg_visits_row = \mysqli_fetch_array($avg_visits_result, MYSQLI_ASSOC);

            $count_doctors_query = "SELECT count(*) nr FROM `doctor`";
            $doctors_result = \mysqli_query($con->connect(), $count_doctors_query);
            $doctors_row = \mysqli_fetch_array($doctors_result, MYSQLI_ASSOC);
            ?>
            <div class="col-12 col-sm-6 col-lg-3" style="margin-left:14%">
                <div class="single-cool-fact-area text-center mb-100">
                    <i class="icon-atoms"></i>
                    <h2><span class="counter"><?= $patients_row['nr'] ?></span></h2>
                    <h6>Pacients</h6>
                </div>
            </div>
            <!-- Single Cool Fact-->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="single-cool-fact-area text-center mb-100">
                    <i class="icon-microscope"></i>
                    <h2><span class="counter"><?= $avg_visits_row['avg(cnt)'] ?></span></h2>
                    <h6>Average Visits per day</h6>
                </div>
            </div>
            <!-- Single Cool Fact-->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="single-cool-fact-area text-center mb-100">
                    <i class="icon-doctor-1"></i>
                    <h2><span class="counter"><?= $doctors_row['nr'] ?></span></h2>
                    <h6>Doctors</h6>
                </div>
            </div>
        </div>
    </div>
    <?php
    \mysqli_close($con->connection);

    ?>
</section>
<!-- ***** Cool Facts Area End ***** -->

<!-- ***** Gallery Area Start ***** -->
<div class="medilife-gallery-area owl-carousel" style="height:100%; width:100%; ">
    <!-- Single Gallery Item -->
    <div class="single-gallery-item">
        <img src="img/bg-img/g1.jpg" alt="">
        <div class="view-more-btn">
            <a href="img/bg-img/g1.jpg" class="btn gallery-img">See More +</a>
        </div>
    </div>
    <!-- Single Gallery Item -->
    <div class="single-gallery-item">
        <img src="img/bg-img/g2.jpg" alt="">
        <div class="view-more-btn">
            <a href="img/bg-img/g2.jpg" class="btn gallery-img">See More +</a>
        </div>
    </div>
    <!-- Single Gallery Item -->
    <div class="single-gallery-item">
        <img src="img/bg-img/g3.jpg" alt="">
        <div class="view-more-btn">
            <a href="img/bg-img/g3.jpg" class="btn gallery-img">See More +</a>
        </div>
    </div>

    <!-- Single Gallery Item -->
    <div class="single-gallery-item">
        <img src="img/bg-img/g4.png" alt="">
        <div class="view-more-btn">
            <a href="img/bg-img/g4.png" class="btn gallery-img">See More +</a>
        </div>
    </div>
</div>
<!-- ***** Gallery Area End ***** -->


<!-- ***** Emergency Area Start ***** -->
<div class="medilife-emergency-area section-padding-100-50">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="emergency-content">
                    <i class="icon-smartphone"></i>
                    <h2>For Emergency calls</h2>
                    <h3>112</h3>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="row">
                    <!-- Single Emergency Helpline -->
                    <div class="col-12 col-sm-6">
                        <div class="single-emergency-helpline mb-50" style="width:30rem">
                            <h5>Tirane, Albania</h5>
                            <p><strong> Email:</strong> medicalcentertest18@gmail.com <br> <strong> Tel:</strong> 04 225
                                8174 <br> <strong> Address:</strong> Islam Alla street, 50m from street entrance.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- ***** Emergency Area End ***** -->


<!-- jQuery (Necessary for All JavaScript Plugins) -->
<script src="js/jquery/jquery-2.2.4.min.js"></script>
<!-- Popper js -->
<script src="js/popper.min.js"></script>
<!-- Bootstrap js -->
<script src="js/bootstrap.min.js"></script>
<!-- Plugins js -->
<script src="js/plugins.js"></script>
<!-- Active js -->
<script src="js/active.js"></script>

</body>

</html>
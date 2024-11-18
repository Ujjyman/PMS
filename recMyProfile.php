<?php
require "crud_class.php";
session_start();
$crud = new \core\user\crud();
if (!isset($_SESSION['user']) == 'receptionist' and !isset($_SESSION['id']))
    header("Location: login.php");

$user = $crud->retrieve_receptionist($_SESSION['id']);
?>
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
    <style>
        .personaldiv {
            position: relative;
            width: 400px;
            height: 200px;
            border: 3px solid #73AD21;
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
                            <img src="img/core-img/logo.png" alt="Logo">


                            <div class="collapse navbar-collapse" id="medilifeMenu">
                                <!-- Menu Area -->
                                <ul class="navbar-nav ml-auto">
                                    <h2 class="breadcumb-title"
                                        style="color:white; margin-left:-15%; font-weight:900; font-family: Times, Times New Roman, serif;">
                                        Welcome Receptionist <?php echo $user->name ?> <?php echo $user->surname ?></h2>
                                    <div class="collapse navbar-collapse" id="medilifeMenu">
                                        <!-- Menu Area -->
                                        <ul class="navbar-nav ml-auto">
                                            <li class="nav-item" style="color:white; margin-left:15%;">
                                                <a class="nav-link" href="recHome.php">Home</a>
                                            </li>
                                        </ul>
                                        <!-- Login Button -->
                                        <a href="logout.php" class="btn medilife-appoint-btn ml-30"><span>Logout</span></a>
                                    </div>

                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- ***** Header Area End ***** -->

<!-- ***** Breadcumb Area Start ***** -->
<section class="breadcumb-area bg-img gradient-background-overlay"
         style="background-image: url(img/bg-img/breadcumb2.jpg); height:20px">
    <div class="container h-100">
        <div class="row h-100 align-items-center">

        </div>
    </div>
</section>
<!-- ***** Breadcumb Area End ***** -->

<!-- ***** Receptionist profile Area start ***** -->

<link rel="icon" type="image/png" href="imagesForm/icons/favicon.ico"/>
<link rel="stylesheet" type="text/css" href="vendorForm/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="fontsForm/font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="vendorForm/animate/animate.css">
<link rel="stylesheet" type="text/css" href="vendorForm/css-hamburgers/hamburgers.min.css">
<link rel="stylesheet" type="text/css" href="vendorForm/select2/select2.min.css">
<link rel="stylesheet" type="text/css" href="cssForm/util.css">
<link rel="stylesheet" type="text/css" href="cssForm/main.css">

<div class="bg-contact100" style="">
    <div class="container-contact100">
        <div class="wrap-contact100">
            <div class="contact100-pic js-tilt" data-tilt>
                <img src="Images/<?php echo $user->photo ?>">
            </div>


            <form class="contact100-form validate-form" method="post">
					<span class="contact100-form-title" style="color: #2f88fd">
                        <strong>	Personal Information</strong>
					</span>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Name:</strong> <?php echo $user->name ?></li>
                    <li class="list-group-item"><strong>Surname:</strong> <?php echo $user->surname ?></li>
                    <li class="list-group-item"><strong>Birthdate:</strong> <?php echo $user->birthdate ?></li>
                    <li class="list-group-item"><strong>Birthplace:</strong> <?php echo $user->birthplace ?></li>
                    <li class="list-group-item"><strong>Gender:</strong> <?php echo $user->gender ?></li>
                    <li class="list-group-item"><strong>Father's name:</strong> <?php echo $user->father_name ?></li>
                    <li class="list-group-item"><strong>Personal number:</strong> <?php echo $user->personal_id ?></li>
                    <li class="list-group-item"><strong>Academic Degree:</strong> <?php echo $user->academic_degree ?>
                    </li>
                    <li class="list-group-item"><strong>University:</strong> <?php echo $user->university ?></li>
                    <li class="list-group-item"><strong>Graduation Date:</strong> <?php echo $user->graduation_date ?>
                    </li>
                    <li class="list-group-item"><strong>Email:</strong> <?php echo $user->email ?></li>
                    <li class="list-group-item"><strong>Username:</strong> <?php echo $user->username ?></li>
                </ul>
            </form>
        </div>
    </div>
</div>
<!-- ***** <!-- ***** Receptionist profile Area end ***** -->


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
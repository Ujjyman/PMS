<?php
require "crud_class.php";
session_start();
$crud = new \core\user\crud();
if (!isset($_SESSION['user']) == 'receptionist' or !isset($_SESSION['id']))
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
                                        style="color:white; margin-left:-25%; font-weight:900; font-family: Times, Times New Roman, serif;">
                                        Welcome Receptionist <?php echo $user->name ?> <?php echo $user->surname ?></h2>
                                    <li class="nav-item active" style="color:white; margin-left:25%;">
                                        <button type="button" class="btn medilife-appoint-btn ml-30" id="logout"><span>Logout</span>
                                        </button>
                                    </li>

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

<script type="text/javascript">
    document.getElementById("logout").onclick = function () {
        location.href = "logout.php";
    };
</script>

<!-- ***** Breadcumb Area Start ***** -->
<section class="breadcumb-area bg-img gradient-background-overlay"
         style="background-image: url(img/bg-img/breadcumb1.jpg); height:20px">
    <div class="container h-100">
        <div class="row h-100 align-items-center">

        </div>
    </div>
</section>
<!-- ***** Breadcumb Area End ***** -->


<!-- ***** Icon Area Start ***** -->
<div class="all-icons-area section-padding-100-70">
    <div class="container" style="margin-left:16%">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="recMyProfile.php">
                    <div class="medilife-single-icon">
                        <i class="icon-hospital-8"></i>
                        <span>My profile</span>
                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="recPacList.php">
                    <div class="medilife-single-icon">
                        <i class="icon-clinic-history-2"></i>
                        <span>Patients' list</span>
                </a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <a href="recCreatePatient.php">
                <div class="medilife-single-icon">
                    <i class="icon-clinic-history-5"></i>
                    <span>Add new patient</span>
            </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <a href="recChangePassword.php">
            <div class="medilife-single-icon">
                <i class="icon-nuclear"></i>
                <span>Change password</span>
        </a>
    </div>
</div>

<div class="col-12 col-sm-6 col-md-4 col-lg-3">
    <a href="recDocList.php">
        <div class="medilife-single-icon">
            <i class="icon-doctor"></i>
            <span>Doctors' list</span>
    </a>
</div>
</div>
<div class="col-12 col-sm-6 col-md-4 col-lg-3">
    <a href="recCreateDoctor.php">
        <div class="medilife-single-icon">
            <i class="icon-doctor-1"></i>
            <span>Add new doctor</span>
    </a>
</div>
</div>
</div>
</div>
</div>
<!-- ***** Icon Area End ***** -->


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
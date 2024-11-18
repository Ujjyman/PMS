<?php
session_start();
require 'crud_class.php';

use core\database;

require_once "database_class.php";

$crud = new \core\user\crud();
if (isset($_POST['details']) && isset($_SESSION['id'])) {
    $con = new database();
    $user1 = $crud->retrieve_receptionist($_SESSION['id']);
    $user = $crud->retrieve_patient($_POST['details']);
    $query = "Select * from medical_record where id_patient='" . $user->id . "'";
    $result = \mysqli_query($con->connect(), $query);
    if (!$result) {
        echo "Some error occurred! Couldn't retrieve medical_record!" . \mysqli_error($con->connect());
        exit();
    }
    $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);
    $numRows = \mysqli_num_rows($result);
    if ($numRows == 1) {
        $hinr = $row['health_insurance_nr'];
        $date_created = $row['date_created'];
        $blood_type = $row['blood_type'];
        $rh_factor = $row['rh_factor'];
        $allergies = $row['allergies'];
        $anamnesis = $row['anamnesis'];
        $doctor_name = $row['doctor_name'];
        $doctor_surname = $row['doctor_surname'];
        $receptionist_name = $row['receptionist_name'];
        $receptionist_surname = $row['receptionist_surname'];
    }
}
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

<!-- ***** Change password Area start ***** -->

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
                <form class="contact100-form validate-form" method="post">
					<span class="contact100-form-title" style="color: #2f88fd">
                        <strong>Personal Information</strong>
					</span>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Name:</strong> <?php echo $user->name ?></li>
                        <li class="list-group-item"><strong>Surname:</strong> <?php echo $user->surname ?></li>
                        <li class="list-group-item"><strong>Birthdate:</strong> <?php echo $user->birthdate ?></li>
                        <li class="list-group-item"><strong>Birthplace:</strong> <?php echo $user->birthplace ?></li>
                        <li class="list-group-item"><strong>Gender:</strong> <?php echo $user->gender ?></li>
                        <li class="list-group-item"><strong>Father's name:</strong> <?php echo $user->father_name ?>
                        </li>
                        <li class="list-group-item"><strong>Personal number:</strong> <?php echo $user->personal_id ?>
                        </li>
                        <li class="list-group-item"><strong>Address:</strong> <?php echo $user->address ?></li>
                        <li class="list-group-item"><strong>Phone:</strong> <?php echo $user->phone ?></li>
                        <li class="list-group-item"><strong>Profession:</strong> <?php echo $user->profession ?></li>
                        <li class="list-group-item"><strong>Job:</strong> <?php echo $user->job ?></li>
                        <li class="list-group-item"><strong>Guardian:</strong> <?php echo $user->guardian ?></li>
                        <li class="list-group-item"><strong>Email:</strong> <?php echo $user->email ?></li>
                        <li class="list-group-item"><strong>Username:</strong> <?php echo $user->username ?></li>
                    </ul>
                </form>
            </div>


            <form class="contact100-form validate-form" method="post" action="recViewExaminations.php">
					<span class="contact100-form-title" style="color: #2f88fd">
                        <strong>Medical Record Information</strong>
					</span>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Health Insurance Number:</strong> <?php echo $hinr ?></li>
                    <li class="list-group-item"><strong>Blood Type:</strong> <?php echo $blood_type ?></li>
                    <li class="list-group-item"><strong>Rh_factor:</strong> <?php echo $rh_factor ?></li>
                    <li class="list-group-item"><strong>Allergies:</strong> <?php echo $allergies ?></li>
                    <li class="list-group-item"><strong>Anamnesis:</strong> <?php echo $anamnesis ?></li>
                    <li class="list-group-item"><strong>Family's
                            doctor:</strong> <?php echo $doctor_name . " " . $doctor_surname ?></li>
                    <li class="list-group-item"><strong>Created
                            By:</strong> <?php echo $receptionist_name . " " . $receptionist_surname ?></li>
                    <li class="list-group-item"><strong>Date of medical record's
                            creation:</strong> <?php echo $date_created ?></li>
                </ul>
                <button class="contact100-form-btn" name="details" type="submit" value="<?= $user->id ?>">View
                    Examinations
                </button>
            </form>

        </div>
    </div>
</div>

<!-- ***** <!-- ***** Change password Area end ***** -->

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
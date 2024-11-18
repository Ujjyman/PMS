<?php
session_start();
require 'crud_class.php';
require 'validate_class.php';

$action = new \core\user\crud();
$valid = new \core\logic\validate();
$user = $action->retrieve_doctor($_SESSION['id']);
if (isset($_POST['submit'])) {
    $currentPass = $user->password;
    if (isset($_POST['npass'])) {
        if (!$valid->checkPass($_POST['npass']))
            $np = "<p style='color:red'>Password must contain only 8 to 16 characters, at least one digit, 
                                    at least on upper case letter and at least one lower case letter!</p>";
    }
    if (isset($_POST['rnpass'])) {
        if ($_POST['rnpass'] != $_POST['npass']) {
            $rp = "<p style='color:red'>Passwords do not match!</p>";
        }
    }
    if (isset($_POST['pass'])) {
        if (!password_verify($_POST['pass'], $currentPass))
            $p = "<p style='color:red'>Current password is invalid!</p>";
    }
    if (!isset($p) && !isset($np) && !isset($rp)) {
        $pass = password_hash($_POST['npass'], PASSWORD_BCRYPT);

        $insertedOk = $action->changePass_doctor($user->id, $pass);
        if ($insertedOk) {
            $done = "Password changed successfully!";
            echo "<script type='text/javascript'>alert(\"$done\");</script>";
            $_POST['pass'] = "";
            $_POST['npass'] = "";
            $_POST['rnpass'] = "";
        } else {
            $done = "Error while changing the password!";
            echo "<script type='text/javascript'>alert(\"$done\");</script>";
        }
    }
}
?><!DOCTYPE html>
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
                                        style="color:white; margin-left:-50%; font-weight:900; font-family: Times, Times New Roman, serif;">
                                        Welcome Doctor <?php echo $user->name ?> <?php echo $user->surname ?></h2>
                                    <li class="nav-item dropdown" style="color:white; margin-left:50%;">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu</a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="docHome.php">Home</a>
                                            <a class="dropdown-item" href="docPatients.php">My Patients</a>
                                            <?php if ($user->is_director == '1') { ?><a class="dropdown-item"
                                                                                        href='viewStatistics.php'>Statistics</a><?php } ?>
                                            <a class="dropdown-item" href="docPassword.php">Change Password</a>
                                            <a class="dropdown-item" href="logout.php">Logout</a>
                                        </div>
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
                <img src="imagesForm/img-03.png" alt="IMG">
            </div>

            <form class="contact100-form validate-form" method="post">
					<span class="contact100-form-title" style="color: #2f88fd">
					<strong>	Change Password
					</span>

                <div class="wrap-input100 validate-input">
                    <input class="input100" type="password" name="pass"
                           value="<?= (isset($_POST['pass'])) ? $_POST['pass'] : "" ?>" required
                           placeholder="Current Password">
                    <span class="focus-input100"></span>
                    <?= (isset($p)) ? $p : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <input class="input100" type="password" name="npass"
                           value="<?= (isset($_POST['npass'])) ? $_POST['npass'] : "" ?>" placeholder="New Password">
                    <span class="focus-input100"></span>
                    <?= (isset($np)) ? $np : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <input class="input100" type="password" name="rnpass"
                           value="<?= (isset($_POST['rnpass'])) ? $_POST['rnpass'] : "" ?>" required
                           placeholder="Confirm Password">
                    <span class="focus-input100"></span>
                    <?= (isset($rp)) ? $rp : "" ?>
                </div>

                <div class="container-contact100-form-btn">
                    <input class="contact100-form-btn" name="submit" type="submit"
                           onclick="return confirm('Are you sure you want to change the password?')"
                           value="Save changes">

                </div>
            </form>
        </div>
    </div>
</div>

<!--===============================================================================================-->
<script src="vendorForm/jquery/jquery-3.2.1.min.js"></script>
<script src="vendorForm/tilt/tilt.jquery.min.js"></script>
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
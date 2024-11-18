<?php
require 'login_class.php';
require_once "recaptchalib.php";
$login = new \core\logic\login_class();
if (isset($_POST['user_type'])) {
    $secret = "6Lf_c0MUAAAAADbsUOoy6iJBZf8Yrgz_qMRzx-7n";
    $response = null;
    $reCaptcha = new ReCaptcha($secret);
    if ($_POST["g-recaptcha-response"]) {
        $response = $reCaptcha->verifyResponse(
            $_SERVER["REMOTE_ADDR"],
            $_POST["g-recaptcha-response"]
        );

    }
    if (isset($_POST['username']) && isset($_POST['password']) && $response != null && $response->success) {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        if ($_POST['user_type'] == 'patient') $login->login_patient($user, $pass);
        else if ($_POST['user_type'] == 'doctor') $login->login_doctor($user, $pass);
        else if ($_POST['user_type'] == 'receptionist') $login->login_receptionist($user, $pass);
    } else {
        echo "<script type='text/javascript'>alert(\"Fill all the fields and the recaptcha correctly!\");</script>";
    }
}

?>
<script src='https://www.google.com/recaptcha/api.js'></script>
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

    <!-- ***** Login form Start***** -->
    <script>
        // for Patient Log-IN start
        $(document).ready(function () {
            $("#login_form_patient").on("submit", function (e) {
                $(this).preventDefault();
                var postDataPatient = $(this).serializeArray();
                var formURL = $(this).attr("action");
                $.ajax({
                    url: formURL,
                    type: "POST",
                    data: postDataPatient,
                    success: function (data, textStatus, jqXHR) {
                    }
                });
            });

            // for patient Log-In end

            // for Doctor Log-IN start
            $("#login_form_doctor").on("submit", function (e) {
                $(this).preventDefault();
                var postDataDoctor = $(this).serializeArray();
                var formURL = $(this).attr("action");
                $.ajax({
                    url: formURL,
                    type: "POST",
                    data: postDataDoctor,
                    success: function (data, textStatus, jqXHR) {
                    }
                });
            });

            // for Doctor Log-In end

            // for Receptionist Log-IN start
            $("#login_form_receptionist").on("submit", function (e) {
                $(this).preventDefault();
                var postDataReceptionist = $(this).serializeArray();
                var formURL = $(this).attr("action");
                $.ajax({
                    url: formURL,
                    type: "POST",
                    data: postDataReceptionist,
                    success: function (data, textStatus, jqXHR) {
                    }
                });
            });

            // for Receptionist Log-In end

        });


    </script>


    <!-- Modal  for patient start -->
    <div class="modal fade" id="patient_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document" id="login_dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <center><h3 style="margin-left: 120px">Log In as Patient</h3></center>

                </div>
                <form method="POST" role="form" action="" id="login_form_patient">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="formGroupExampleInput">Username</label>
                            <input type="text" class="form-control" name="username" value=""
                                   placeholder="Enter your username" required>
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">Password</label>
                            <input type="password" class="form-control" name="password" value=""
                                   placeholder="Enter your password" required>
                        </div>
                        <div style="margin-left:80px;" class="g-recaptcha"
                             data-sitekey="6Lf_c0MUAAAAANmqJb1MzvYKOZaB22zRvJmWkq1-"></div>
                        <br>
                        <input type="hidden" id="user_type" name="user_type" value="patient">

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"> Login</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal  for patient end -->

    <!-- Modal  for doctor start -->
    <div class="modal fade" id="doctor_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document" id="login_dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <center><h3 style="margin-left: 120px">Log In as Doctor</h3></center>

                </div>
                <form method="POST" role="form" action="" id="login_form_doctor">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="formGroupExampleInput">Username</label>
                            <input type="text" class="form-control" name="username" value="" required
                                   placeholder="Enter your username">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">Password</label>
                            <input type="password" class="form-control" name="password" value="" required
                                   placeholder="Enter your password">
                        </div>
                        <div style="margin-left:80px;" class="g-recaptcha"
                             data-sitekey="6Lf_c0MUAAAAANmqJb1MzvYKOZaB22zRvJmWkq1-"></div>
                        <br>
                        <input type="hidden" id="user_type" name="user_type" value="doctor">

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="login_button_doctor"> Login</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal  for doctor end -->

    <!-- Modal  for receptionist start -->
    <div class="modal fade" id="receptionist_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document" id="login_dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <center><h3 style="margin-left: 80px">Log In as Receptionist</h3></center>

                </div>
                <form method="POST" role="form" action="" id="login_form_receptionist">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="formGroupExampleInput">Username</label>
                            <input type="text" class="form-control" name="username" value="" required
                                   placeholder="Enter your username">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">Password</label>
                            <input type="password" class="form-control" name="password" value="" required
                                   placeholder="Enter your password">
                        </div>
                        <div style="margin-left:80px;" class="g-recaptcha"
                             data-sitekey="6Lf_c0MUAAAAANmqJb1MzvYKOZaB22zRvJmWkq1-"></div>
                        <br>
                        <input type="hidden" id="user_type" name="user_type" value="receptionist">

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="login_button_receptionist"> Login</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal  for receptionist end -->

    <!-- ***** Login form End***** -->

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
                                        <a class="nav-link" href="index.php">Home </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="contact.php">Contact</a>
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
         style="background-image: url(img/bg-img/breadcumb1.jpg); height:20px">
    <div class="container h-100">
    </div>
</section>
<!-- ***** Breadcumb Area End ***** -->

<!-- ***** Icon Area Start ***** -->
<div class="all-icons-area section-padding-100-70" style="margin-left: 18%">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="medilife-single-icon" data-toggle="modal" data-target="#patient_Modal">
                    <i class="icon-medical-history"></i>
                    <span>Login as Patient</span>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="medilife-single-icon" data-toggle="modal" data-target="#doctor_Modal">
                    <i class="icon-stethoscope"></i>
                    <span>Login as Doctor</span>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="medilife-single-icon" data-toggle="modal" data-target="#receptionist_Modal">
                    <i class="icon-clipboard-2"></i>
                    <span>Login as Receptionist</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** Icon Area End ***** -->

<div class="medilife-emergency-area section-padding-100-50">
    <div class="container" style="margin-top: -5%">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="emergency-content">
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


<?php
require 'crud_class.php';
require 'validate_class.php';

session_start();
$action = new \core\user\crud();
$valid = new \core\logic\validate();

if (!isset($_SESSION['user']) == 'receptionist' or !isset($_SESSION['id']))
    header("Location: login.php");

$user = $action->retrieve_receptionist($_SESSION['id']);

if (!empty($_FILES["file"]) && $_FILES['file']['error'] == 0) {

    $target_dir = "upload_patient/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $myFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check file size
    if ($_FILES["file"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($myFileType != "xml") {
        echo "Please Upload a xml file";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded.";
            $file = basename($target_file);

			$xml = simplexml_load_file("upload_patient/".$file) or die("Error: Cannot create object");
			
            $newfilename = "default.jpg";

            $username = $xml->patient->username;
            $query = "SELECT * FROM `patient` WHERE username = '$username'";
            $result = \mysqli_query($action->con->connect(), $query);
            if ($result) {
                $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);
                $query2 = "SELECT * FROM `medical_record` WHERE id_patient = '" . $row['id'] . "'";
                $result2 = \mysqli_query($action->con->connect(), $query2);
                $row2 = \mysqli_fetch_array($result2, MYSQLI_ASSOC);
                $action->delete_medical_record($row2['id']);
            }

            $insertedOk = $action->create_medical_record_from_import(
                $newfilename
                , $xml->patient->name
                , $xml->patient->father_name
                , $xml->patient->surname
                , $xml->patient->personal_id
                , $xml->patient->gender
                , $xml->patient->phone
                , $xml->patient->address
                , $xml->patient->profession
                , $xml->patient->job
                , $xml->patient->guardian
                , $xml->patient->birthdate
                , $xml->patient->birthplace
                , $xml->patient->email
                , $xml->patient->username
                , $xml->patient->password

                , $xml->health_insurance_nr
                , $xml->polyclinic_nr
                , $xml->date_created
                , $user->id
                , $xml->blood_type
                , $xml->rh_factor
                , $xml->allergies
                , $xml->anamnesis
                , $xml->doctor_name
                , $xml->doctor_surname
                , $user->name
                , $user->surname
            );
            if (!$insertedOk) {
                echo "<script> alert('Sorry, there was an error uploading data');</script>";
                exit();
            }
            $username = $xml->patient->username;
            $query = "SELECT * FROM `patient` WHERE username = '$username'";
            $result = \mysqli_query($action->con->connect(), $query);
            if (!$result) {
                echo "<script type='text/javascript'>alert(\"Some error occurred!\");</script>";
                exit();
            }
            $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);
            $numRows = \mysqli_num_rows($result);
            if ($numRows == 1) {
                $query2 = "Select * from medical_record where id_patient='" . $row['id'] . "'";
                $result2 = \mysqli_query($action->con->connect(), $query2);
                if (!$result2) {
                    echo "<script type='text/javascript'>alert(\"Some error occurred 22!\");</script>";
                    exit();
                }
                $row2 = \mysqli_fetch_array($result2, MYSQLI_ASSOC);
                $numRows2 = \mysqli_num_rows($result2);
                if ($numRows2 == 1) {

                    foreach ($xml->visits->visit as $visit) {
                        $created = $action->create_medical_visit_from_import(
                            $row2['id']
                            , $visit->date_created
                            , $visit->complaints
                            , $visit->diagnosis
                            , $visit->medicines
                            , $visit->days_off
                            , $visit->is_infectious
                            , $visit->doctor_name
                            , $visit->doctor_surname
                            , $visit->receptionist_name
                            , $visit->receptionist_surname
                        );

                    }
                }

            }

            echo "<script> alert('Upload was successful');</script>";


        } else {
            //    unlink("upload_patient/".$file);
            echo "<script> alert('Sorry, there was an error uploading your file.');</script>";
        }
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
                                        <a href="logout.php" class="btn medilife-appoint-btn ml-30"> <span>Logout</span></a>
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
                <img src="imagesForm/img-07.png" alt="IMG">
            </div>

            <form class="contact100-form validate-form" method="post" enctype="multipart/form-data">
                <div class="wrap-input100 validate-input">
                    <input class="input100" type="file" name="file" id="file" value="" required>
                    <span class="focus-input100"></span>
                </div>
                <div class="container-contact100-form-btn">
                    <input class="contact100-form-btn" type="submit" name="submit"
                           onclick="return confirm('Are you sure you want to continue?')"
                           value="Create patient from this file">
                </div>
            </form>
        </div>
    </div>
</div>

<!--===============================================================================================-->
<script src="vendorForm/jquery/jquery-3.2.1.min.js"></script>
<script src="vendorForm/tilt/tilt.jquery.min.js"></script>

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
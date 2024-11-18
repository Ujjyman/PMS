<?php

require "crud_class.php";
require "validate_class.php";
require_once "database_class.php";

use core\database;

session_start();
$crud = new \core\user\crud();
$valid = new \core\logic\validate();
if (!isset($_SESSION['user']) == 'doctor' or !isset($_SESSION['id']))
    header("Location: login.php");

$user = $crud->retrieve_doctor($_SESSION['id']);
$con = new database();
if (isset($_POST['details'])) {
    $con = new database();
    $medical_record = $crud->retrieve_medical_record($_POST['details']);
    $doctor = $medical_record->id_doctor;

    $receptionist = $medical_record->created_by;

    $query = "Select * from patient where id='" . $_POST['details'] . "'";
    $result = \mysqli_query($con->connect(), $query);
    if (!$result) {
        echo "<p style='color:red'>Some error occurred! Couldn't retrieve patient!</p>" . \mysqli_error($con->connect());
        exit();
    }

    $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);
    $numRows = \mysqli_num_rows($result);
    $query2 = "Select * from doctor where id='" . $doctor . "'";
    $result2 = \mysqli_query($con->connect(), $query2);
    $row2 = \mysqli_fetch_array($result2, MYSQLI_ASSOC);
    $query3 = "Select * from receptionist where id='" . $receptionist . "'";
    $result3 = \mysqli_query($con->connect(), $query3);
    $row3 = \mysqli_fetch_array($result3, MYSQLI_ASSOC);


    $_POST['id'] = $medical_record->id;
    $_POST['id_patient'] = $_POST['details'];
    $_POST['id_doctor'] = $row2['id'];
    $_POST['id_receptionist'] = $row3['id'];
    $_POST['dn'] = $row2['name'];
    $_POST['ds'] = $row2['surname'];
    $_POST['rn'] = $row3['name'];
    $_POST['rs'] = $row3['surname'];
    $_POST['father_name'] = $row['father_name'];
    $_POST['name'] = $row['name'];
    $_POST['surname'] = $row['surname'];
    $_POST['gender'] = $row['gender'];
    $_POST['birthdate'] = $row['birthdate'];
}
if (isset($_POST['submit'])) {

    $is_infectious = isset($_POST['isinfectious']) ? $_POST['isinfectious'] : 0;
    if (isset($_POST['diagnosis'])) {
        if (!$valid->checkMsg($_POST['diagnosis']))
            $d = "<p style='color:red'> Only letters, numbers, spaces and symbols : ; , . - _  are allowed. </p>";
    }
    if (isset($_POST['complaints'])) {
        if (!$valid->checkMsg($_POST['complaints']))
            $c = "<p style='color:red'> Only letters, numbers, spaces and symbols : ; , . - _  are allowed. </p>";
    }
    if (isset($_POST['medicines'])) {
        if (!$valid->checkMsg($_POST['medicines']))
            $m = "<p style='color:red'> Only letters, numbers, spaces and symbols : ; , . - _ are allowed.  </p>";
    }

    if (!isset($d) && !isset($c) && !isset($m)) {
        $fill = $crud->create_medical_visit($_POST['id'], $_POST['id_doctor'], $_POST['id_receptionist']
            , date('y-m-d'), $_POST['complaints'], $_POST['diagnosis'], $_POST['medicines'], $_POST['dayoff']
            , $is_infectious, $_POST['dn'], $_POST['ds'], $_POST['rn'], $_POST['rs']);
        if ($fill) {
            $_POST['diagnosis'] = "";
            $_POST['medicines'] = "";
            $_POST['complaints'] = "";
            $_POST['dayoff'] = "";

            $query2 = "Select MAX(id) from medical_visit where id_doctor='" . $_POST['id_doctor'] . "'";
            $result2 = \mysqli_query($con->connect(), $query2);
            $row2 = \mysqli_fetch_array($result2, MYSQLI_ASSOC);

            $query3 = "Select * from medical_visit where id='" . $row2['MAX(id)'] . "'";
            $result3 = \mysqli_query($con->connect(), $query3);
            $row3 = \mysqli_fetch_array($result3, MYSQLI_ASSOC);

            $query4 = "Select * from medical_record where id='" . $row3['id_medical_record'] . "'";
            $result4 = \mysqli_query($con->connect(), $query4);
            $row4 = \mysqli_fetch_array($result4, MYSQLI_ASSOC);

            $query5 = "Select * from patient where id='" . $row4['id_patient'] . "'";
            $result5 = \mysqli_query($con->connect(), $query5);
            $row5 = \mysqli_fetch_array($result5, MYSQLI_ASSOC);
            if ($row3['is_infectious'] == 0) $answer = "Yes";
            else $answer = "No";

            $file_name = "./Receipts/" . $row5['name'] . "_" . $row5['surname'] . ".pdf";
            require('fpdf181/fpdf.php');
            $pdf = new FPDF();
            $pdf->SetFont('Arial', '', 13);
            $pdf->AddPage();
            $pdf->Image('img/core-img/logo.png', 10, 0, 50);
            $pdf->Cell(0, 10, 'visit_id: ' . $row3['id'], 0, 1, "R");
            $pdf->Cell(0, 10, 'Date:  ' . $row3['date_created'], 0, 1, "R");
            $pdf->SetFont('Arial', 'B', 22);
            $pdf->Cell(0, 30, 'Polyclinic Nr.5', 0, 1, "C");
            $pdf->SetFont('Arial', 'U', 16);
            $pdf->Cell(10, 10, 'Patient\'s information:', 0, 1);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(10, 10, 'Patient:  ', 0, 0);
            $pdf->Cell(50);
            $pdf->Cell(10, 10, $row5['name'] . ' ' . $row5['father_name'] . ' ' . $row5['surname'], 0, 1);
            $pdf->Cell(10, 10, 'Personal Nr:  ', 0, 0);
            $pdf->Cell(50);
            $pdf->Cell(10, 10, $row5['personal_id'], 0, 1);
            $pdf->Cell(10, 10, 'Health Insurance Nr:  ', 0, 0);
            $pdf->Cell(50);
            $pdf->Cell(10, 10, $row4['health_insurance_nr'], 0, 1);
            $pdf->Cell(10, 10, 'Blood Type:  ', 0, 0);
            $pdf->Cell(50);
            $pdf->Cell(10, 10, $row4['blood_type'], 0, 1);
            $pdf->Cell(10, 10, 'Rh factor:  ', 0, 0);
            $pdf->Cell(50);
            $pdf->Cell(10, 10, $row4['rh_factor'], 0, 1);
            $pdf->Cell(10, 10, 'Allergies:  ', 0, 0);
            $pdf->Cell(50);
            $pdf->Cell(10, 10, $row4['allergies'], 0, 1);
            $pdf->Cell(10, 10, '', 0, 1);
            $pdf->SetFont('Arial', 'U', 16);
            $pdf->Cell(10, 10, 'Medical Visit:', 0, 1);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(10, 10, 'Doctor:  ', 0, 0);
            $pdf->Cell(50);
            $pdf->Cell(10, 10, $row3['doctor_name'] . ' ' . $row3['doctor_surname'], 0, 1);
            $pdf->Cell(10, 10, 'Patient\'s complaints:  ', 0, 1);
            $pdf->MultiCell(190, 10, $row3['complaints'], 1, 1);
            $pdf->Cell(10, 10, 'Diagnosis:  ', 0, 1);
            $pdf->MultiCell(190, 10, $row3['diagnosis'], 1, 1);
            $pdf->Cell(10, 10, 'Medicines:  ', 0, 1);
            $pdf->MultiCell(190, 10, $row3['medicines'], 1, 1);
            $pdf->Cell(10, 10, 'Days off:  ', 0, 0);
            $pdf->Cell(50);
            $pdf->Cell(10, 10, $row3['days_off'], 0, 1);
            $pdf->Cell(10, 10, 'Is this disease infectious?  ', 0, 0);
            $pdf->Cell(50);
            $pdf->Cell(10, 10, $answer, 0, 1);
            $pdf->Cell(0, 10, 'Doctor\'s signature:  ', 0, 1, "R");
            $pdf->Cell(145);
            $pdf->Cell(40, 10, '', "B", 1, "R");
            $pdf->Output('F', $file_name);
            $_POST['examinations'] = $row4['id_patient'];
            echo "<script type='text/javascript' language='Javascript'>window.open('$file_name','_blank'); window.open('docHome.php','_self');</script>";

        }

    } else  echo "<script>alert('Please fill the fields!');</script>";

}
?>

<script>
    //

    function confirm_alert(node) {
        return confirm("You are sure? Click OK to continue or CANCEL to quit.");
    }
</script>

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
                                        style="color:white; margin-left:-50%; font-weight:900; font-family: Times, Times New Roman, serif;">
                                        Welcome Doctor <?php echo $user->name ?> <?php echo $user->surname ?></h2>
                                    <li class="nav-item dropdown" style="color:white; margin-left:50%;">
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

<!-- ***** Create Visit Area start ***** -->
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
                <img src="imagesForm/img-04.png" alt="IMG">
            </div>

            <form class="contact100-form validate-form" method="post" action="">
					<span class="contact100-form-title" style="color: #2f88fd">
                        <strong>	Create Visit </strong>
					</span>
                <ul class="list-group list-group-flush">
                    <input type="hidden" name="id" value="<?= (isset($_POST['id'])) ? $_POST['id'] : "" ?>">
                    <input type="hidden" name="id_patient"
                           value="<?= (isset($_POST['id_patient'])) ? $_POST['id_patient'] : "" ?>">
                    <input type="hidden" name="id_doctor"
                           value="<?= (isset($_POST['id_doctor'])) ? $_POST['id_doctor'] : "" ?>">
                    <input type="hidden" name="id_receptionist"
                           value="<?= (isset($_POST['id_receptionist'])) ? $_POST['id_receptionist'] : "" ?>">
                    <input type="hidden" name="rn" value="<?= (isset($_POST['rn'])) ? $_POST['rn'] : "" ?>">
                    <input type="hidden" name="rs" value="<?= (isset($_POST['rs'])) ? $_POST['rs'] : "" ?>">

                    <li class="list-group-item"><strong>Name:</strong> <input type="text" name="name"
                                                                              value="<?= (isset($_POST['name'])) ? $_POST['name'] : "" ?>"
                                                                              readonly></li>
                    <li class="list-group-item"><strong>Father's Name:</strong> <input type="text" name="father_name"
                                                                                       value="<?= (isset($_POST['father_name'])) ? $_POST['father_name'] : "" ?>"
                                                                                       readonly></li>
                    <li class="list-group-item"><strong>Surname:</strong> <input type="text" name="surname"
                                                                                 value="<?= (isset($_POST['surname'])) ? $_POST['surname'] : "" ?>"
                                                                                 readonly></li>
                    <li class="list-group-item"><strong>Gender:</strong> <input type="text" name="gender"
                                                                                value="<?= (isset($_POST['gender'])) ? $_POST['gender'] : "" ?>"
                                                                                readonly></li>
                    <li class="list-group-item"><strong>Birthdate:</strong> <input type="text" name="birthdate"
                                                                                   value="<?= (isset($_POST['birthdate'])) ? $_POST['birthdate'] : "" ?>"
                                                                                   readonly></li>
                    <li class="list-group-item"><strong>Doctor Name:</strong> <input type="text" name="dn"
                                                                                     value="<?= (isset($_POST['dn'])) ? $_POST['dn'] : "" ?>"
                                                                                     readonly></li>
                    <li class="list-group-item"><strong>Doctor Surname:</strong> <input type="text" name="ds"
                                                                                        value="<?= (isset($_POST['ds'])) ? $_POST['ds'] : "" ?>"
                                                                                        readonly></li>
                    <li class="list-group-item"><strong>Birthplace:</strong> php</li>

                </ul>
                <div class="wrap-input100 validate-input">
                    <textarea class="input100" name="complaints" placeholder="Complaints" required></textarea>
                    <span class="focus-input100"></span>
                </div>
                <?= (isset($c)) ? $c : "" ?>
                <div class="wrap-input100 validate-input">
                    <textarea class="input100" name="diagnosis" placeholder="Diagnosis" required></textarea>
                    <span class="focus-input100"></span>
                </div>
                <?= (isset($d)) ? $d : "" ?>
                <div class="wrap-input100 validate-input">
                    <textarea class="input100" name="medicines" placeholder="Medicines" required></textarea>
                    <span class="focus-input100"></span>
                </div>
                <?= (isset($m)) ? $m : "" ?>
                <div class="wrap-input100 validate-input">

                    <input class="input100" type="number" min="0" name="dayoff" required placeholder="Days off">
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input">
                    <label>Is Infectious?</label>
                    <input type="checkbox" name="isinfectious" value="1">
                    <span class="focus-input100"></span>
                </div>


                <div class="container-contact100-form-btn">

                    <input class="contact100-form-btn" name="submit" value="Save Visit" type="submit"
                           onclick="return confirm('Are you sure you want to save this visit?')">

                </div>
            </form>
        </div>
    </div>
</div>

<!--===============================================================================================-->
<script src="vendorForm/jquery/jquery-3.2.1.min.js"></script>
<script src="vendorForm/tilt/tilt.jquery.min.js"></script>


<!-- ***** <!-- ***** Create Visit Area end ***** -->


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
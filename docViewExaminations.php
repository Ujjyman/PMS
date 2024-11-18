<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require 'crud_class.php';

use core\database;

require_once "database_class.php";
$crud = new \core\user\crud();
$con = new database();
if (isset($_POST['submit'])) {
    $query3 = "Select * from medical_visit where id='" . $_POST['id'] . "'";
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
    echo "<script type='text/javascript' language='Javascript'>window.open('$file_name');</script>";
}
if (isset($_SESSION['id']) && isset($_POST['examinations'])){
$user1 = $crud->retrieve_doctor($_SESSION['id']);
$user = $crud->retrieve_patient($_POST['examinations']);


?>
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
                                        Welcome Doctor <?php echo $user1->name ?> <?php echo $user1->surname ?></h2>
                                    <li class="nav-item dropdown" style="color:white; margin-left:50%;">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu</a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="docHome.php">Home</a>
                                            <a class="dropdown-item" href="docPatients.php">My Patients</a>
                                            <?php if ($user1->is_director == '1') { ?><a class="dropdown-item"
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
    </div>
</section>
<!-- ***** Breadcumb Area End ***** -->

<!-- ***** Records Area start ***** -->
<link rel="icon" type="image/png" href="imagesForm/icons/favicon.ico"/>
<link rel="stylesheet" type="text/css" href="vendorForm/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="fontsForm/font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="vendorForm/animate/animate.css">
<link rel="stylesheet" type="text/css" href="vendorForm/css-hamburgers/hamburgers.min.css">
<link rel="stylesheet" type="text/css" href="vendorForm/select2/select2.min.css">
<link rel="stylesheet" type="text/css" href="cssForm/util.css">
<link rel="stylesheet" type="text/css" href="cssForm/main.css">
<div class="bg-contact100" style="">
    <?php
    $query = "Select * from medical_record where id_patient='" . $user->id . "'";
    $result = \mysqli_query($con->connect(), $query);
    $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);
    $query2 = "Select * from medical_visit where id_medical_record='" . $row['id'] . "'";
    $result2 = \mysqli_query($con->connect(), $query2);
    $numRows = \mysqli_num_rows($result2);
    if ($numRows == 1) {
        if ($numRows == 0) $missing = "<div style='width:100%; margin-top:10%;  color: midnightblue; font-size:25px; text-align: center; display:block;'> You do not have any medical visits!</div>";
        $x = 1;
        while ($row2 = \mysqli_fetch_array($result2, MYSQLI_ASSOC)) {


            echo "<div class='container-contact100'>";
            echo "<div class='wrap-contact100'>";
            echo "<div class='row'>";
            echo "<div style='width: 20rem; margin-left:80%;'>";
            echo "<form class='contact100-form validate-form' method='post' action=''>";
            echo "<ul class='list-group list-group-flush'>";
            echo "<li><h5 class='card-title'>Examination Visit " . $x . "</h5></li>";
            echo "<li><p class='card-text'>Date Created: " . $row2['date_created'] . "</p></li>";
            echo "<li><p class='card-text'>Family's doctor: " . $row2['doctor_name'] . " " . $row2['doctor_surname'] . "</p></li>";
            echo "<li><p class='card-text'>Complaints: " . $row2['complaints'] . "</p></li>";
            echo "<li><p class='card-text'>Diagnosis: " . $row2['diagnosis'] . "</p></li>";
            echo "<li><p class='card-text'>Medicines: " . $row2['medicines'] . "</p></li>";
            echo "<li><p class='card-text'>Days off: " . $row2['days_off'] . "</p></li>";
            echo "<li><p class='card-text'>Is this an infectious disease: ";
            if ($row2['is_infectious'] == 0) echo "No";
            else echo "Yes";
            echo "</p></li>";
            echo "</ul>";
            echo "<input name='id' type='hidden' value='" . $row2['id'] . "'>";
            echo "<div class='container-contact100-form-btn'>";
            echo "<input class='contact100-form-btn' type='submit' value='Download' name='submit'>";
            echo " </div>";
            echo "</form>";
            echo " </div>";
            echo " </div>";
            echo "</div>";
            echo "</div>";
            $x++;
        }
        echo (isset($missing)) ? $missing : "";
    } else {
        ?>
        <section class="hero-area">
            <div class="hero-slides owl-carousel" style="">
                <?php
                if ($numRows == 0) $missing = "<div style='width:100%; margin-top:10%;  color: midnightblue; font-size:25px; text-align: center; display:block;'> You do not have any medical visits!</div>";
                $x = 1;
                while ($row2 = \mysqli_fetch_array($result2, MYSQLI_ASSOC)) {


                    echo "<div class='container-contact100'>";
                    echo "<div class='wrap-contact100'>";
                    echo "<div class='row'>";
                    echo "<div style='width: 20rem; margin-left:80%;'>";
                    echo "<form class='contact100-form validate-form' method='post' action=''>";
                    echo "<ul class='list-group list-group-flush'>";
                    echo "<li><h5 class='card-title'>Examination Visit " . $x . "</h5></li>";
                    echo "<li><p class='card-text'>Date Created: " . $row2['date_created'] . "</p></li>";
                    echo "<li><p class='card-text'>Family's doctor: " . $row2['doctor_name'] . " " . $row2['doctor_surname'] . "</p></li>";
                    echo "<li><p class='card-text'>Complaints: " . $row2['complaints'] . "</p></li>";
                    echo "<li><p class='card-text'>Diagnosis: " . $row2['diagnosis'] . "</p></li>";
                    echo "<li><p class='card-text'>Medicines: " . $row2['medicines'] . "</p></li>";
                    echo "<li><p class='card-text'>Days off: " . $row2['days_off'] . "</p></li>";
                    echo "<li><p class='card-text'>Is this an infectious disease: ";
                    if ($row2['is_infectious'] == 0) echo "No";
                    else echo "Yes";
                    echo "</p></li>";
                    echo "</ul>";
                    echo "<input name='id' type='hidden' value='" . $row2['id'] . "'>";
                    echo "<div class='container-contact100-form-btn'>";
                    echo "<input class='contact100-form-btn' type='submit' value='Download' name='submit'>";
                    echo " </div>";
                    echo "</form>";
                    echo " </div>";
                    echo " </div>";
                    echo "</div>";
                    echo "</div>";
                    $x++;
                }

                echo "</div>";
                echo (isset($missing)) ? $missing : "";
                ?>
        </section>
    <?php }
    } ?>
</div>
<!--===============================================================================================-->
<script src="vendorForm/jquery/jquery-3.2.1.min.js"></script>
<script src="vendorForm/tilt/tilt.jquery.min.js"></script>
<!-- ***** <!-- ***** Records Area end ***** -->


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
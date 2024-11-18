<?php
session_start();
require 'crud_class.php';
require_once "database_class.php";

use core\database;

$crud = new \core\user\crud();
if (!isset($_SESSION['user']) == 'doctor' or !isset($_SESSION['id']))
    header("Location: login.php");

$con = new database();
$user = $crud->retrieve_doctor($_SESSION['id']);
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
            <div class="col-sm-6">


                <div style="width: 60rem; margin-left:-14%;">
                    <div class="card-body" style="color: #2f88fd; text-align: center;">
                        <h5 class="card-title">Patients' list</h5>
                    </div>
                    <input type="text" id="myInput1"
                           style="border: 2px outset white;background-color: rgba(67,121,232,0.11); width: 60rem; border-radius: 50px"
                           onkeyup="myFunction(1)" placeholder="Search a name..">
                    <table class="table table-hover" id="patient_table">
                        <thead style="background-color: #2f88fd; color:white;">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Full name</th>
                            <th scope="col">Birthdate</th>
                            <th scope="col">Personal no.</th>
                            <th scope="col" colspan="5" style="text-align: center;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $con = new database();
                        $query = "Select * from medical_record where id_doctor='" . $_SESSION['id'] . "'";
                        $result = \mysqli_query($con->connect(), $query);
                        if (\mysqli_num_rows($result) == 0) {
                            echo "<td colspan='2'></td>";
                            echo "<td colspan='6'>" . "You don't have patients yet!" . "</td>";
                        }
                        $cnt = 1;
                        while ($row = \mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $patient_id = $row['id_patient'];
                            $query3 = "Select * from patient where id='" . $patient_id . "'";
                            $result3 = \mysqli_query($con->connect(), $query3);
                            $row2 = \mysqli_fetch_array($result3, MYSQLI_ASSOC);
                            echo "<tr>";
                            echo "<td>" . $cnt . "</td>";
                            echo "<td>" . $row2['name'] . " " . $row2['father_name'] . " " . $row2['surname'] . "</td>";
                            echo "<td>" . $row2['birthdate'] . "</td>";
                            echo "<td>" . $row2['personal_id'] . "</td>";
                            $_SESSION['patient'] = $row2['id'];
                            ?>
                            <td>
                                <form style="margin: 0; padding: 0;" action="docViewPacProfile.php" method="post">
                                    <button style="display: inline;color: #2f88fd;" name="details" type="submit"
                                            value="<?= $row2['id'] ?>">Visit profile
                                    </button>
                                </form>
                            </td>
                            <?php
                            echo "</tr>";
                            $cnt++;
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
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

    <script>
        function myFunction(a) {
            // Declare variables
            var input, filter, table, tr, td, i;
            input = document.getElementById("myInput1");
            filter = input.value.toUpperCase();
            table = document.getElementById("patient_table");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

    </script>
</body>

</html>
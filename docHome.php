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

<!-- ***** Personal information Area start ***** -->
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
            <div class="row">
                <div>
                    <div style="width: 20rem; margin-left:-40%; ">
                        <div class="card-body" style="color: #2f88fd">
                            <h5 class="card-title">Personal Information</h5>
                        </div>
                        <img class="card-img-top" style="width:100px; height:100px"
                             src="Images/<?php echo $user->photo ?>">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Name:</strong> <?php echo $user->name ?> </li>
                            <li class="list-group-item"><strong>Father's name:</strong> <?php echo $user->father_name ?>
                            </li>
                            <li class="list-group-item"><strong>Surname:</strong> <?php echo $user->surname ?></li>
                            <li class="list-group-item"><strong>Personal ID:</strong> <?php echo $user->personal_id ?>
                            </li>
                            <li class="list-group-item"><strong>Gender:</strong> <?php echo $user->gender ?></li>
                            <li class="list-group-item"><strong>Phone:</strong> <?php echo $user->phone ?></li>
                            <li class="list-group-item"><strong>Birthdate:</strong> <?php echo $user->birthdate ?></li>
                            <li class="list-group-item"><strong>Birthplace:</strong> <?php echo $user->birthplace ?>
                            </li>
                            <li class="list-group-item"><strong>Academic
                                    degree:</strong> <?php echo $user->academic_degree ?></li>
                            <li class="list-group-item"><strong>University:</strong> <?php echo $user->university ?>
                            </li>
                            <li class="list-group-item"><strong>Graduation
                                    date:</strong> <?php echo $user->graduation_date ?></li>
                            <li class="list-group-item"><strong>Speciality:</strong> <?php echo $user->speciality ?>
                            </li>
                            <li class="list-group-item"><strong>Email:</strong> <?php echo $user->email ?></li>
                            <li class="list-group-item"><strong>Username:</strong> <?php echo $user->username ?></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div style="width: 50rem; margin-left:-27%;">
                        <div class="card-body" style="color: #2f88fd; text-align: center;">
                            <h5 class="card-title">Waiting list</h5>
                        </div>
                        <table class="table table-hover">
                            <thead style="background-color: #2f88fd; color:white;">
                            <tr style="text-align: center;">
                                <th scope="col">ID</th>
                                <th scope="col">First name</th>
                                <th scope="col">Father's name</th>
                                <th scope="col">Last name</th>
                                <th scope="col">Birthdate</th>
                                <th scope="col">Personal no.</th>
                                <th scope="col" colspan="2" style="text-align: center;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $con = new database();
                            $query = "Select * from medical_record where in_waiting='1' and id_doctor='" . $_SESSION['id'] . "'";
                            $result = \mysqli_query($con->connect(), $query);
                            if (\mysqli_num_rows($result) == 0) {
                                echo "<td colspan='2'></td>";
                                echo "<td colspan='6'>" . "There are no patients waiting to be visited!" . "</td>";
                            }
                            $cnt = 1;
                            while ($row = \mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $patient_id = $row['id_patient'];
                                $query3 = "Select * from patient where id='" . $patient_id . "'";
                                $result3 = \mysqli_query($con->connect(), $query3);
                                $row2 = \mysqli_fetch_array($result3, MYSQLI_ASSOC);
                                echo "<tr>";
                                echo "<td>" . $cnt . "</td>";
                                echo "<td>" . $row2['name'] . "</td>";
                                echo "<td>" . $row2['father_name'] . "</td>";
                                echo "<td>" . $row2['surname'] . "</td>";
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
                                <td>
                                    <form style="margin: 0; padding: 0;" action="docCreateVisit.php" method="post">
                                        <button style="display: inline;color: #2f88fd;" name="details" type="submit"
                                                value="<?= $row2['id'] ?>">Create Visit
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
    </div>
</div>
<!--===============================================================================================-->
<script src="vendorForm/jquery/jquery-3.2.1.min.js"></script>
<script src="vendorForm/tilt/tilt.jquery.min.js"></script>


<!-- ***** <!-- ***** Personal information Area end ***** -->

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
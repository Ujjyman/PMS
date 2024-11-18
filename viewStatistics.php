<?php
session_start();
require 'crud_class.php';

use core\database;

require_once "database_class.php";

$crud = new \core\user\crud();
$con = new database();
// Patients Age Statistic queries
$user = $crud->retrieve_doctor($_SESSION['id']);
$query = "Select * from patient where birthdate >='2010-01-01'";
$result = \mysqli_query($con->connect(), $query);
$row = \mysqli_fetch_array($result, MYSQLI_ASSOC);
$numRows = \mysqli_num_rows($result);

$query2 = "Select * from patient where birthdate >='2000-01-01' AND birthdate<='2010-01-01'";
$result2 = \mysqli_query($con->connect(), $query2);
$row2 = \mysqli_fetch_array($result2, MYSQLI_ASSOC);
$numRows2 = \mysqli_num_rows($result2);

$query3 = "Select * from patient where birthdate<'2000-01-01'";
$result3 = \mysqli_query($con->connect(), $query3);
$row3 = \mysqli_fetch_array($result3, MYSQLI_ASSOC);
$numRows3 = \mysqli_num_rows($result3);
// Patients Age Statistic queries end

// Doctor Gender Statistic queries
$query4 = "Select * from doctor where gender='F'";
$result4 = \mysqli_query($con->connect(), $query4);
$row4 = \mysqli_fetch_array($result4, MYSQLI_ASSOC);
$numRows4 = \mysqli_num_rows($result4);

$query5 = "Select * from doctor where gender='M'";
$result5 = \mysqli_query($con->connect(), $query5);
$row5 = \mysqli_fetch_array($result5, MYSQLI_ASSOC);
$numRows5 = \mysqli_num_rows($result5);
// Doctor Gender Statistic end

// Patient Gender Statistic queries
$query6 = "Select * from patient where gender='F'";
$result6 = \mysqli_query($con->connect(), $query6);
$row6 = \mysqli_fetch_array($result6, MYSQLI_ASSOC);
$numRows6 = \mysqli_num_rows($result6);

$query7 = "Select * from patient where gender='M'";
$result7 = \mysqli_query($con->connect(), $query7);
$row7 = \mysqli_fetch_array($result7, MYSQLI_ASSOC);
$numRows7 = \mysqli_num_rows($result7);
// Patient Gender Statistic

// Doctors Age Statistic queries
$query8 = "Select * from doctor where birthdate >='1998-01-01'";
$result8 = \mysqli_query($con->connect(), $query8);
$numRows8 = \mysqli_num_rows($result8);

$query9 = "Select * from doctor where birthdate <='1978-01-01' AND birthdate<='1998-01-01'";
$result9 = \mysqli_query($con->connect(), $query9);
$numRows9 = \mysqli_num_rows($result9);

$query12 = "Select * from doctor where birthdate<'1978-01-01'";
$result12 = \mysqli_query($con->connect(), $query12);
$numRows12 = \mysqli_num_rows($result12);
// Doctors Age Statistic queries end

/*
$date= date('Y-m-d');
$query8 ="Select * from medical_record where date_created='".$date."'";
$result8 = \mysqli_query($con->connect(),$query8);
$row8 = \mysqli_fetch_array($result8, MYSQLI_ASSOC);
$numRows8 = \mysqli_num_rows($result8);
$query9 ="Select * from medical_record where date_created<'".$date."'";
$result9 = \mysqli_query($con->connect(),$query9);
$row9 = \mysqli_fetch_array($result9, MYSQLI_ASSOC);
$numRows9 = \mysqli_num_rows($result9);
*/

// Monthly visits query
$query10 = "SELECT count(*) AS visits, YEAR(date_created) year,MONTH(date_created) month FROM medical_visit GROUP BY YEAR(date_created),MONTH(date_created)";
$result10 = \mysqli_query($con->connect(), $query10);
$numRows10 = \mysqli_num_rows($result10);
// Monthly visits query end

// New patients by month query
$query11 = "SELECT count(*) AS patients, YEAR(date_created) year,MONTH(date_created) month FROM medical_record GROUP BY YEAR(date_created),MONTH(date_created)";
$result11 = \mysqli_query($con->connect(), $query11);
$numRows11 = \mysqli_num_rows($result11);
// New patients by month query end

// Feedback Statistic query
$query12 = "SELECT rate AS rate, COUNT(*) AS feedback FROM feedback GROUP BY rate";
$result12 = \mysqli_query($con->connect(), $query12);
$numRows12 = \mysqli_num_rows($result12);
// Feedback Statistic query end
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Medilife - Health &amp; Medical Template | Elements</title>

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
            <div class="card-body" style="color: #2f88fd; text-align: center;">
                <h5 class="card-title">Statistics</h5>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div id="piechart3"></div>
                </div>
                <div class="col-sm-6">
                    <div style=" margin-left:-5%;">
                        <div id="piechart2"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div>
                        <div id="piechart"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div style=" margin-left:-5%;">
                        <div id="piechart4"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div style=" margin-left:-30%;">
                        <div id="piechart5"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div style=" margin-left:-10%;">
                        <div id="piechart6"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div style=" margin-left:-10%;">
                        <div id="piechart7"></div>
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    // Load google charts

    // Patient Age Statistic
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    // Draw the chart and set the chart values
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['From 1-8', <?php echo $numRows; ?>],
            ['From 8-18', <?php echo $numRows2; ?>],
            ['Greater than 18', <?php echo $numRows3; ?>]

        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title': 'Patient Age Statistic', 'width': 550, 'height': 400};

        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }

    // Doctors Gender
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart2);

    // Draw the chart and set the chart values
    function drawChart2() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Female', <?php echo $numRows4; ?>],
            ['Male', <?php echo $numRows5; ?>]

        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title': 'Doctors\' Gender ', 'width': 550, 'height': 400};

        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
        chart.draw(data, options);
    }


    // Patients Gender
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart3);

    // Draw the chart and set the chart values
    function drawChart3() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Female', <?php echo $numRows6; ?>],
            ['Male', <?php echo $numRows7; ?>]

        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title': 'Patients\' Gender ', 'width': 550, 'height': 400};

        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('piechart3'));
        chart.draw(data, options);
    }


    // Doctors Age Statistic
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart4);

    // Draw the chart and set the chart values
    function drawChart4() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Less than 20', <?php echo $numRows8; ?>],
            ['From 20-40', <?php echo $numRows9; ?>],
            ['Greater than 40', <?php echo $numRows12; ?>]

        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title': 'Doctor Age Statistic', 'width': 550, 'height': 400};

        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('piechart4'));
        chart.draw(data, options);
    }

    // Monthly visits
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart5);

    function drawChart5() {
        // Some raw data (not necessarily accurate)

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Month');
        data.addColumn('number', 'Visits');

        <?php
        while($row10 = \mysqli_fetch_array($result10, MYSQLI_ASSOC)){
        $m = $row10['month'] . " / " . $row10['year'];
        $v = $row10['visits'];
        ?>
        data.addRow(['<?= $m ?> ', <?= $v ?> ]);
        <?php
        }
        ?>
        var options = {
            title: 'Monthly Visits', 'width': 550, 'height': 400
        };

        var chart = new google.visualization.BarChart(document.getElementById('piechart5'));
        chart.draw(data, options);
    }


    // New Patients by Month
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart6);

    function drawChart6() {
        // Some raw data (not necessarily accurate)

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Month');
        data.addColumn('number', 'Patients');

        <?php
        while($row11 = \mysqli_fetch_array($result11, MYSQLI_ASSOC)){
        $m = $row11['month'] . " / " . $row11['year'];
        $p = $row11['patients'];
        ?>
        data.addRow(['<?= $m ?> ', <?= $p ?> ]);
        <?php
        }
        ?>
        var options = {
            title: 'New Patients by Month', 'width': 550, 'height': 400
        };

        var chart = new google.visualization.BarChart(document.getElementById('piechart6'));
        chart.draw(data, options);
    }


    // Feedback Statistic
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart7);

    function drawChart7() {
        // Some raw data (not necessarily accurate)

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Rate');
        data.addColumn('number', 'Feedback');

        <?php
        while($row12 = \mysqli_fetch_array($result12, MYSQLI_ASSOC)){
        $v = $row12['rate'];
        if ($v == 1) $rate = "Strongly Dissapointed";
        if ($v == 2) $rate = "Dissapointed";
        if ($v == 3) $rate = "Neutral";
        if ($v == 4) $rate = "Sattisfied";
        if ($v == 5) $rate = "Strongly Sattisfied";
        $f = $row12['feedback'];
        ?>
        data.addRow(['<?= $rate ?> ', <?= $f ?> ]);
        <?php
        }
        ?>
        var options = {
            title: 'Feedback Statistics', 'width': 1000, 'height': 400
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart7'));
        chart.draw(data, options);
    }

</script>
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
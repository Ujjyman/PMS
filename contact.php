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
                            <a class="navbar-brand" href="index.php"><img src="img/core-img/logo.png" alt="Logo"></a>

                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#medilifeMenu" aria-controls="medilifeMenu" aria-expanded="false"
                                    aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

                            <div class="collapse navbar-collapse" id="medilifeMenu">
                                <!-- Menu Area -->
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="contact.php">Contact</a>
                                    </li>
                                </ul>
                                <!-- Appointment Button -->
                                <a href="login.php" class="btn medilife-appoint-btn ml-30"> <span>To Login</span> Click
                                    here</a>
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

<section class="medilife-contact-area section-padding-100">
    <div class="container">
        <div class="row">

            <div class="medilife-contact-card mb-50" style="margin-left:5%">

                <div class="single-contact d-flex align-items-center">
                    <div class="contact-icon mr-30">
                        <i class="icon-doctor"></i>
                    </div>
                    <div class="contact-meta">
                        <p><strong> Address:</strong> Islam Alla street, 50m from street entrance.</p>
                    </div>
                </div>

                <div class="single-contact d-flex align-items-center">
                    <div class="contact-icon mr-30">
                        <i class="icon-doctor"></i>
                    </div>
                    <div class="contact-meta">
                        <p><strong> Tel:</strong> 04 225 8174</p>
                    </div>
                </div>

                <div class="single-contact d-flex align-items-center">
                    <div class="contact-icon mr-30">
                        <i class="icon-doctor"></i>
                    </div>
                    <div class="contact-meta">
                        <p><strong> Email:</strong> medicalcentertest18@gmail.com</p>
                    </div>
                </div>


                <div class="contact-social-area">
                    <a href="http://www.shendetesia.gov.al" target="_blank"><i class="fa fa-bank"></i> Ministria e
                        shendetsise</a>
                </div>

            </div>


            <!-- medilife Emergency Card -->
            <div class="medilife-emergency-card bg-img bg-overlay"
                 style="background-image: url(img/bg-img/about1.jpg);margin-left:10%; margin-top:-7%; width:400px">
                <i class="icon-smartphone"></i>
                <h2>For Emergency calls</h2>
                <h3>112</h3>
            </div>
        </div>
    </div>
    </div>
    </div>
</section>

<!-- Google Maps -->
<div class="map-area mb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div id="map" style="width:100%;height:500px;margin-top:-7% " class="googleMap"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function myMap() {
        var myCenter = new google.maps.LatLng(41.327243, 19.811531);
        var mapCanvas = document.getElementById("map");
        var mapOptions = {center: myCenter, zoom: 15};
        var map = new google.maps.Map(mapCanvas, mapOptions);
        var marker = new google.maps.Marker({position: myCenter});
        marker.setMap(map);
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
<!-- Google Maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_DANQcJgdfMf-ATIn9wfD77iMN6hM4Po&callback=myMap"></script>


</body>

</html>
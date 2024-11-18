<?php
require 'crud_class.php';
require 'validate_class.php';
session_start();
$action = new \core\user\crud();
$valid = new \core\logic\validate();

if (!isset($_SESSION['user']) == 'receptionist' or !isset($_SESSION['id']))
    header("Location: login.php");
$user = $action->retrieve_receptionist($_SESSION['id']);
if (isset($_POST['details'])) {

    $doc = $action->retrieve_doctor($_POST['details']);
}

if (isset($_POST['submit'])) {
    if (isset($_POST['name'])) {
        if (!$valid->checkName($_POST['name']))
            $n = "<p style='color:red'>Name should start with uppercase letter and must contain only letters!</p>";
    }
    if (isset($_POST['father_name'])) {
        if (!$valid->checkName($_POST['father_name']))
            $fn = "<p style='color:red'>Father Name should start with uppercase letter and must contain only letters!</p>";
    }
    if (isset($_POST['surname'])) {
        if (!$valid->checkName($_POST['surname']))
            $s = "<p style='color:red'>Surname should start with uppercase letter and must contain only letters!</p>";
    }
    if (isset($_POST['bd'])) {
        if (!$valid->checkDate($_POST['bd']))
            $bd = "<p style='color:red'>Date should be written as yyyy-mm-dd!</p>";
    }
    if (isset($_POST['pid'])) {
        if (!$valid->chech_personal_id($_POST['pid']))
            $pid = "<p style='color:red'>Please type the correct albanian personal number, 1 letter at the begging and 1 at the end, followed by 8 digits in between!</p>";
    }
    if (isset($_POST['phone'])) {
        if (!$valid->checkPhone($_POST['phone']))
            $ph = "<p style='color:red'>Phone format is incorrect! Phone should start with 06 followed by 8 other digits!</p>";
    }
    if (isset($_POST['bp'])) {
        if (!$valid->checkName($_POST['bp']))
            $b = "<p style='color:red'>Birthplace should start with uppercase letter and must contain only letters!</p>";
    }
    if (isset($_POST['ad'])) {
        if (!$valid->checkText($_POST['ad']))
            $ad = "<p style='color:red'>Only letters and spaces are allowed</p>";
    }
    if (isset($_POST['uni'])) {
        if (!$valid->checkText($_POST['uni']))
            $uni = "<p style='color:red'>Only letters and spaces are allowed</p>";
    }
    if (isset($_POST['spec'])) {
        if (!$valid->checkText($_POST['spec']))
            $spec = "<p style='color:red'>Only letters and spaces are allowed</p>";
    }
    if (isset($_POST['email'])) {
        if (!$valid->checkMail($_POST['email']))
            $e = "<p style='color:red'>Enter a valid format of mail!</p>";
    }
    if (isset($_POST['username'])) {
        if (!$valid->checkUser($_POST['username']))
            $u = "<p style='color:red'>Username must contain only letters, digits, \"_\" or \".\"!</p>";
    }
    if (!empty($_FILES["fileToUpload"]) && $_FILES['fileToUpload']['error'] == 0) {
// profile photo input
        $target_dir = "Images/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $photo = "<p style='color:red'>  Please Upload an Image.";
            $uploadOk = 0;
        }

// Check if file already exists
        if (file_exists($target_file)) {
            $photo = "<p style='color:red'> Sorry, the photo already exists. </p>";
            $uploadOk = 0;
        }
// Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $photo = "<p style='color:red'>  Sorry, the photo is too large. </p>";
            $uploadOk = 0;
        }
// Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $photo = "<p style='color:red'> Sorry, only JPG, JPEG, PNG & GIF files are allowed. </p>";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 1) {
            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $newfilename)) {
            } else {
                $photo = "<p style='color:red'> Sorry, there was an error uploading the photo. </p>";
            }
        }
    } else {
        $mypac = $action->retrieve_doctor($_POST['docid']);
        if (isset($mypac->photo)) $newfilename = $mypac->photo;
        else  $newfilename = "default.jpg";
    }

    if (!isset($n) && !isset($fn) && !isset($s) && !isset($bd) && !isset($pid) && !isset($ph) && !isset($ad) && !isset($uni) && !isset($b) && !isset($e) && !isset($u) && !isset($photo)) {

        $updatedOk = $action->update_doctor($_POST['docid'], $newfilename, $_POST['name'], $_POST['father_name'], $_POST['surname'], $_POST['pid'], $_POST['gender'], $_POST['phone'], $_POST['bd'], $_POST['bp'], $_POST['ad'], $_POST['uni'], $_POST['gd'], $_POST['spec'], $user->id, $_POST['email'], $_POST['username'], $_POST['director'], $user->name, $user->surname);
        if ($updatedOk) {
            $msg = "Doctor Updated Successfully!";
            echo "<script type='text/javascript'>alert(\"$msg\");</script>";
        } else {
            $msg = "Error while updating doctor!";
            echo "<script type='text/javascript'>alert(\"$msg\");</script>";
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
                <img src="imagesForm/img-08.png" alt="IMG">
            </div>

            <form class="contact100-form validate-form" method="post" enctype="multipart/form-data">
					<span class="contact100-form-title" style="color: #2f88fd">
					<strong>	Update Doctor
					</span>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Profile Photo</label>
                    <input class="input100" type="file" name="fileToUpload" id="fileToUpload">
                    <span class="focus-input100"></span>
                    <?= (isset($photo)) ? $photo : "" ?>
                </div>

                <input name='docid' type='hidden'
                       value="<?= (!isset($_POST['docid'])) ? ($doc->id) : $_POST['docid'] ?>">
                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">First name</label>
                    <input class="input100" type="text" name="name"
                           value="<?= (!isset($_POST['name'])) ? ($doc->name) : $_POST['name'] ?>" required
                           placeholder="First name">
                    <span class="focus-input100"></span>
                    <?= (isset($n)) ? $n : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Father's name</label>
                    <input class="input100" type="text" name="father_name"
                           value="<?= (!isset($_POST['father_name'])) ? ($doc->father_name) : $_POST['father_name'] ?>"
                           required placeholder="Father's name">
                    <span class="focus-input100"></span>
                    <?= (isset($fn)) ? $fn : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Last name</label>
                    <input class="input100" type="text" name="surname"
                           value="<?= (!isset($_POST['surname'])) ? ($doc->surname) : $_POST['surname'] ?>" required
                           placeholder="Last name">
                    <span class="focus-input100"></span>
                    <?= (isset($s)) ? $s : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Personal number</label>
                    <input class="input100" type="text" name="pid"
                           value="<?= (!isset($_POST['pid'])) ? ($doc->personal_id) : $_POST['pid'] ?>" required
                           placeholder="Personal no.">
                    <span class="focus-input100"></span>
                    <?= (isset($pid)) ? $pid : "" ?>
                </div>


                <div class="wrap-input100 validate-input" style="color: #2f88fd">
                    GENDER
                    <?php
                    if ((isset($_POST['gender']) && $_POST['gender'] == 'M') || (isset($doc) && $doc->gender == 'M')) {
                        ?>
                        <input type="radio" name="gender" value="M" checked>male
                        <input type="radio" name="gender" value="F">female
                        <?php
                    } else if ((isset($_POST['gender']) && $_POST['gender'] == 'F') || (isset($doc) && $doc->gender == 'F')) {
                        ?>
                        <input type="radio" name="gender" value="M">male
                        <input type="radio" name="gender" value="F" checked>female
                        <?php
                    }
                    ?>
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Phone number</label>
                    <input class="input100" type="text" name="phone"
                           value="<?= (!isset($_POST['phone'])) ? ($doc->phone) : $_POST['phone'] ?>" required
                           placeholder="Phone number">
                    <span class="focus-input100"></span>
                    <?= (isset($ph)) ? $ph : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Birthdate</label>
                    <input class="input100" type="date" name="bd"
                           value="<?= (!isset($_POST['bd'])) ? ($doc->birthdate) : $_POST['bd'] ?>" required
                           placeholder="Birthdate">
                    <span class="focus-input100"></span>
                    <?= (isset($bd)) ? $bd : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Birthplace</label>
                    <input class="input100" type="text" name="bp"
                           value="<?= (!isset($_POST['bp'])) ? ($doc->birthplace) : $_POST['bp'] ?>" required
                           placeholder="Birthplace">
                    <span class="focus-input100"></span>
                    <?= (isset($b)) ? $b : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Academic degree</label>
                    <input class="input100" type="text" name="ad"
                           value="<?= (!isset($_POST['ad'])) ? ($doc->academic_degree) : $_POST['ad'] ?>" required
                           placeholder="Academic Degree">
                    <span class="focus-input100"></span>
                    <?= (isset($ad)) ? $ad : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">University</label>
                    <input class="input100" type="text" name="uni"
                           value="<?= (!isset($_POST['uni'])) ? ($doc->university) : $_POST['uni'] ?>" required
                           placeholder="University">
                    <span class="focus-input100"></span>
                    <?= (isset($uni)) ? $uni : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Graduation date</label>
                    <input class="input100" type="date" name="gd"
                           value="<?= (!isset($_POST['gd'])) ? ($doc->graduation_date) : $_POST['gd'] ?>" required
                           placeholder="Graduation date">
                    <span class="focus-input100"></span>
                    <?= (isset($bd)) ? $bd : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Speciality</label>
                    <input class="input100" type="text" name="spec"
                           value="<?= (!isset($_POST['spec'])) ? ($doc->speciality) : $_POST['spec'] ?>" required
                           placeholder="Speciality">
                    <span class="focus-input100"></span>
                    <?= (isset($spec)) ? $spec : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Email</label>
                    <input class="input100" type="text" name="email"
                           value="<?= (!isset($_POST['email'])) ? ($doc->email) : $_POST['email'] ?>" required
                           placeholder="Email">
                    <span class="focus-input100"></span>
                    <?= (isset($e)) ? $e : "" ?>
                </div>

                <div class="wrap-input100 validate-input" style="color: #2f88fd">
                    Director
                    <?php
                    if ((isset($_POST['director']) && $_POST['director'] == '1') || (isset($doc) && $doc->is_director == '1')) {
                        ?>
                        <input type="radio" name="director" value="1" checked>Yes
                        <input type="radio" name="director" value="0">No
                        <?php
                    } else if ((isset($_POST['director']) && $_POST['director'] == '0') || (isset($doc) && $doc->is_director == '0')) {
                        ?>
                        <input type="radio" name="director" value="1">Yes
                        <input type="radio" name="director" value="0" checked>No
                        <?php
                    }
                    ?>
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Username</label>
                    <input class="input100" type="text" name="username"
                           value="<?= (!isset($_POST['username'])) ? ($doc->username) : $_POST['username'] ?>" required
                           placeholder="Username">
                    <span class="focus-input100"></span>
                    <?= (isset($u)) ? $u : "" ?>
                </div>


                <div class="container-contact100-form-btn">
                    <input class="contact100-form-btn" type="submit" name="submit"
                           onclick="return confirm('Are you sure you want to update this profile?')"
                           value="Update doctor">

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
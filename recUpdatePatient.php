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
    $pac = $action->retrieve_patient($_POST['details']);
    $med = $action->retrieve_medical_record($pac->id);
    $_POST['medid'] = $med->id;
    $_POST['gender'] = $pac->gender;
    $_POST['bt'] = $med->blood_type;
    $_POST['rh'] = $med->rh_factor;

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
    if (isset($_POST['prof'])) {
        if (!$valid->checkName($_POST['prof']))
            $prof = "<p style='color:red'>Proffession should start with uppercase letter and must contain only letters!</p>";
    }
    if (isset($_POST['job'])) {
        if (!$valid->checkName($_POST['job']))
            $j = "<p style='color:red'>Job should start with uppercase letter and must contain only letters!</p>";
    }
    if (isset($_POST['g'])) {
        if (!$valid->checkGuardian($_POST['g']))
            $g = "<p style='color:red'>Guardian Name Surname should have the following format: \" Name Surname\" and must contain only letters! or you should type 'none'</p>";
    }
    if (isset($_POST['bp'])) {
        if (!$valid->checkName($_POST['bp']))
            $b = "<p style='color:red'>Birthplace should start with uppercase letter and must contain only letters!</p>";
    }
    if (isset($_POST['email'])) {
        if (!$valid->checkMail($_POST['email']))
            $e = "<p style='color:red'>Enter a valid format of mail!</p>";
    }
    if (isset($_POST['username'])) {
        if (!$valid->checkUser($_POST['username']))
            $u = "<p style='color:red'>Username must contain only letters, digits, \"_\" or \".\"!</p>";
    }
    if (isset($_POST['inr'])) {
        if (!$valid->check_insurance($_POST['inr']))
            $inr = "<p style='color:red'>Insurance number contains only numbers!</p>";
    }
    if (isset($_POST['pn'])) {
        if (!$valid->check_insurance($_POST['pn']))
            $pn = "<p style='color:red'>Polyclinich number contains only numbers!</p>";
    }
    if (isset($_POST['all'])) {
        if (!$valid->checkMsg($_POST['all']))
            $all = "<p style='color:red'> Only letters and spaces are allowed  </p>";
    }
    if (isset($_POST['anam'])) {
        if (!$valid->checkMsg($_POST['anam']))
            $anam = "<p style='color:red'> Only letters and spaces are allowed  </p>";
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
        $mypac = $action->retrieve_patient($_POST['pacid']);
        if (isset($mypac->photo)) $newfilename = $mypac->photo;
        else  $newfilename = "default.jpg";
    }

    if (!isset($n) && !isset($fn) && !isset($s) && !isset($bd) && !isset($pid) && !isset($ph) && !isset($prof) && !isset($j) && !isset($g) && !isset($b) && !isset($e) && !isset($u) && !isset($inr) && !isset($pn) && !isset($all) && !isset($anam) && !isset($photo)) {

        $insertedOk = $action->update_medical_record($_POST['medid'], $newfilename, $_POST['name'], $_POST['father_name'], $_POST['surname'], $_POST['pid'], $_POST['gender'], $_POST['phone'], $_POST['address'], $_POST['prof'], $_POST['job'], $_POST['g'], $_POST['bd'], $_POST['bp'], $_POST['email'], $_POST['username'], $_POST['inr'], $_POST['pn'], $_POST['dc'], $user->id, $_POST['doctor'], $_POST['pacid'], $_POST['bt'], $_POST['rh'], $_POST['all'], $_POST['anam']);
    } else {
        echo "One of the fields has ERROR";
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
					<strong>	Update Patient
					</span>
                <input name='pacid' type='hidden'
                       value="<?= (!isset($_POST['pacid'])) ? ($pac->id) : $_POST['pacid'] ?>">
                <input name='medid' type='hidden'
                       value="<?= (!isset($_POST['medid'])) ? ($med->id) : $_POST['medid'] ?>">

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Profile Photo</label>
                    <input class="input100" type="file" name="fileToUpload" id="fileToUpload">
                    <span class="focus-input100"></span>
                    <?= (isset($photo)) ? $photo : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">First name</label>
                    <input class="input100" type="text" name="name"
                           value="<?= (!isset($_POST['name'])) ? ($pac->name) : $_POST['name'] ?>" required
                           placeholder="First name">
                    <span class="focus-input100"></span>
                    <?= (isset($n)) ? $n : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Father's name</label>
                    <input class="input100" type="text" name="father_name"
                           value="<?= (!isset($_POST['father_name'])) ? ($pac->father_name) : $_POST['father_name'] ?>"
                           required placeholder="Father's name">
                    <span class="focus-input100"></span>
                    <?= (isset($fn)) ? $fn : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Last name</label>
                    <input class="input100" type="text" name="surname"
                           value="<?= (!isset($_POST['surname'])) ? ($pac->surname) : $_POST['surname'] ?>" required
                           placeholder="Last name">
                    <span class="focus-input100"></span>
                    <?= (isset($s)) ? $s : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Personal number</label>
                    <input class="input100" type="text" name="pid"
                           value="<?= (!isset($_POST['pid'])) ? ($pac->personal_id) : $_POST['pid'] ?>" required
                           placeholder="Personal no.">
                    <span class="focus-input100"></span>
                    <?= (isset($pid)) ? $pid : "" ?>
                </div>

                <div class="wrap-input100 validate-input" style="color: #2f88fd">
                    GENDER
                    <?php
                    if ((isset($_POST['gender']) && $_POST['gender'] == 'M') || (isset($pac) && $pac->gender == 'M')) {
                        ?>
                        <input type="radio" name="gender" value="M" checked>male
                        <input type="radio" name="gender" value="F">female
                        <?php
                    } else if ((isset($_POST['gender']) && $_POST['gender'] == 'F') || (isset($pac) && $pac->gender == 'F')) {
                        ?>
                        <input type="radio" name="gender" value="M">male
                        <input type="radio" name="gender" value="F" checked>female
                        <?php
                    }

                    ?>
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Birthdate</label>
                    <input class="input100" type="date" data-date-format="Y-m-d" name="bd"
                           value="<?= (!isset($_POST['bd'])) ? ($pac->birthdate) : $_POST['bd'] ?>" required
                           placeholder="Birthdate">
                    <span class="focus-input100"></span>
                    <?= (isset($bd)) ? $bd : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Birthplace</label>
                    <input class="input100" type="text" name="bp"
                           value="<?= (!isset($_POST['bp'])) ? ($pac->birthplace) : $_POST['bp'] ?>" required
                           placeholder="Birthplace">
                    <span class="focus-input100"></span>
                    <?= (isset($b)) ? $b : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Phone number</label>
                    <input class="input100" type="text" name="phone"
                           value="<?= (!isset($_POST['phone'])) ? ($pac->phone) : $_POST['phone'] ?>" required
                           placeholder="Phone number">
                    <span class="focus-input100"></span>
                    <?= (isset($ph)) ? $ph : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Address</label>
                    <input class="input100" type="text" name="address"
                           value="<?= (!isset($_POST['address'])) ? ($pac->address) : $_POST['address'] ?>" required
                           placeholder="Address">
                    <span class="focus-input100"></span>
                    <?= (isset($ad)) ? $ad : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Profession</label>
                    <input class="input100" type="text" name="prof"
                           value="<?= (!isset($_POST['prof'])) ? ($pac->profession) : $_POST['prof'] ?>" required
                           placeholder="Profession">
                    <span class="focus-input100"></span>
                    <?= (isset($prof)) ? $prof : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Job</label>
                    <input class="input100" type="text" name="job"
                           value="<?= (!isset($_POST['job'])) ? ($pac->job) : $_POST['job'] ?>" required
                           placeholder="Job">
                    <span class="focus-input100"></span>
                    <?= (isset($j)) ? $j : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Guardian</label>
                    <input class="input100" type="text" name="g"
                           value="<?= (!isset($_POST['g'])) ? ($pac->guardian) : $_POST['g'] ?>"
                           placeholder="Guardian's name and surname">
                    <span class="focus-input100"></span>
                    <?= (isset($g)) ? $g : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Email</label>
                    <input class="input100" type="text" name="email"
                           value="<?= (!isset($_POST['email'])) ? ($pac->email) : $_POST['email'] ?>" required
                           placeholder="Email">
                    <span class="focus-input100"></span>
                    <?= (isset($e)) ? $e : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Username</label>
                    <input class="input100" type="text" name="username"
                           value="<?= (!isset($_POST['username'])) ? ($pac->username) : $_POST['username'] ?>" required
                           placeholder="Username">
                    <span class="focus-input100"></span>
                    <?= (isset($u)) ? $u : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Health insurance</label>
                    <input class="input100" type="text" name="inr"
                           value="<?= (!isset($_POST['inr'])) ? ($med->health_insurance_nr) : $_POST['inr'] ?>" required
                           placeholder="Health Insurance Number">
                    <span class="focus-input100"></span>
                    <?= (isset($inr)) ? $inr : "" ?>
                </div>
                <input type="hidden" name="pn" value="5" readonly>
                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Date created</label>
                    <input class="input100" type="date" data-date-format="Y-mm-dd"
                           value="<?= (!isset($_POST['dc'])) ? ($med->date_created) : $_POST['dc'] ?>" name="dc"
                           readonly>
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input" style="color: #2f88fd">
                    BLOOD TYPE :
                    <?php
                    if ((isset($_POST['bt']) && $_POST['bt'] == 'A') || (isset($med) && $med->blood_type == 'A')) {
                        ?>
                        <input type="radio" name="bt" value="A" checked>A
                        <input type="radio" name="bt" value="B">B
                        <input type="radio" name="bt" value="AB">AB
                        <input type="radio" name="bt" value="O">O
                        <?php
                    } else if ((isset($_POST['bt']) && $_POST['bt'] == 'B') || (isset($med) && $med->blood_type == 'B')) {
                        ?>
                        <input type="radio" name="bt" value="A">A
                        <input type="radio" name="bt" value="B" checked>B
                        <input type="radio" name="bt" value="AB">AB
                        <input type="radio" name="bt" value="O">O
                        <?php
                    } else if ((isset($_POST['bt']) && $_POST['bt'] == 'AB') || (isset($med) && $med->blood_type == 'AB')) {
                        ?>
                        <input type="radio" name="bt" value="A">A
                        <input type="radio" name="bt" value="B">B
                        <input type="radio" name="bt" value="AB" checked>AB
                        <input type="radio" name="bt" value="O">O
                        <?php
                    } else if ((isset($_POST['bt']) && $_POST['bt'] == 'O') || (isset($med) && $med->blood_type == 'O')) {
                        ?>
                        <input type="radio" name="bt" value="A">A
                        <input type="radio" name="bt" value="B">B
                        <input type="radio" name="bt" value="AB">AB
                        <input type="radio" name="bt" value="O" checked>O
                        <?php
                    } else {
                        ?>
                        <input type="radio" name="bt" value="A" required>A
                        <input type="radio" name="bt" value="B" required>B
                        <input type="radio" name="bt" value="AB" required>AB
                        <input type="radio" name="bt" value="O" required>O
                        <?php
                    }
                    ?>
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input" style="color: #2f88fd">
                    RHESUS :
                    <?php
                    if ((isset($_POST['rh']) && $_POST['rh'] == 'Rh+') || (isset($med) && $med->rh_factor == 'Rh+')) {
                        ?>
                        <input type="radio" name="rh" value="Rh+" checked>+
                        <input type="radio" name="rh" value="Rh-">-
                        <?php
                    } else if ((isset($_POST['rh']) && $_POST['rh'] == 'Rh-') || (isset($med) && $med->rh_factor == 'Rh-')) {
                        ?>
                        <input type="radio" name="rh" value="Rh+">+
                        <input type="radio" name="rh" value="Rh-" checked>-
                        <td></td>
                        <?php
                    } else {
                        ?>
                        <input type="radio" name="rh" value="Rh+">+
                        <input type="radio" name="rh" value="Rh-" checked>-
                        <?php
                    }
                    ?>
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Allergies</label>
                    <textarea class="input100" type="text" name="all"
                              placeholder="Allergies"><?= (!isset($_POST['all'])) ? ($med->allergies) : $_POST['all'] ?></textarea>
                    <span class="focus-input100"></span>
                    <?= (isset($all)) ? $all : "" ?>
                </div>

                <div class="wrap-input100 validate-input">
                    <label style="color: #2f88fd; text-align:center">Anamnesis</label>
                    <textarea class="input100" type="text" name="anam"
                              placeholder="Anamnesis"><?= (!isset($_POST['anam'])) ? ($med->anamnesis) : $_POST['anam'] ?></textarea>
                    <span class="focus-input100"></span>
                    <?= (isset($anam)) ? $anam : "" ?>
                </div>

                <div class="wrap-input100 validate-input" style="color: #2f88fd">
                    <label style="color: #2f88fd; text-align:center">Family Doctor</label><br>
                    <select name="doctor" class="form-control selcls" required>
                        <option value="" selected disabled> Select Doctor</option>
                        <?php
                        $con = new \core\database();
                        if (isset($_POST['pacid'])) $pac_id = $_POST['pacid'];
                        else if (isset($pac->id)) $pac_id = $pac->id;

                        $query = "Select * from doctor";
                        $result = \mysqli_query($con->connect(), $query);
                        if (!$result) {
                            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't retrieve doctors!\");</script>";
                            exit();
                        }
                        $med = $action->retrieve_medical_record($pac_id);
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            if ($row['id'] != $med->id_doctor) {
                                ?>
                                <option value="<?= $row["id"]; ?>"> <?= $row["name"] . " " . $row["surname"]; ?></option>
                                <?php
                            } else {
                                ?>
                                <option value="<?= $row["id"]; ?>"
                                        selected> <?= $row["name"] . " " . $row["surname"]; ?></option>
                                <?php
                            }
                        }
                        ?>

                    </select>
                    <span class="focus-input100"></span>
                    <?= (isset($dn)) ? $dn : "" ?>
                </div>

                <div class="container-contact100-form-btn">
                    <input class="contact100-form-btn" type="submit" name="submit"
                           onclick="return confirm('Are you sure you want to update this profile?')"
                           value="Update patient">

                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .selcls {
        padding: 9px;
        border: solid 1px #2f88fd;
        outline: 0;
        background: white;

    }

    .selcls:focus {
        height: 100px;
        overflow-y: scroll;
    }

</style>
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
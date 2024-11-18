<?php
require 'crud_class.php';
require 'validate_class.php';
require_once 'database_class.php';
session_start();
$con = new \core\database();
$action = new \core\user\crud();
$valid = new \core\logic\validate();

if (!isset($_SESSION['user']) == 'receptionist' or !isset($_SESSION['id']))
    header("Location: login.php");

if (!isset($_POST['details']))
    header("Location: recPacList.php");

$query1 = "Select id_doctor FROM  `medical_record`  WHERE `medical_record`.`id_patient` ='" . $_POST['details'] . "'";
$result1 = \mysqli_query($con->connect(), $query1);
$row = \mysqli_fetch_array($result1, MYSQLI_ASSOC);
if ($row['id_doctor'] == NULL) {
    echo "<script>
alert('Please assign doctor first');
window.location.href='recPacList.php';
</script>";
} else {
    $query = "UPDATE `medical_record` SET `in_waiting` = '1' WHERE `medical_record`.`id_patient` ='" . $_POST['details'] . "'";
    $result = \mysqli_query($con->connect(), $query);
    if ($result) {
        echo "<script>
alert('Visit allowed successfully');
window.location.href='recPacList.php';
</script>";
    }
}





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

$med = $action->retrieve_medical_record($_POST['details']);
$action->delete_medical_record($med->id);
header("Location: recPacList.php");

if (isset($_POST['details'])) {
    $action->delete_patient($_POST['details']);
    if ($action) {
        header('Location: recPacList.php');
    }
}
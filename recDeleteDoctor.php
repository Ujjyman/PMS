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

if (isset($_POST['details'])) {
    $action->delete_doctor($_POST['details']);
    if ($action) {
        header('Location: recDocList.php');
    }
}



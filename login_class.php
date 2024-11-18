<?php

namespace core\logic;
require 'validate_class.php';
require 'database_class.php';

class login_class
{
    function login_receptionist($username, $password)
    {
        $db = new \core\database();
        $query = "Select * from receptionist where username='" . $username . "'";
        $result = \mysqli_query($db->connect(), $query);
        if (!$result) {
            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't log_in!\");</script>";
            exit();
        } else {
            $numRows = \mysqli_num_rows($result);
            $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($numRows == 1) {
                if (password_verify($password, $row['password'])) {
                    session_start();
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['user'] = "receptionist";
                    header("Location: recHome.php");
                } else {
                    echo "<script type='text/javascript'>alert(\"Wrong username or password!\");</script>";
                }
            } else {
                echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't log_in!\");</script>";
            }
        }
    }

    function login_doctor($username, $password)
    {
        $db = new \core\database();
        $query = "Select * from doctor where username='" . $username . "'";
        $result = \mysqli_query($db->connect(), $query);
        if (!$result) {
            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't log_in!\");</script>";
            exit();
        } else {
            $numRows = \mysqli_num_rows($result);
            $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($numRows == 1) {
                if (password_verify($password, $row['password'])) {
                    session_start();
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['user'] = "doctor";
                    header("Location: docHome.php");
                } else {
                    echo "<script type='text/javascript'>alert(\"Wrong username or password!\");</script>";
                }
            } else {
                echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't log_in!\");</script>";
            }
        }
    }

    function login_patient($username, $password)
    {
        $db = new \core\database();
        $query = "Select * from patient where username='" . $username . "'";
        $result = \mysqli_query($db->connect(), $query);
        if (!$result) {
            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't log_in!\");</script>";
            exit();
        } else {
            $numRows = \mysqli_num_rows($result);
            $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($numRows == 1) {
                if (password_verify($password, $row['password'])) {
                    session_start();
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['user'] = "patient";
                    header("Location: pacHome.php");
                } else {
                    echo "<script type='text/javascript'>alert(\"Wrong username or password!\");</script>";
                }
            } else {
                echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't log_in!\");</script>";
            }
        }
    }
}
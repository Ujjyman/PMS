<?php

namespace core\logic;

class validate
{
    function checkName($str)
    {
        return preg_match('/^[A-Z]{1}[a-zA-Z ]+$/', $str);
        // return preg_match('/(^[A-Z]{1}[a-zA-Z]{1,}$)|(^[A-Z]{1}[a-zA-Z]{1,}[ X][a-zA-Z]{1,}$)/',$str); // matches a single word starting with uppercase letter
    }

    function checkGuardian($str)
    {
        return preg_match('/^[A-Z]{1}[a-zA-Z]{1,}+[ X]+[A-Z]{1}[a-zA-Z]{1,}$|none/', $str); // matches two sentence case strings separated with space: Name Surname
    }

    function checkUser($str)
    {
        return preg_match('/^[a-zA-Z0-9-_.]+$/', $str); // matches username containing only lowercase letters, uppercase letters, numbers , underline and dot.
    }

    function chech_personal_id($str)
    {
        return preg_match('/^[A-Z]{1}[0-9]{8}+[A-Z]{1}$/', $str); // matches 1 Uppercase letter 8 numbers and another Uppercase letter
    }

    function check_insurance($str)
    {
        return preg_match('/^[0-9]+$/', $str); // matches 1 Uppercase letter 8 numbers and another Uppercase letter
    }

    function checkPass($str)
    {
        return preg_match("/\w{8,16}/", $str)
            && preg_match("/\w*\d\w*/", $str)
            && preg_match("/\w*[A-Z]w*/", $str)
            && preg_match("/\w*[a-z]w*/", $str);
    }

    function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1;
        $n = rand(0, strlen($uppercase) - 1);
        $pass[0] = $uppercase[$n];
        $n = rand(0, strlen($lowercase) - 1);
        $pass[1] = $lowercase[$n];
        $n = rand(0, strlen($numbers) - 1);
        $pass[2] = $numbers[$n];

        for ($i = 3; $i < 10; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    function checkMail($str)
    {
        return filter_var($str, FILTER_VALIDATE_EMAIL);
    }

    function checkPhone($str)
    {
        return preg_match("/^(06)\d{8}$/", $str);
    }

    function checkText($str)
    {
        return preg_match("/^[ xa-zA-Z]+$/", $str);
    }

    function checkMsg($str)
    {
        return preg_match("/^[a-zA-Z0-9 .,;:\/\-_]{1,}$/", $str);
    }

    function checkDate($str)
    {
        return preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])+$/", $str);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Ariola
 * Date: 20-May-18
 * Time: 10:18
 */

namespace core\user;


class receptionist
{
    public $id;
    public $photo;
    public $name;
    public $surname;
    public $father_name;
    public $personal_id;
    public $gender;
    public $birthdate;
    public $birthplace;
    public $academic_degree;
    public $university;
    public $graduation_date;
    public $email;
    public $username;
    public $password;


    function __construct($id, $photo, $name, $fn, $surname, $pid, $gender, $bd, $bp, $email, $username, $password, $academic_degree, $university, $grad_date)
    {
        $this->id = $id;
        $this->photo = $photo;
        $this->name = $name;
        $this->father_name = $fn;
        $this->surname = $surname;
        $this->personal_id = $pid;
        $this->gender = $gender;
        $this->birthdate = $bd;
        $this->birtplace = $bp;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->academic_degree = $academic_degree;
        $this->university = $university;
        $this->graduation_date = $grad_date;
    }


}
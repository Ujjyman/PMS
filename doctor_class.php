<?php

namespace core\user;

class doctor
{
    public $id;
    public $photo;
    public $name;
    public $father_name;
    public $surname;
    public $personal_id;
    public $gender;
    public $phone;
    public $birthdate;
    public $birthplace;
    public $academic_degree;
    public $university;
    public $graduation_date;
    public $speciality;
    public $created_by;
    public $email;
    public $username;
    public $password;
    public $is_director;
    public $receptionist_name;
    public $receptionist_surname;

    function __construct($id, $photo, $name, $fn, $surname, $pid, $gender, $phone, $bd,
                         $bp, $ad, $university, $gd, $speciality, $cb
        , $email, $username, $password, $isd, $rn, $rs)
    {
        $this->id = $id;
        $this->photo = $photo;
        $this->name = $name;
        $this->father_name = $fn;
        $this->surname = $surname;
        $this->personal_id = $pid;
        $this->gender = $gender;
        $this->phone = $phone;
        $this->birthdate = $bd;
        $this->birthplace = $bp;
        $this->academic_degree = $ad;
        $this->university = $university;
        $this->graduation_date = $gd;
        $this->speciality = $speciality;
        $this->created_by = $cb;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->is_director = $isd;
        $this->receptionist_name = $rn;
        $this->receptionist_surname = $rs;
    }
}
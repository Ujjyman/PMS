<?php

namespace core\user;

class patient
{
    public $id;
    public $photo;
    public $name;
    public $father_name;
    public $surname;
    public $personal_id;
    public $gender;
    public $phone;
    public $address;
    public $profession;
    public $job;
    public $guardian;
    public $birthdate;
    public $birthplace;
    public $email;
    public $username;
    public $password;

    function __construct($id, $photo, $name, $fn, $surname, $pid, $gender, $phone, $address, $profession, $job, $guardian, $bd, $bp, $email, $username, $password)
    {
        $this->id = $id;
        $this->photo = $photo;
        $this->name = $name;
        $this->father_name = $fn;
        $this->surname = $surname;
        $this->personal_id = $pid;
        $this->gender = $gender;
        $this->phone = $phone;
        $this->address = $address;
        $this->profession = $profession;
        $this->job = $job;
        $this->guardian = $guardian;
        $this->birthdate = $bd;
        $this->birthplace = $bp;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }
}
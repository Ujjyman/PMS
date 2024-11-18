<?php

namespace core\user;

class medical_record
{
    public $id;
    public $health_insurance_nr;
    public $polyclinic_nr;
    public $date_created;
    public $created_by;
    public $id_doctor;
    public $id_patient;
    public $blood_type;
    public $rh_factor;
    public $allergies;
    public $anamnesis;
    public $doctor_name;
    public $doctor_surname;
    public $receptionist_name;
    public $receptionist_surname;
    public $in_waiting;

    function __construct($id, $hinr, $pnr, $date_created, $created_by, $id_doctor, $id_patient, $blood_type, $rh_factor, $allergies, $anamnesis, $doctor_name, $doctor_surname, $receptionist_name, $receptionist_surname)
    {
        $this->id = $id;
        $this->health_insurance_nr = $hinr;
        $this->polyclinic_nr = $pnr;
        $this->date_created = $date_created;
        $this->created_by = $created_by;
        $this->id_doctor = $id_doctor;
        $this->id_patient = $id_patient;
        $this->blood_type = $blood_type;
        $this->rh_factor = $rh_factor;
        $this->allergies = $allergies;
        $this->anamnesis = $anamnesis;
        $this->doctor_name = $doctor_name;
        $this->doctor_surname = $doctor_surname;
        $this->receptionist_name = $receptionist_name;
        $this->receptionist_surname = $receptionist_surname;
        $this->in_waiting = 0;
    }
}
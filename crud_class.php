<?php

namespace core\user;

use core\database;
use core\user\medical_record;
use core\user\patient;
use core\user\feedback;
use core\user\doctor;

require "database_class.php";
require "patient_class.php";
require "receptionist_class.php";
require "feedback_class.php";
require "medical_record_class.php";
require "doctor_class.php";
error_reporting(E_ALL);
ini_set("display_errors", 1);

class crud
{

    public $con;

    function __construct()
    {
        $this->con = new database();
    }

    public function create_patient($photo, $name, $fn, $surname, $pid, $gender, $phone, $address, $profession, $job, $guardian, $bd, $bp, $email, $username, $password)
    {
        $photo = mysqli_real_escape_string($this->con->connect(), $photo);
        $name = mysqli_real_escape_string($this->con->connect(), $name);
        $fn = mysqli_real_escape_string($this->con->connect(), $fn);
        $surname = mysqli_real_escape_string($this->con->connect(), $surname);
        $pid = mysqli_real_escape_string($this->con->connect(), $pid);
        $gender = mysqli_real_escape_string($this->con->connect(), $gender);
        $phone = mysqli_real_escape_string($this->con->connect(), $phone);
        $address = mysqli_real_escape_string($this->con->connect(), $address);
        $profession = mysqli_real_escape_string($this->con->connect(), $profession);
        $job = mysqli_real_escape_string($this->con->connect(), $job);
        $guardian = mysqli_real_escape_string($this->con->connect(), $guardian);
        $bd = mysqli_real_escape_string($this->con->connect(), $bd);
        $bp = mysqli_real_escape_string($this->con->connect(), $bp);
        $email = mysqli_real_escape_string($this->con->connect(), $email);
        $username = mysqli_real_escape_string($this->con->connect(), $username);
        $password = mysqli_real_escape_string($this->con->connect(), $password);

        $query = "INSERT INTO `patient` ( `photo`, `name`, `father_name`, `surname`, `personal_id`, `gender`, `phone`, `address`, `profession`, `job`, `guardian`, `birthdate`, `birthplace`, `email`, `username`, `password`) VALUES ('$photo', '$name', '$fn', '$surname', '$pid', '$gender', '$phone', '$address', '$profession', '$job', '$guardian', '$bd', '$bp', '$email', '$username', '$password')";
        if (\mysqli_query($this->con->connect(), $query)) {
            return true;
        } else {
            echo "<script type='text/javascript'>alert(\"There was an error while adding a patient!\");</script>";
            return false;
        }
    }

    public function retrieve_patient($id)
    {
        $query = "Select * from patient where id='" . $id . "'";
        $result = \mysqli_query($this->con->connect(), $query);
        if (!$result) {
            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't retrieve patient!\");</script>";
            exit();
        }
        $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);
        $numRows = \mysqli_num_rows($result);
        if ($numRows == 1) {
            $patient = new patient($row['id'], $row['photo'], $row['name'], $row['father_name'], $row['surname'],
                $row['personal_id'], $row['gender'], $row['phone'], $row['address'], $row['profession'], $row['job'],
                $row['guardian'], $row['birthdate'], $row['birthplace'], $row['email'], $row['username'], $row['password']);
            return $patient;
        }
    }

    public function update_patient($id, $photo, $name, $fn, $surname, $pid, $gender, $phone, $address, $profession, $job, $guardian, $bd, $bp, $email, $username)
    {

        $photo = mysqli_real_escape_string($this->con->connect(), $photo);
        $name = mysqli_real_escape_string($this->con->connect(), $name);
        $fn = mysqli_real_escape_string($this->con->connect(), $fn);
        $surname = mysqli_real_escape_string($this->con->connect(), $surname);
        $pid = mysqli_real_escape_string($this->con->connect(), $pid);
        $gender = mysqli_real_escape_string($this->con->connect(), $gender);
        $phone = mysqli_real_escape_string($this->con->connect(), $phone);
        $address = mysqli_real_escape_string($this->con->connect(), $address);
        $profession = mysqli_real_escape_string($this->con->connect(), $profession);
        $job = mysqli_real_escape_string($this->con->connect(), $job);
        $guardian = mysqli_real_escape_string($this->con->connect(), $guardian);
        $bd = mysqli_real_escape_string($this->con->connect(), $bd);
        $bp = mysqli_real_escape_string($this->con->connect(), $bp);
        $email = mysqli_real_escape_string($this->con->connect(), $email);
        $username = mysqli_real_escape_string($this->con->connect(), $username);

        $query = "Update patient set photo='$photo', name='$name', father_name='$fn', surname='$surname', personal_id='$pid', 
                  gender='$gender', phone='$phone', address='$address', profession='$profession', job='$job', guardian='$guardian', 
                  birthdate='$bd', birthplace='$bp', email='$email', username='$username' where id='$id'";
        $result = \mysqli_query($this->con->connect(), $query);
        if (!$result) {
            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't update patient! \");</script>";
            return false;
        }
        return true;
    }

    public function changePass_patient($id, $pass)
    {
        $pass = mysqli_real_escape_string($this->con->connect(), $pass);
        $query = "Update patient set password='$pass' where id='$id'";
        $result = \mysqli_query($this->con->connect(), $query);
        if (!$result) {
            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't change password! \");</script>";
            return false;
            exit();
        }
        return true;
    }


    public function create_medical_record($photo, $name, $fn, $surname, $pid, $gender, $phone, $address, $profession, $job, $guardian, $bd, $bp, $email, $username, $password,
                                          $insurance_nr, $polyclinich, $date_created, $created_by, $id_doctor, $blood_type, $rh_factor, $allergies, $anamnesis)
    {
        $patientcreated = $this->create_patient($photo, $name, $fn, $surname, $pid, $gender, $phone, $address, $profession, $job, $guardian, $bd, $bp, $email, $username, $password);
        if (!$patientcreated) return false;

        $select_patient_query = "Select * from patient where username='$username'";
        $result = \mysqli_query($this->con->connect(), $select_patient_query);
        $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);
        if (!\mysqli_query($this->con->connect(), $select_patient_query)) return false;
        $patient_id = $row['id'];


        $select_receptionist_query = "Select * from receptionist where id='$created_by'";
        $result = \mysqli_query($this->con->connect(), $select_receptionist_query);
        $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);

        if (!\mysqli_query($this->con->connect(), $select_receptionist_query)) return false;

        $receptionist_name = $row['name'];
        $receptionist_surname = $row['surname'];

        $select_doctor_query = "Select * from doctor where id='" . $id_doctor . "'";
        $result = \mysqli_query($this->con->connect(), $select_doctor_query);
        $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);

        if (!\mysqli_query($this->con->connect(), $select_doctor_query)) return false;
        $doctor_name = $row['name'];
        $doctor_surname = $row['surname'];

        $insurance_nr = mysqli_real_escape_string($this->con->connect(), $insurance_nr);
        $polyclinich = mysqli_real_escape_string($this->con->connect(), $polyclinich);
        $date_created = mysqli_real_escape_string($this->con->connect(), $date_created);
        $created_by = mysqli_real_escape_string($this->con->connect(), $created_by);
        $id_doctor = mysqli_real_escape_string($this->con->connect(), $id_doctor);
        $blood_type = mysqli_real_escape_string($this->con->connect(), $blood_type);
        $rh_factor = mysqli_real_escape_string($this->con->connect(), $rh_factor);
        $allergies = mysqli_real_escape_string($this->con->connect(), $allergies);
        $anamnesis = mysqli_real_escape_string($this->con->connect(), $anamnesis);

        $query = "INSERT INTO `medical_record` (`health_insurance_nr`, `polyclinic_nr`, `date_created`, `created_by`, `id_doctor`, `id_patient`, `blood_type`, `rh_factor`, 
                  `allergies`, `anamnesis`, `doctor_name`, `doctor_surname`, `receptionist_name`, `receptionist_surname`) VALUES('$insurance_nr','$polyclinich','$date_created',
				  '$created_by','$id_doctor', '$patient_id', '$blood_type', '$rh_factor', '$allergies', '$anamnesis', '$doctor_name', '$doctor_surname', 
				  '$receptionist_name', '$receptionist_surname')";
        if (\mysqli_query($this->con->connect(), $query)) {
            return true;
        } else {
            return false;
        }
    }

    public function create_medical_record_from_import($photo, $name, $fn, $surname, $pid, $gender, $phone, $address, $profession, $job, $guardian, $bd, $bp, $email, $username, $password, $insurance_nr, $polyclinich, $date_created, $created_by, $blood_type, $rh_factor, $allergies, $anamnesis, $doc_name, $doc_surname, $rec_name, $rec_surname)
    {
        $patientcreated = $this->create_patient($photo, $name, $fn, $surname, $pid, $gender, $phone, $address, $profession, $job, $guardian, $bd, $bp, $email, $username, $password);
        if (!$patientcreated) return false;

        $select_patient_query = "Select * from patient where username='$username'";
        $result = \mysqli_query($this->con->connect(), $select_patient_query);
        $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);
        if (!\mysqli_query($this->con->connect(), $select_patient_query)) return false;
        $patient_id = $row['id'];

        $insurance_nr = mysqli_real_escape_string($this->con->connect(), $insurance_nr);
        $polyclinich = mysqli_real_escape_string($this->con->connect(), $polyclinich);
        $date_created = mysqli_real_escape_string($this->con->connect(), $date_created);
        $created_by = mysqli_real_escape_string($this->con->connect(), $created_by);
        $blood_type = mysqli_real_escape_string($this->con->connect(), $blood_type);
        $rh_factor = mysqli_real_escape_string($this->con->connect(), $rh_factor);
        $allergies = mysqli_real_escape_string($this->con->connect(), $allergies);
        $anamnesis = mysqli_real_escape_string($this->con->connect(), $anamnesis);
        $doc_name = mysqli_real_escape_string($this->con->connect(), $doc_name);
        $doc_surname = mysqli_real_escape_string($this->con->connect(), $doc_surname);
        $rec_name = mysqli_real_escape_string($this->con->connect(), $rec_name);
        $rec_surname = mysqli_real_escape_string($this->con->connect(), $rec_surname);

        $query = "INSERT INTO `medical_record` (`health_insurance_nr`, `polyclinic_nr`, `date_created`, `created_by`, `id_doctor`, `id_patient`, `blood_type`, `rh_factor`, 
                  `allergies`, `anamnesis`, `doctor_name`, `doctor_surname`, `receptionist_name`, `receptionist_surname`) VALUES('$insurance_nr','$polyclinich','$date_created',
				  '$created_by' ,NULL, '$patient_id', '$blood_type', '$rh_factor', '$allergies', '$anamnesis', '$doc_name', '$doc_surname', 
				  '$rec_name', '$rec_surname')";
        if (\mysqli_query($this->con->connect(), $query)) {
            return true;
        } else {
            return false;
        }
    }

    public function retrieve_medical_record($patient_id)
    {
        $query = "Select * from medical_record where id_patient='" . $patient_id . "'";
        $result = \mysqli_query($this->con->connect(), $query);
        if (!$result) {
            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't retrieve medical_record!\");</script>";
            exit();
        }
        $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);
        $numRows = \mysqli_num_rows($result);
        if ($numRows == 1) {
            $medical_record = new medical_record($row['id'], $row['health_insurance_nr'], $row['polyclinic_nr'], $row['date_created'],
                $row['created_by'], $row['id_doctor'], $row['id_patient'], $row['blood_type'], $row['rh_factor'], $row['allergies'],
                $row['anamnesis'], $row['doctor_name'], $row['doctor_surname'], $row['receptionist_name'], $row['receptionist_surname']);
            return $medical_record;
        }
    }

    public function delete_medical_record($id)
    {
        $query = "Select * from medical_record where id = '" . $id . "'";
        $result = \mysqli_query($this->con->connect(), $query);
        if (!$result) {
            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't retrieve medical_record!\");</script>";
            return false;
            exit();
        }
        $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);
        $patient_id = $row['id_patient'];

        $query = "Delete from patient where id = '" . $patient_id . "'";
        $result = \mysqli_query($this->con->connect(), $query);
        if (!$result) {
            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't delete patient!\");</script>";
            return false;
            exit();
        }
        $query = "Delete from medical_record where id = '" . $id . "'";
        $result = \mysqli_query($this->con->connect(), $query);
        if (!$result) {
            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't delete medical_record!\");</script>";
            return false;
            exit();
        }

        $query = "Delete from medical_visit where id_medical_record = '" . $id . "'";
        $result = \mysqli_query($this->con->connect(), $query);
        if (!$result) {
            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't delete patient!\");</script>";
            return false;
            exit();
        }
        echo "<script type='text/javascript'>alert(\"Medical record deleted successfully!\");</script>";
        return true;
    }

    public function update_medical_record($id, $photo, $name, $fn, $surname, $pid, $gender, $phone, $address, $profession, $job, $guardian, $bd, $bp, $email, $username,
                                          $insurance_nr, $polyclinic, $date_created, $created_by, $id_doctor, $id_patient, $blood_type, $rh_factor, $allergies, $anamnesis)
    {
        $this->update_patient($id_patient, $photo, $name, $fn, $surname, $pid, $gender, $phone, $address, $profession, $job, $guardian, $bd, $bp, $email, $username);

        $query = "Select * from doctor where id='" . $id_doctor . "'";
        $result = \mysqli_query($this->con->connect(), $query);
        $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);
        $doctor_name = $row['name'];
        $doctor_surname = $row['surname'];

        $insurance_nr = mysqli_real_escape_string($this->con->connect(), $insurance_nr);
        $polyclinic = mysqli_real_escape_string($this->con->connect(), $polyclinic);
        $date_created = mysqli_real_escape_string($this->con->connect(), $date_created);
        $created_by = mysqli_real_escape_string($this->con->connect(), $created_by);
        $id_doctor = mysqli_real_escape_string($this->con->connect(), $id_doctor);
        $blood_type = mysqli_real_escape_string($this->con->connect(), $blood_type);
        $rh_factor = mysqli_real_escape_string($this->con->connect(), $rh_factor);
        $allergies = mysqli_real_escape_string($this->con->connect(), $allergies);
        $anamnesis = mysqli_real_escape_string($this->con->connect(), $anamnesis);

        $query = "Update medical_record set health_insurance_nr='$insurance_nr',polyclinic_nr='$polyclinic', date_created='$date_created', created_by='$created_by', id_doctor='$id_doctor', blood_type='$blood_type',rh_factor='$rh_factor', allergies='$allergies', anamnesis='$anamnesis', doctor_name='$doctor_name', doctor_surname='$doctor_surname' where id='$id'";

        $result = \mysqli_query($this->con->connect(), $query);
        if (!$result) {
            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't update medical record! \");</script>";
            return false;
        } else {
            echo "<script type='text/javascript'>alert(\"Medical record updated successfully! \");</script>";
        }
    }


    public function create_feedback($id_patient, $rate, $comment, $date_created)
    {
        $id_patient = mysqli_real_escape_string($this->con->connect(), $id_patient);
        $rate = mysqli_real_escape_string($this->con->connect(), $rate);
        $comment = mysqli_real_escape_string($this->con->connect(), $comment);
        $date_created = mysqli_real_escape_string($this->con->connect(), $date_created);

        $query = "Insert into feedback(id_patient, rate, comment, date_created) VALUES('$id_patient','$rate',
				  '$comment','$date_created')";

        if (\mysqli_query($this->con->connect(), $query)) {
            echo "<script type='text/javascript'>alert(\"Feedback added successfully!\");</script>";
            return true;
        } else {
            echo "<script type='text/javascript'>alert(\"There was an error while adding a feedback!\");</script>";
            return false;
        }
    }

    public function retrieve_feedback($id_patient)
    {
        $query = "Select * from feedback where id_patient='" . $id_patient . "'";
        $result = \mysqli_query($this->con->connect(), $query);
        if (!$result) {
            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't retrieve feedback!\");</script>";
            exit();
        }
        $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);
        $numRows = \mysqli_num_rows($result);
        if ($numRows == 1) {
            $feedback = new feedback($row['id'], $row['id_patient'], $row['comment'], $row['date_created']);
            return $feedback;
        }
        return null;
    }

    public function update_feedback($id_patient, $rate, $comment, $date_created)
    {
        $id_patient = mysqli_real_escape_string($this->con->connect(), $id_patient);
        $rate = mysqli_real_escape_string($this->con->connect(), $rate);
        $comment = mysqli_real_escape_string($this->con->connect(), $comment);
        $date_created = mysqli_real_escape_string($this->con->connect(), $date_created);

        $query = "Update feedback set rate='$rate', comment='$comment', date_created='$date_created' where id_patient='$id_patient'";

        $result = \mysqli_query($this->con->connect(), $query);
        if (!$result) {
            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't update feedback! \");</script>";
            return false;
            exit();
        } else {
            echo "<script type='text/javascript'>alert(\"Feedback updated successfully! \");</script>";
        }
    }

    public function create_doctor($photo, $name, $fn, $surname, $pid, $gender, $phone, $bd, $bp, $ad, $university, $gd, $speciality, $cb, $email, $username, $password, $isd, $rn, $rs)
    {
        $photo = mysqli_real_escape_string($this->con->connect(), $photo);
        $name = mysqli_real_escape_string($this->con->connect(), $name);
        $fn = mysqli_real_escape_string($this->con->connect(), $fn);
        $surname = mysqli_real_escape_string($this->con->connect(), $surname);
        $pid = mysqli_real_escape_string($this->con->connect(), $pid);
        $gender = mysqli_real_escape_string($this->con->connect(), $gender);
        $phone = mysqli_real_escape_string($this->con->connect(), $phone);
        $bd = mysqli_real_escape_string($this->con->connect(), $bd);
        $bp = mysqli_real_escape_string($this->con->connect(), $bp);
        $ad = mysqli_real_escape_string($this->con->connect(), $ad);
        $university = mysqli_real_escape_string($this->con->connect(), $university);
        $gd = mysqli_real_escape_string($this->con->connect(), $gd);
        $speciality = mysqli_real_escape_string($this->con->connect(), $speciality);
        $cb = mysqli_real_escape_string($this->con->connect(), $cb);
        $email = mysqli_real_escape_string($this->con->connect(), $email);
        $username = mysqli_real_escape_string($this->con->connect(), $username);
        $password = mysqli_real_escape_string($this->con->connect(), $password);
        $isd = mysqli_real_escape_string($this->con->connect(), $isd);
        $rn = mysqli_real_escape_string($this->con->connect(), $rn);
        $rs = mysqli_real_escape_string($this->con->connect(), $rs);


        $query = "INSERT INTO `doctor` ( `photo`, `name`, `father_name`, `surname`, `personal_id`, `gender`, `phone`, `birthdate`, `birthplace`, `academic_degree`, `university`, `graduation_date`, `speciality`, `created_by`, `email`, `username`, `password`, `is_director`, `receptionist_name`, `receptionist_surname`) 
VALUES('$photo','$name', '$fn','$surname', '$pid', '$gender', '$phone', '$bd', '$bp', '$ad' , '$university' , '$gd' , '$speciality' , '$cb',  '$email', '$username', '$password', '$isd', '$rn', '$rs')";

        if (\mysqli_query($this->con->connect(), $query)) {
            return true;
        } else {
            echo "<script type='text/javascript'>alert(\"There was an error while adding a doctor!\");</script>";
            return false;
        }
    }

    public function retrieve_doctor($id)
    {
        $query = "Select * from doctor where id='" . $id . "'";
        $result = \mysqli_query($this->con->connect(), $query);
        if (!$result) {
            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't retrieve doctor!\");</script>";
            exit();
        }
        $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);
        $numRows = \mysqli_num_rows($result);
        if ($numRows == 1) {
            $doctor = new doctor($row['id'], $row['photo'], $row['name'], $row['father_name'], $row['surname'],
                $row['personal_id'], $row['gender'], $row['phone'],
                $row['birthdate'], $row['birthplace'], $row['academic_degree'], $row['university'], $row['graduation_date'], $row['speciality'], $row['created_by'], $row['email'], $row['username'], $row['password']
                , $row['is_director'], $row['receptionist_name'], $row['receptionist_surname']);
            return $doctor;
        }
    }

    public function delete_doctor($id)
    {
        $query = "DELETE FROM doctor WHERE id = '" . $id . "'";
        $result = \mysqli_query($this->con->connect(), $query);
        if (!$result) {
            return false;
        }
        return true;
    }


    public function update_doctor($id, $photo, $name, $fn, $surname, $pid, $gender, $phone, $bd, $bp, $ad, $university, $gd, $speciality, $cb, $email, $username, $isd, $rn, $rs)
    {
        $photo = mysqli_real_escape_string($this->con->connect(), $photo);
        $name = mysqli_real_escape_string($this->con->connect(), $name);
        $fn = mysqli_real_escape_string($this->con->connect(), $fn);
        $surname = mysqli_real_escape_string($this->con->connect(), $surname);
        $pid = mysqli_real_escape_string($this->con->connect(), $pid);
        $gender = mysqli_real_escape_string($this->con->connect(), $gender);
        $phone = mysqli_real_escape_string($this->con->connect(), $phone);
        $bd = mysqli_real_escape_string($this->con->connect(), $bd);
        $bp = mysqli_real_escape_string($this->con->connect(), $bp);
        $ad = mysqli_real_escape_string($this->con->connect(), $ad);
        $university = mysqli_real_escape_string($this->con->connect(), $university);
        $gd = mysqli_real_escape_string($this->con->connect(), $gd);
        $speciality = mysqli_real_escape_string($this->con->connect(), $speciality);
        $cb = mysqli_real_escape_string($this->con->connect(), $cb);
        $email = mysqli_real_escape_string($this->con->connect(), $email);
        $username = mysqli_real_escape_string($this->con->connect(), $username);
        $isd = mysqli_real_escape_string($this->con->connect(), $isd);
        $rn = mysqli_real_escape_string($this->con->connect(), $rn);
        $rs = mysqli_real_escape_string($this->con->connect(), $rs);

        $query = "UPDATE `doctor` SET  `name`='$name',  `photo`='$photo', `father_name`='$fn', `surname`='$surname', `personal_id`='$pid', `gender`='$gender', `phone`='$phone', `birthdate`='$bd', `birthplace`='$bp', `academic_degree`='$ad' , `university`='$university' , `graduation_date`='$gd',`speciality`='$speciality',`created_by`='$cb',`email`='$email', `username`='$username', `is_director`='$isd' , `receptionist_name`='$rn', `receptionist_surname`='$rs'  WHERE `doctor`.`id`= '$id'";

        //    $query = "UPDATE `doctor` SET  `photo`='$photo', `name`='$name', `father_name`='$fn', `surname`='$surname', `personal_id`='$pid', `gender`='$gender', `phone`='$phone', `birthdate`='$bd' , `birthplace`='$bp', `academic_degree`='$ad' , `university`='$university' , `graduation_date`='$gd',`speciality`='$speciality',`created_by`='$cb' ,`email`='$email', `username`='$username',WHERE `doctor`.`id`= '$id'";

        $result = \mysqli_query($this->con->connect(), $query);
        if (!$result) {
            return false;
        }
        return true;
    }

    public function changePass_doctor($id, $pass)
    {
        $pass = mysqli_real_escape_string($this->con->connect(), $pass);
        $query = "Update doctor set password='$pass' where id='$id'";
        $result = \mysqli_query($this->con->connect(), $query);
        if (!$result) {
            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't change password! \");</script>";
            return false;
            exit();
        }
        return true;
    }


    public function create_medical_visit($idmr, $idd, $ab, $dc, $complaints, $diagnosis, $medicines, $do, $isi, $dn, $ds, $rn, $rs)
    {
        $idmr = mysqli_real_escape_string($this->con->connect(), $idmr);
        $idd = mysqli_real_escape_string($this->con->connect(), $idd);
        $ab = mysqli_real_escape_string($this->con->connect(), $ab);
        $dc = mysqli_real_escape_string($this->con->connect(), $dc);
        $complaints = mysqli_real_escape_string($this->con->connect(), $complaints);
        $diagnosis = mysqli_real_escape_string($this->con->connect(), $diagnosis);
        $medicines = mysqli_real_escape_string($this->con->connect(), $medicines);
        $do = mysqli_real_escape_string($this->con->connect(), $do);
        $isi = mysqli_real_escape_string($this->con->connect(), $isi);
        $dn = mysqli_real_escape_string($this->con->connect(), $dn);
        $ds = mysqli_real_escape_string($this->con->connect(), $ds);
        $rn = mysqli_real_escape_string($this->con->connect(), $rn);
        $rs = mysqli_real_escape_string($this->con->connect(), $rs);


        $query = "INSERT INTO `medical_visit`(`id_medical_record`, `id_doctor`, `allowed_by`, `date_created`, `complaints`, `diagnosis`, `medicines`, `days_off`, `is_infectious`, `doctor_name`, `doctor_surname`, `receptionist_name`, `receptionist_surname`)
        VALUES ('$idmr','$idd', '$ab','$dc', '$complaints', '$diagnosis', '$medicines', '$do', '$isi', '$dn',
            '$ds', '$rn', '$rs')";
        if (\mysqli_query($this->con->connect(), $query)) {
            $query1 = "Update medical_record set in_waiting='0' where id='" . $idmr . "'";
            if (\mysqli_query($this->con->connect(), $query1)) {
                return true;
            }
        } else {
            return false;
        }
    }

    public function create_medical_visit_from_import($idmr, $dc, $complaints, $diagnosis, $medicines, $do, $isi, $dn, $ds, $rn, $rs)
    {
        $idmr = mysqli_real_escape_string($this->con->connect(), $idmr);
        $dc = mysqli_real_escape_string($this->con->connect(), $dc);
        $complaints = mysqli_real_escape_string($this->con->connect(), $complaints);
        $diagnosis = mysqli_real_escape_string($this->con->connect(), $diagnosis);
        $medicines = mysqli_real_escape_string($this->con->connect(), $medicines);
        $do = mysqli_real_escape_string($this->con->connect(), $do);
        $isi = mysqli_real_escape_string($this->con->connect(), $isi);
        $dn = mysqli_real_escape_string($this->con->connect(), $dn);
        $ds = mysqli_real_escape_string($this->con->connect(), $ds);
        $rn = mysqli_real_escape_string($this->con->connect(), $rn);
        $rs = mysqli_real_escape_string($this->con->connect(), $rs);


        $query = "INSERT INTO `medical_visit`(`id_medical_record`, `id_doctor`, `allowed_by`, `date_created`, `complaints`, `diagnosis`, `medicines`, `days_off`, `is_infectious`, `doctor_name`, `doctor_surname`, `receptionist_name`, `receptionist_surname`)
        VALUES ('$idmr',NULL, NULL,'$dc', '$complaints', '$diagnosis', '$medicines', '$do', '$isi', '$dn',
            '$ds', '$rn', '$rs')";
        if (\mysqli_query($this->con->connect(), $query)) {
            return true;
        } else {
            return false;
        }
    }

    public function retrieve_receptionist($id)
    {
        $query = "Select * from receptionist where id='" . $id . "'";
        $result = \mysqli_query($this->con->connect(), $query);
        if (!$result) {
            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't retrieve patient!\");</script>";
            exit();
        }
        $row = \mysqli_fetch_array($result, MYSQLI_ASSOC);
        $numRows = \mysqli_num_rows($result);
        if ($numRows == 1) {
            $receptionist = new receptionist($row['id'], $row['photo'], $row['name'], $row['father_name'], $row['surname'],
                $row['personal_id'], $row['gender'], $row['birthdate'], $row['birthplace'], $row['email'],
                $row['username'], $row['password'], $row['academic_degree'],
                $row['university'], $row['graduation_date']);
            return $receptionist;
        }
    }

    public function changePass_receptionist($id, $pass)
    {
        $pass = mysqli_real_escape_string($this->con->connect(), $pass);
        $query = "Update receptionist set password='" . $pass . "' where id='" . $id . "'";
        $result = \mysqli_query($this->con->connect(), $query);
        if (!$result) {
            echo "<script type='text/javascript'>alert(\"Some error occurred! Couldn't change password! \");</script>";
            return false;
        }
        return true;
    }
}

<?php
session_start();
require 'crud_class.php';
require 'validate_class.php';
require_once 'database_class.php';

$con = new \core\database();
$action = new \core\user\crud();
$valid = new \core\logic\validate();

if (!isset($_SESSION['user']) == 'receptionist' or !isset($_SESSION['id']))
    header("Location: login.php");
if (!isset($_POST['details']))
    header("Location: recPacList.php");

$pac = $action->retrieve_patient($_POST['details']);
$med = $action->retrieve_medical_record($_POST['details']);

$xml = new DOMDocument("1.0");
$xml->formatOutput = true;
$medical_record = $xml->createElement("medical_record");
$xml->appendChild($medical_record);

// medical record attributes start
$medical_record->appendChild($xml->createElement("id", $med->id));
$medical_record->appendChild($xml->createElement("health_insurance_nr", $med->health_insurance_nr));
$medical_record->appendChild($xml->createElement("polyclinic_nr", $med->polyclinic_nr));
$medical_record->appendChild($xml->createElement("date_created", $med->date_created));
$medical_record->appendChild($xml->createElement("created_by", $med->created_by));
$medical_record->appendChild($xml->createElement("id_doctor", $med->id_doctor));
$medical_record->appendChild($xml->createElement("id_patient", $med->id_patient));
$medical_record->appendChild($xml->createElement("blood_type", $med->blood_type));
$medical_record->appendChild($xml->createElement("rh_factor", $med->rh_factor));
$medical_record->appendChild($xml->createElement("allergies", $med->allergies));
$medical_record->appendChild($xml->createElement("anamnesis", $med->anamnesis));
$medical_record->appendChild($xml->createElement("doctor_name", $med->doctor_name));
$medical_record->appendChild($xml->createElement("doctor_surname", $med->doctor_surname));
$medical_record->appendChild($xml->createElement("receptionist_name", $med->receptionist_name));
$medical_record->appendChild($xml->createElement("receptionist_surname", $med->receptionist_surname));
$medical_record->appendChild($xml->createElement("in_waiting", $med->in_waiting));
// medical record attributes end

// patient section start
$patient = $xml->createElement("patient");
$xml->appendChild($patient);
$patient->appendChild($xml->createElement("id", $pac->id));
$patient->appendChild($xml->createElement("photo", $pac->photo));
$patient->appendChild($xml->createElement("name", $pac->name));
$patient->appendChild($xml->createElement("father_name", $pac->father_name));
$patient->appendChild($xml->createElement("surname", $pac->surname));
$patient->appendChild($xml->createElement("personal_id", $pac->personal_id));
$patient->appendChild($xml->createElement("gender", $pac->gender));
$patient->appendChild($xml->createElement("phone", $pac->phone));
$patient->appendChild($xml->createElement("address", $pac->address));
$patient->appendChild($xml->createElement("profession", $pac->profession));
$patient->appendChild($xml->createElement("job", $pac->job));
$patient->appendChild($xml->createElement("guardian", $pac->guardian));
$patient->appendChild($xml->createElement("birthdate", $pac->birthdate));
$patient->appendChild($xml->createElement("birthplace", $pac->birthplace));
$patient->appendChild($xml->createElement("email", $pac->email));
$patient->appendChild($xml->createElement("username", $pac->username));
$patient->appendChild($xml->createElement("password", $pac->password));
$medical_record->appendChild($patient);
// patient section end

// visits

$query = "Select * from medical_visit where id_medical_record='$med->id'";
$result = \mysqli_query($con->connect(), $query);

$numRows = \mysqli_num_rows($result);
$visits = $xml->createElement("visits");

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $visit = $xml->createElement("visit");

    $visit->appendChild($xml->createElement("id", $row['id']));
    $visit->appendChild($xml->createElement("id_medical_record", $row['id_medical_record']));
    $visit->appendChild($xml->createElement("id_doctor", $row['id_doctor']));
    $visit->appendChild($xml->createElement("allowed_by", $row['allowed_by']));
    $visit->appendChild($xml->createElement("date_created", $row['date_created']));
    $visit->appendChild($xml->createElement("complaints", $row['complaints']));
    $visit->appendChild($xml->createElement("diagnosis", $row['diagnosis']));
    $visit->appendChild($xml->createElement("medicines", $row['medicines']));
    $visit->appendChild($xml->createElement("days_off", $row['days_off']));
    $visit->appendChild($xml->createElement("is_infectious", $row['is_infectious']));
    $visit->appendChild($xml->createElement("doctor_name", $row['doctor_name']));
    $visit->appendChild($xml->createElement("doctor_surname", $row['doctor_surname']));
    $visit->appendChild($xml->createElement("receptionist_name", $row['receptionist_name']));
    $visit->appendChild($xml->createElement("receptionist_surname", $row['receptionist_surname']));
    $visits->appendChild($visit);
}
$medical_record->appendChild($visits);
$filename = $pac->name . "_" . $pac->surname . "_medical_record";

header('Content-type: text/xml');
header('Content-Disposition: attachment; filename=' . $filename . ".xml");

echo $xml->saveXML();
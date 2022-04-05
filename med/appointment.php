<?php
$db = new mysqli("localhost", "root", "", "zadanie_med");
$appointmentId = $_REQUEST['appointmentId'];
$q = $db->prepare("SELECT * FROM appointment WHERE id = ?");
$q->bind_param("i", $appointmentId);
if($q && $q->execute()) {
    $appointment = $q->get_result()->fetch_assoc();
    $appointmentDate = $appointment['date'];
    $appointmentTimestamp = strtotime($appointmentDate);
    echo "Zapis na wiztyę w terminie".date("j.m H:i", $appointmentTimestamp)."<br>";
}
if(isset($_REQUEST['firstName']) && isset($_REQUEST['lastName'])) {
    $q->prepare("INSERT INTO patient VALUES (NULL, ?, ?, ?, ?");
    $q->bind_param("ssss", $_REQUEST['firstName'], $_REQUEST['lastName'],
                        $_REQUEST['pesel'], $_REQUEST['phone']);
    $q->execute();
    $patientId = $db->insert_id;
    $q->prepare("INSERT INTO patientappointment VALUES (NULL, ?, ?)");
    $q->bind_param("ii", $appointmentId, $patientId);
    $q->execute();
    echo "Zapisano na wizytę!";
} else {
    $q = $db->prepare("SELECT * FROM patient WHERE pesel = ?");
    $q->bind_param("s", $_REQUEST['pesel']);
    $q->execute();
    $patientResult = $q->get_result();
    $patient = $patientResult->fetch_assoc();
    $patientId = $patient['id'];
    $q->prepare("INSERT INTO patientappointment VALUES (NULL, ?, ?)");
    $q->bind_param("ii", $appointmentId, $patientId);
    $q->execute();
    echo "Zapisano na wizytę!";
}
?>





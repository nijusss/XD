<?php
$db = new mysqli("localhost", "root", "", "zadanie_med");
$appointmentId = $_REQUEST['appointmentId'];
if(isset($_REQUEST['firstName']) && isset($_REQUEST['lastName'])) {

}

$q = $db->prepare("SELECT * FROM staff");

if($q->execute()) {
    $result = $q->get_result();
    while($row = $result->fetch_assoc()) {
        $staff_id = $row['id'];
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        echo "Lekarz $firstName $lastName:<br>";
        $q = $db->prepare("SELECT * FROM appointment WHERE staff_id = ?");
        $q->bind_param("i",$staff_id);
        if($q && $q->execute()) {
            $appointments = $q->get_result();
            while($appointment = $appointments->fetch_assoc()) {
                $appointmentId = $appointment['id'];
                $appointmentDate = $appointment['date'];
                $appointmentTimestamp = strtotime($appointmentDate);
                echo "<a href=\"patientLogin.php?id=$appointmentId\" style=\"margin:10px; display:block\">";
                echo date("j.m H:i", $appointmentTimestamp);
                echo "</a>";
            }
            echo "<br>";
        } else {
            die("Błąd pobierania wizyt z bazy danych");
        }
    }
} else {
    die("Błąd pobierania lekarzy z bazy danych");
}
//
?>
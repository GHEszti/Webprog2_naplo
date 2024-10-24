<?php
// SOAP API beállításai
class SchoolService {
    public function getStudents() {
        global $conn;
        $query = "SELECT * FROM diak";
        $result = $conn->query($query);
        $students = [];
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        return $students;
    }

    public function addStudent($name, $class, $gender) {
        global $conn;
        $gender = $gender ? 1 : 0; // 1 = fiú, 0 = lány
        $insertQuery = "INSERT INTO diak (nev, osztaly, fiu) VALUES ('$name', '$class', '$gender')";
        if ($conn->query($insertQuery) === TRUE) {
            return "Diák hozzáadva!";
        } else {
            return "Hiba: " . $conn->error;
        }
    }
}

// SOAP szerver beállítása
$options = array('uri' => 'http://localhost/');
$server = new SoapServer(null, $options);
$server->setClass('SchoolService');
$server->handle();
?>

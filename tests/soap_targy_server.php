<?php 
class TargyService {
    public function getAllSubjects() {
        include 'db.php';
        $stmt = $conn->prepare("SELECT * FROM targy");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addSubject($nev, $kategoria) {
        include 'db.php';
        $stmt = $conn->prepare("INSERT INTO targy (nev, kategoria) VALUES (?, ?)");
        $stmt->bind_param("ss", $nev, $kategoria);
        return $stmt->execute();
    }
}

$server = new SoapServer(null, ['uri' => "http://yourdomain.com/targy_server.php"]);
$server->setClass('TargyService');
$server->handle();

?>
<?php
header("Content-Type: application/json");
include '../includes/db.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

// RESTful API végpontok kezelése
switch ($requestMethod) {
    case 'GET':
        if (isset($_GET['table'])) {
            $table = $_GET['table'];
            $query = "SELECT * FROM " . $table;
            $result = $conn->query($query);
            $data = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($data);
        }
        break;
    case 'POST':
        if (isset($_GET['table'])) {
            $table = $_GET['table'];
            $data = json_decode(file_get_contents('php://input'), true);
            $columns = implode(", ", array_keys($data));
            $values = "'" . implode("', '", array_values($data)) . "'";
            $insertQuery = "INSERT INTO " . $table . " ($columns) VALUES ($values)";
            if ($conn->query($insertQuery) === TRUE) {
                echo json_encode(["message" => "Data inserted successfully."]);
            } else {
                echo json_encode(["error" => $conn->error]);
            }
        }
        break;
    case 'PUT':
        // PUT logika
        break;
    case 'DELETE':
        // DELETE logika
        break;
    default:
        echo json_encode(["error" => "Invalid request method."]);
        break;
}
?>

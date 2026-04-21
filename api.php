<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Origin: *");

$host = "localhost";
$user = "utazasbeadando";
$pass = "WebProgBeadando2026"; 
$db = "utazasbeadando";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}
$conn->set_charset("utf8");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        $sql = "SELECT * FROM tavasz";
        $result = $conn->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        echo json_encode($data);
        break;

    case 'POST':
        $szalloda_az = $input['szalloda_az'];
        $indulas = $input['indulas'];
        $idotartam = $input['idotartam'];
        $ar = $input['ar'];
        
        $sql = "INSERT INTO tavasz (szalloda_az, indulas, idotartam, ar) VALUES ('$szalloda_az', '$indulas', $idotartam, $ar)";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Új rekord létrehozva"]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        break;

    case 'PUT':
        $id = $input['id'];
        $szalloda_az = $input['szalloda_az'];
        $indulas = $input['indulas'];
        $idotartam = $input['idotartam'];
        $ar = $input['ar'];
        
        $sql = "UPDATE tavasz SET szalloda_az='$szalloda_az', indulas='$indulas', idotartam=$idotartam, ar=$ar WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Rekord frissítve"]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $sql = "DELETE FROM tavasz WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Rekord törölve"]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        break;
}

$conn->close();
?>
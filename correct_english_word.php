<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');

include 'DB_connection.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'));
        $sql = 'UPDATE german_english_shorttext SET english_score = english_score + 1 WHERE ID = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $data->id, PDO::PARAM_INT);
        $stmt->execute();
        break;
}
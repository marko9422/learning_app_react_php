<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');

include 'DB_connection.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$user = file_get_contents('php://input');
$method = $_SERVER['REQUEST_METHOD'];

switch($method) {


    case 'POST':

        $user = json_decode(file_get_contents('php://input'));
        $sql = "INSERT INTO german_english_shorttext (german,english) 
        VALUES(:germanShortText,:englishShortText)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':germanShortText', $user->germanShortText);
        $stmt->bindParam(':englishShortText', $user->englishShortText);

        if($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Record created successfully.'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to create record.'];
        }

        echo json_encode($response);
        break;

}


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

    case 'GET':

        $sql = "SELECT * FROM categories";
        $path = explode('/', $_SERVER['REQUEST_URI'] ); 

        if (isset($path[3]) && is_numeric($path[3])) {
            $sql .= " WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $path[3]);
            $stmt->execute();
            $users = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        echo json_encode($users);
        break;


    case 'POST':

        $user = json_decode(file_get_contents('php://input'));

        $sqlUpdate = "UPDATE categories SET checked = 0";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->execute();

        $sql = "INSERT INTO categories (categoryValue,checked) 
        VALUES(:categoryValue,1)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':categoryValue', $user->categoryValue);

        if($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Record created successfully.'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to create record.'];
        }

        echo json_encode($response);
        break;

}

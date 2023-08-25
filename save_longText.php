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

        if ($data !== null) {
            // Assuming 'text_data' is the name of the column in your table.
            $sql = "INSERT INTO german_grammar (text_data,question) VALUES (:textData,:question)";
            
            $stmt = $conn->prepare($sql);

            // Bind the parameter
            $stmt->bindParam(':textData', $data->text_data);
            $stmt->bindParam(':question', $data->question);

            if ($stmt->execute()) {
                // Data was successfully inserted
                $response = ['message' => 'Data inserted successfully'];
                echo json_encode($response);
            } else {
                // Handle the case where the insertion failed
                $response = ['error' => 'Failed to insert data'];
                echo json_encode($response);
            }
        } else {
            // Handle the case where JSON parsing failed
            $response = ['error' => 'Invalid JSON data'];
            echo json_encode($response);
        }
        break;

}
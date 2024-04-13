<?php
include 'connection.php';

//set headers for allowing CORS and specifying JSON content type
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

//Handle GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //Retrieve all records
    if ($_GET['action'] === 'get_all') {
        $stmt = $conn->prepare("SELECT * FROM tblperson");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($rows);
    }
}else if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //Parse incoming JSON data
    $data = json_decode(file_get_contents("php://input", true));

    //Create new record
    if ($data['action'] === 'create') {
        try{
            $lastname = $data['lastName'];
            $firstname = $data['firstName'];
            $email = $data['email'];

            $stmt = $conn->prepare("INSERT INTO tblperson (lastName, firstName, email) VALUES (?, ?, ?)");
            $stmt->execute([$lastname, $firstname, $email]);

            echo json_encode(array("message" => "Record created successfully"));
            
        }catch(PDOException $e){
            echo json_encode(array("error" => "Error creating record"  . $e->getMessage()));
        }

    }
}

//Close db conn
$conn = null;

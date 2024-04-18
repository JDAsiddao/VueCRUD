<?php
include 'connection.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'get_all') {
            // Fetch all records
            $stmt = $conn->prepare("SELECT * FROM tblperson");
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($rows);
        } else if ($_GET['action'] === 'get_by_id') {
            // Fetch a specific record by ID
            $id = $_GET['id'];
            $stmt = $conn->prepare("SELECT * FROM tblperson WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($row);
        } else {
            echo json_encode(array("error" => "Unknown action"));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data['action'] === 'create') {
        // Create new record
        try {
            $lastname = $data['lastName'];
            $firstname = $data['firstName'];
            $email = $data['email'];

            $stmt = $conn->prepare("INSERT INTO tblperson (lastName, firstName, email) VALUES (?, ?, ?)");
            $stmt->execute([$lastname, $firstname, $email]);

            echo json_encode(array("message" => "Record created successfully"));
        } catch (PDOException $e) {
            echo json_encode(array("error" => "Error creating record: " . $e->getMessage()));
        }
    } else if ($data['action'] === 'update' && isset($data['id'])) {
        // Update existing record
        try {
            $id = $data['id'];
            $lastname = $data['lastName'];
            $firstname = $data['firstName'];
            $email = $data['email'];
            echo json_encode(array("firstName" => $firstname));
            $stmt = $conn->prepare("UPDATE tblperson SET lastName = ?, firstName = ?, email = ? WHERE id = ?");
            $stmt->execute([$lastname, $firstname, $email, $id]);

            echo json_encode(array("message" => "Record updated successfully"));
            
        } catch (PDOException $e) {
            echo json_encode(array("error" => "Error updating record: " . $e->getMessage()));
        }
    } else if ($data['action'] === 'delete' && isset($data['id'])) {
        // Delete record
        try {
            $id = $data['id'];
            $stmt = $conn->prepare("DELETE FROM tblperson WHERE id = ?");
            $stmt->execute([$id]);

            echo json_encode(array("message" => "Record deleted successfully"));
        } catch (PDOException $e) {
            echo json_encode(array("error" => "Error deleting record: " . $e->getMessage()));
        }
    } else {
        echo json_encode(array("error" => "Invalid action or missing ID"));
    }
}

$conn = null;
?>

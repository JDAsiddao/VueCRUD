<?php
include 'connection.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data['action'] === 'register') {
        // Register new user with username, email, and password
        try {
            $lastname = $data['lastName'];
            $firstname = $data['firstName'];
            $username = $data['username'];
            $email = $data['email'];
            $password = password_hash($data['password'], PASSWORD_DEFAULT); 

            $stmt = $conn->prepare("INSERT INTO customers (lastName, firstName, username, email, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$lastname, $firstname, $username, $email, $password]);

            echo json_encode(array("message" => "Registration successful"));
        } catch (PDOException $e) {
            echo json_encode(array("error" => "Error registering user: " . $e->getMessage()));
        }
    } else if ($data['action'] === 'login') { // Added action check for login
        $username = $data['username'];
        $password = $data['password'];

        // Fetch user data from the database based on username
        $stmt = $conn->prepare("SELECT * FROM customers WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['username'] = $username;
            echo json_encode(array("message" => "Login successful"));
        } else {
            // Invalid credentials
            http_response_code(401);
            echo json_encode(array("error" => "Invalid username or password"));
        }
    } else {
        echo json_encode(array("error" => "Invalid action"));
    }
}

$conn = null;
?>

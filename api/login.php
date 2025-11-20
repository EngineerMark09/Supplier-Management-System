<?php
// User login
session_start();
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$input = file_get_contents("php://input");
$data = json_decode($input);

if($data === null && json_last_error() !== JSON_ERROR_NONE) {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
} else {
    $username = isset($data->username) ? $data->username : '';
    $password = isset($data->password) ? $data->password : '';
}

if(!empty($username) && !empty($password)){
    $query = "SELECT id, username, password, full_name FROM users WHERE username = :username LIMIT 1";
    $stmt = $db->prepare($query);
    
    $username = htmlspecialchars(strip_tags($username));
    $stmt->bindParam(":username", $username);
    
    $stmt->execute();
    $num = $stmt->rowCount();
    
    if($num > 0){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify password
        if(password_verify($password, $row['password'])){
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['logged_in'] = true;
            
            http_response_code(200);
            echo json_encode(array("message" => "Login successful."));
        } else {
            http_response_code(401);
            echo json_encode(array("message" => "Invalid username or password."));
        }
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "Invalid username or password."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Username and password are required."));
}
?>

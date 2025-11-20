<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$input = file_get_contents("php://input");
$data = json_decode($input);

if(
    !empty($data->company_name) &&
    !empty($data->contact_person) &&
    !empty($data->email) &&
    !empty($data->phone) &&
    !empty($data->address)
){
    $query = "INSERT INTO suppliers SET company_name=:company_name, contact_person=:contact_person, email=:email, phone=:phone, address=:address";
    $stmt = $db->prepare($query);

    // Sanitize
    $company_name = htmlspecialchars(strip_tags($data->company_name));
    $contact_person = htmlspecialchars(strip_tags($data->contact_person));
    $email = htmlspecialchars(strip_tags($data->email));
    $phone = htmlspecialchars(strip_tags($data->phone));
    $address = htmlspecialchars(strip_tags($data->address));

    // Bind
    $stmt->bindParam(":company_name", $company_name);
    $stmt->bindParam(":contact_person", $contact_person);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->bindParam(":address", $address);

    if($stmt->execute()){
        http_response_code(201);
        echo json_encode(array("message" => "Supplier was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create supplier.", "error" => $stmt->errorInfo()));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create supplier. Data is incomplete.", "received" => $data));
}
?>

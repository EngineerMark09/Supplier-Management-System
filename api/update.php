<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id)){
    $query = "UPDATE suppliers SET company_name=:company_name, contact_person=:contact_person, email=:email, phone=:phone, address=:address WHERE id = :id";
    $stmt = $db->prepare($query);

    // Sanitize
    $company_name = htmlspecialchars(strip_tags($data->company_name));
    $contact_person = htmlspecialchars(strip_tags($data->contact_person));
    $email = htmlspecialchars(strip_tags($data->email));
    $phone = htmlspecialchars(strip_tags($data->phone));
    $address = htmlspecialchars(strip_tags($data->address));
    $id = htmlspecialchars(strip_tags($data->id));

    // Bind
    $stmt->bindParam(":company_name", $company_name);
    $stmt->bindParam(":contact_person", $contact_person);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":id", $id);

    if($stmt->execute()){
        http_response_code(200);
        echo json_encode(array("message" => "Supplier was updated."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update supplier."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to update supplier. ID is missing."));
}
?>

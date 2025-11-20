<?php
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$id = isset($_GET['id']) ? $_GET['id'] : die();

$query = "SELECT * FROM suppliers WHERE id = ? LIMIT 0,1";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $id);
$stmt->execute();

$num = $stmt->rowCount();

if($num > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);
    $supplier_item = array(
        "id" => $id,
        "company_name" => $company_name,
        "contact_person" => $contact_person,
        "email" => $email,
        "phone" => $phone,
        "address" => $address,
        "status" => isset($status) ? $status : 'Active'
    );
    http_response_code(200);
    echo json_encode($supplier_item);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Supplier not found."));
}
?>

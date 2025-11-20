<?php
// Get all suppliers
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

// Get all suppliers, oldest first (ascending ID)
$query = "SELECT * FROM suppliers ORDER BY id ASC";
$stmt = $db->prepare($query);
$stmt->execute();

$num = $stmt->rowCount();
$suppliers_arr = array();

// Build response array
if($num > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
        array_push($suppliers_arr, $supplier_item);
    }
    http_response_code(200);
    echo json_encode($suppliers_arr);
} else {
    http_response_code(200);
    echo json_encode(array());
}
?>

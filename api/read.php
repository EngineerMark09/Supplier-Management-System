<?php
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM suppliers ORDER BY id DESC";
$stmt = $db->prepare($query);
$stmt->execute();

$num = $stmt->rowCount();
$suppliers_arr = array();

if($num > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $supplier_item = array(
            "id" => $id,
            "company_name" => $company_name,
            "contact_person" => $contact_person,
            "email" => $email,
            "phone" => $phone,
            "address" => $address
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

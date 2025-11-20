<?php
header("Content-Type: application/json; charset=UTF-8");

// Get the raw POST data
$input = file_get_contents("php://input");
$data = json_decode($input);

echo json_encode([
    'raw_input' => $input,
    'decoded_data' => $data,
    'is_name_set' => isset($data->name),
    'is_email_set' => isset($data->email),
    'is_phone_set' => isset($data->phone),
    'is_address_set' => isset($data->address),
    'name_empty' => empty($data->name ?? ''),
    'email_empty' => empty($data->email ?? ''),
    'phone_empty' => empty($data->phone ?? ''),
    'address_empty' => empty($data->address ?? '')
], JSON_PRETTY_PRINT);
?>

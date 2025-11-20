<?php
// Database auto-provisioning script
// This script automatically creates the database and table if they don't exist

$host = "localhost";
$username = "root";
$password = "";
$db_name = "supplier_db";

try {
    // First, connect without selecting a database
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if it doesn't exist
    $conn->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    // Now connect to the database
    $conn->exec("USE `$db_name`");
    
    // Create suppliers table if it doesn't exist
    $createTableSQL = "
        CREATE TABLE IF NOT EXISTS `suppliers` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `company_name` VARCHAR(100) NOT NULL,
            `contact_person` VARCHAR(100) NOT NULL,
            `email` VARCHAR(100) NOT NULL,
            `phone` VARCHAR(20) NOT NULL,
            `address` TEXT NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";
    
    $conn->exec($createTableSQL);
    
    // Optional: Insert sample data if table is empty
    $checkData = $conn->query("SELECT COUNT(*) as count FROM suppliers");
    $row = $checkData->fetch(PDO::FETCH_ASSOC);
    
    if ($row['count'] == 0) {
        // Insert sample suppliers
        $sampleData = [
            ['Tech Solutions Inc.', 'John Smith', 'john@techsolutions.com', '+1-555-0101', '123 Tech Street, Silicon Valley, CA 94025'],
            ['Global Suppliers Co.', 'Sarah Johnson', 'sarah@globalsuppliers.com', '+1-555-0202', '456 Commerce Ave, New York, NY 10001'],
            ['Innovate Systems', 'Michael Chen', 'michael@innovatesys.com', '+1-555-0303', '789 Innovation Blvd, Austin, TX 73301']
        ];
        
        $insertSQL = "INSERT INTO suppliers (company_name, contact_person, email, phone, address) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSQL);
        
        foreach ($sampleData as $data) {
            $stmt->execute($data);
        }
    }
    
    return true;
    
} catch(PDOException $e) {
    error_log("Database initialization error: " . $e->getMessage());
    return false;
}
?>

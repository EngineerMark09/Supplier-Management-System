<?php
// Drop and recreate suppliers table with correct structure

try {
    $conn = new PDO('mysql:host=localhost;dbname=supplier_db', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database successfully.\n\n";
    
    // Drop existing table
    $conn->exec("DROP TABLE IF EXISTS suppliers");
    echo "✓ Old suppliers table dropped.\n\n";
    
    // Create new table with correct structure
    $createTableSQL = "
        CREATE TABLE `suppliers` (
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
    echo "✓ New suppliers table created with correct structure.\n\n";
    
    echo "✓ Suppliers table is empty and ready for new data.\n\n";
    
    echo "✓ Database fixed successfully!\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>

<?php
echo "Testing Database Connection...\n\n";

try {
    $conn = new PDO('mysql:host=localhost;dbname=supplier_db', 'root', '');
    echo "✓ Database connected successfully\n\n";
    
    // Check suppliers table structure
    $stmt = $conn->query('DESCRIBE suppliers');
    echo "Suppliers table structure:\n";
    echo "-------------------------\n";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . " (" . $row['Type'] . ")\n";
    }
    
    echo "\n";
    
    // Try inserting a test record
    $test = $conn->prepare("INSERT INTO suppliers (company_name, contact_person, email, phone, address) VALUES ('Test Company', 'Test Person', 'test@test.com', '1234567890', 'Test Address')");
    if($test->execute()) {
        echo "✓ Test insert successful\n";
        $id = $conn->lastInsertId();
        echo "New record ID: " . $id . "\n\n";
        
        // Clean up test record
        $conn->exec("DELETE FROM suppliers WHERE id = $id");
        echo "✓ Test record cleaned up\n";
    } else {
        echo "✗ Test insert failed\n";
        print_r($test->errorInfo());
    }
    
} catch(Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
?>

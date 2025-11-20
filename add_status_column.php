<?php
// Migration script to add status column to existing suppliers table
include_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

try {
    // Check if status column already exists
    $checkColumn = $db->query("SHOW COLUMNS FROM suppliers LIKE 'status'");
    
    if ($checkColumn->rowCount() == 0) {
        // Add status column
        $alterSQL = "ALTER TABLE suppliers ADD COLUMN status ENUM('Active', 'Inactive', 'Suspended') DEFAULT 'Active' AFTER address";
        $db->exec($alterSQL);
        echo "✓ Status column added successfully!<br>";
        
        // Update existing records to have Active status
        $updateSQL = "UPDATE suppliers SET status = 'Active' WHERE status IS NULL";
        $db->exec($updateSQL);
        echo "✓ Existing records updated with Active status!<br>";
        echo "<br><strong>Migration completed successfully!</strong><br>";
        echo "<a href='dashboard.php'>Go to Dashboard</a>";
    } else {
        echo "⚠ Status column already exists. No changes needed.<br>";
        echo "<a href='dashboard.php'>Go to Dashboard</a>";
    }
    
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>

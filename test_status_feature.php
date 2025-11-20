<?php
// Comprehensive test for status feature
include_once 'config/database.php';

echo "<h2>Status Feature Validation Test</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    .pass { color: green; font-weight: bold; }
    .fail { color: red; font-weight: bold; }
    .test { margin: 10px 0; padding: 10px; border: 1px solid #ddd; }
</style>";

$database = new Database();
$db = $database->getConnection();

// Test 1: Check if status column exists
echo "<div class='test'>";
echo "<strong>Test 1: Database Schema</strong><br>";
try {
    $query = "SHOW COLUMNS FROM suppliers LIKE 'status'";
    $result = $db->query($query);
    if ($result->rowCount() > 0) {
        $column = $result->fetch(PDO::FETCH_ASSOC);
        echo "<span class='pass'>✓ Status column exists</span><br>";
        echo "Type: " . $column['Type'] . "<br>";
        echo "Default: " . $column['Default'] . "<br>";
    } else {
        echo "<span class='fail'>✗ Status column NOT found</span><br>";
    }
} catch (Exception $e) {
    echo "<span class='fail'>✗ Error: " . $e->getMessage() . "</span><br>";
}
echo "</div>";

// Test 2: Check existing data
echo "<div class='test'>";
echo "<strong>Test 2: Existing Data Status</strong><br>";
try {
    $query = "SELECT COUNT(*) as total, status FROM suppliers GROUP BY status";
    $stmt = $db->query($query);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($results) > 0) {
        echo "<span class='pass'>✓ Data retrieved successfully</span><br>";
        foreach ($results as $row) {
            $status = $row['status'] ?? 'NULL';
            echo "Status '{$status}': {$row['total']} suppliers<br>";
        }
    } else {
        echo "No suppliers in database yet<br>";
    }
} catch (Exception $e) {
    echo "<span class='fail'>✗ Error: " . $e->getMessage() . "</span><br>";
}
echo "</div>";

// Test 3: Validate ENUM values
echo "<div class='test'>";
echo "<strong>Test 3: ENUM Validation</strong><br>";
try {
    $query = "SHOW COLUMNS FROM suppliers WHERE Field = 'status'";
    $result = $db->query($query);
    $column = $result->fetch(PDO::FETCH_ASSOC);
    
    if (strpos($column['Type'], "enum('Active','Inactive','Suspended')") !== false) {
        echo "<span class='pass'>✓ ENUM values are correct: Active, Inactive, Suspended</span><br>";
    } else {
        echo "<span class='fail'>✗ ENUM values incorrect: " . $column['Type'] . "</span><br>";
    }
} catch (Exception $e) {
    echo "<span class='fail'>✗ Error: " . $e->getMessage() . "</span><br>";
}
echo "</div>";

// Test 4: Check file modifications
echo "<div class='test'>";
echo "<strong>Test 4: File Integrity</strong><br>";

$files = [
    'api/create.php' => 'status',
    'api/update.php' => 'status',
    'api/get_single.php' => 'status',
    'dashboard.php' => 'status-filter',
    'assets/js/script.js' => 'getStatusBadge',
    'assets/css/style.css' => 'status-filter',
    'reports/generate_pdf.php' => 'Status'
];

foreach ($files as $file => $searchTerm) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        if (strpos($content, $searchTerm) !== false) {
            echo "<span class='pass'>✓ {$file} contains '{$searchTerm}'</span><br>";
        } else {
            echo "<span class='fail'>✗ {$file} missing '{$searchTerm}'</span><br>";
        }
    } else {
        echo "<span class='fail'>✗ {$file} not found</span><br>";
    }
}
echo "</div>";

// Test 5: Badge CSS classes
echo "<div class='test'>";
echo "<strong>Test 5: CSS Badge Classes</strong><br>";
$cssFile = 'assets/css/style.css';
if (file_exists($cssFile)) {
    $content = file_get_contents($cssFile);
    $badges = ['badge-success', 'badge-secondary', 'badge-danger'];
    foreach ($badges as $badge) {
        if (strpos($content, $badge) !== false) {
            echo "<span class='pass'>✓ {$badge} exists</span><br>";
        } else {
            echo "<span class='fail'>✗ {$badge} missing</span><br>";
        }
    }
} else {
    echo "<span class='fail'>✗ CSS file not found</span><br>";
}
echo "</div>";

echo "<hr>";
echo "<h3>Summary</h3>";
echo "<p>All critical components have been checked. If all tests show <span class='pass'>✓</span>, the status feature is fully integrated.</p>";
echo "<p><a href='dashboard.php'>Go to Dashboard</a> | <a href='index.php'>Home</a></p>";
?>

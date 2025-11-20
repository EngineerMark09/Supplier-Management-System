<?php
class Database {
    private $host = "localhost";
    private $db_name = "supplier_db";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        
        // Auto-provision database on first connection
        $this->initializeDatabase();
        
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
    
    private function initializeDatabase() {
        try {
            // Connect without database selection
            $tempConn = new PDO("mysql:host=" . $this->host, $this->username, $this->password);
            $tempConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create database if not exists
            $tempConn->exec("CREATE DATABASE IF NOT EXISTS `" . $this->db_name . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            
            // Switch to the database
            $tempConn->exec("USE `" . $this->db_name . "`");
            
            // Create table if not exists
            $createTableSQL = "
                CREATE TABLE IF NOT EXISTS `suppliers` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `company_name` VARCHAR(100) NOT NULL,
                    `contact_person` VARCHAR(100) NOT NULL,
                    `email` VARCHAR(100) NOT NULL,
                    `phone` VARCHAR(20) NOT NULL,
                    `address` TEXT NOT NULL,
                    `status` ENUM('Active', 'Inactive', 'Suspended') DEFAULT 'Active',
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ";
            
            $tempConn->exec($createTableSQL);
            
            $createUsersTableSQL = "
                CREATE TABLE IF NOT EXISTS `users` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `username` VARCHAR(50) NOT NULL UNIQUE,
                    `password` VARCHAR(255) NOT NULL,
                    `full_name` VARCHAR(100) NOT NULL,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ";
            
            $tempConn->exec($createUsersTableSQL);
            
            $checkUsers = $tempConn->query("SELECT COUNT(*) as count FROM users");
            $userRow = $checkUsers->fetch(PDO::FETCH_ASSOC);
            
            if ($userRow['count'] == 0) {
                $defaultPassword = password_hash('admin123', PASSWORD_DEFAULT);
                $insertUser = "INSERT INTO users (username, password, full_name) VALUES ('admin', :password, 'Administrator')";
                $userStmt = $tempConn->prepare($insertUser);
                $userStmt->bindParam(':password', $defaultPassword);
                $userStmt->execute();
            }
            
            $tempConn = null;
            
        } catch(PDOException $e) {
            // Silently fail if initialization has issues
            error_log("Database initialization error: " . $e->getMessage());
        }
    }
}
?>

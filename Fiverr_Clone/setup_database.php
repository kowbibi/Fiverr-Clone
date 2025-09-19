<?php
/**
 * Database Setup Script
 * This script creates the database and tables if they don't exist
 */

// Database configuration
$host = 'localhost';
$dbname = 'fiverr_database';
$username = 'root';
$password = '';

try {
    // Connect to MySQL server (without specifying database)
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ Database '$dbname' created or already exists.\n";
    
    // Connect to the specific database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create tables
    $tables = [
        'fiverr_clone_users' => "
            CREATE TABLE IF NOT EXISTS fiverr_clone_users (
                user_id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password TEXT NOT NULL,
                is_client BOOLEAN NOT NULL DEFAULT FALSE,
                is_administrator BOOLEAN NOT NULL DEFAULT FALSE,
                bio_description TEXT,
                display_picture TEXT,
                contact_number VARCHAR(255),
                date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ",
        
        'categories' => "
            CREATE TABLE IF NOT EXISTS categories (
                category_id INT AUTO_INCREMENT PRIMARY KEY,
                category_name VARCHAR(255) NOT NULL,
                category_description TEXT,
                is_active BOOLEAN DEFAULT TRUE,
                date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ",
        
        'subcategories' => "
            CREATE TABLE IF NOT EXISTS subcategories (
                subcategory_id INT AUTO_INCREMENT PRIMARY KEY,
                category_id INT NOT NULL,
                subcategory_name VARCHAR(255) NOT NULL,
                subcategory_description TEXT,
                is_active BOOLEAN DEFAULT TRUE,
                date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ",
        
        'proposals' => "
            CREATE TABLE IF NOT EXISTS proposals (
                proposal_id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                description TEXT NOT NULL,
                image TEXT,
                min_price DECIMAL(10,2) NOT NULL,
                max_price DECIMAL(10,2) NOT NULL,
                category_id INT,
                subcategory_id INT,
                view_count INT DEFAULT 0,
                date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES fiverr_clone_users(user_id) ON DELETE CASCADE,
                FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE SET NULL,
                FOREIGN KEY (subcategory_id) REFERENCES subcategories(subcategory_id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ",
        
        'offers' => "
            CREATE TABLE IF NOT EXISTS offers (
                offer_id INT AUTO_INCREMENT PRIMARY KEY,
                proposal_id INT NOT NULL,
                user_id INT NOT NULL,
                description TEXT NOT NULL,
                offer_date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (proposal_id) REFERENCES proposals(proposal_id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES fiverr_clone_users(user_id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        "
    ];
    
    foreach ($tables as $tableName => $sql) {
        $pdo->exec($sql);
        echo "✅ Table '$tableName' created or already exists.\n";
    }
    
    // Check if we have any categories
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM categories WHERE is_active = TRUE");
    $result = $stmt->fetch();
    
    if ($result['count'] == 0) {
        echo "\n⚠️  No categories found in database.\n";
        echo "Run 'add_sample_categories.php' to add sample categories and subcategories.\n";
    } else {
        echo "\n✅ Found {$result['count']} active categories in database.\n";
    }
    
    echo "\n🎉 Database setup completed successfully!\n";
    
} catch (PDOException $e) {
    echo "❌ Database setup failed: " . $e->getMessage() . "\n";
    exit(1);
}
?>

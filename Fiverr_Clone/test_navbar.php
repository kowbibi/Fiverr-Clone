<?php
/**
 * Test script to verify navbar functionality
 */
require_once 'client/classloader.php';

echo "<h2>Navbar Test Results</h2>";

// Test database connection
try {
    $database = new Database();
    echo "✅ Database connection successful<br>";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
    exit;
}

// Test category retrieval
try {
    $categories = $categoryObj->getCategoriesWithSubcategories();
    echo "✅ Categories retrieved successfully: " . count($categories) . " records<br>";
    
    if (count($categories) > 0) {
        echo "<h3>Sample Categories:</h3>";
        $groupedCategories = [];
        foreach ($categories as $item) {
            $categoryId = $item['category_id'];
            if (!isset($groupedCategories[$categoryId])) {
                $groupedCategories[$categoryId] = [
                    'category_id' => $item['category_id'],
                    'category_name' => $item['category_name'],
                    'subcategories' => []
                ];
            }
            if ($item['subcategory_id']) {
                $groupedCategories[$categoryId]['subcategories'][] = [
                    'subcategory_id' => $item['subcategory_id'],
                    'subcategory_name' => $item['subcategory_name']
                ];
            }
        }
        
        foreach ($groupedCategories as $category) {
            echo "<strong>{$category['category_name']}</strong> (" . count($category['subcategories']) . " subcategories)<br>";
            foreach ($category['subcategories'] as $subcategory) {
                echo "&nbsp;&nbsp;- {$subcategory['subcategory_name']}<br>";
            }
        }
    } else {
        echo "⚠️ No categories found in database<br>";
        echo "<a href='add_sample_categories.php'>Add Sample Categories</a><br>";
    }
    
} catch (Exception $e) {
    echo "❌ Category retrieval failed: " . $e->getMessage() . "<br>";
}

echo "<br><a href='client/index.php'>Go to Client Dashboard</a>";
?>

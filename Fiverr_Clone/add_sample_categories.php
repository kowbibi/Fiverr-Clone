<?php
require_once 'client/classloader.php';

// Check if user is logged in and is an administrator
if (!$userObj->isLoggedIn() || !$userObj->isAdministrator()) {
    echo "You need to be logged in as an administrator to run this script.";
    exit();
}

echo "Adding sample categories and subcategories...\n";

// Sample categories
$categories = [
    ['Web Development', 'Professional web development services'],
    ['Graphic Design', 'Creative graphic design and visual services'],
    ['Digital Marketing', 'Online marketing and advertising services'],
    ['Writing & Translation', 'Content writing and translation services'],
    ['Video & Animation', 'Video production and animation services'],
    ['Music & Audio', 'Music production and audio services'],
    ['Programming & Tech', 'Software development and technical services'],
    ['Business', 'Business consulting and administrative services']
];

// Sample subcategories for each category
$subcategories = [
    'Web Development' => [
        ['WordPress', 'WordPress development and customization'],
        ['E-commerce', 'Online store development'],
        ['Frontend Development', 'HTML, CSS, JavaScript development'],
        ['Backend Development', 'Server-side development'],
        ['Full Stack Development', 'Complete web application development']
    ],
    'Graphic Design' => [
        ['Logo Design', 'Professional logo creation'],
        ['Web Design', 'Website and UI/UX design'],
        ['Print Design', 'Business cards, flyers, brochures'],
        ['Social Media Graphics', 'Social media posts and banners'],
        ['Brand Identity', 'Complete brand identity packages']
    ],
    'Digital Marketing' => [
        ['Social Media Marketing', 'Social media management and promotion'],
        ['SEO', 'Search engine optimization'],
        ['Google Ads', 'Google advertising campaigns'],
        ['Content Marketing', 'Content strategy and creation'],
        ['Email Marketing', 'Email campaign management']
    ],
    'Writing & Translation' => [
        ['Content Writing', 'Blog posts, articles, web content'],
        ['Copywriting', 'Sales and marketing copy'],
        ['Technical Writing', 'Technical documentation'],
        ['Translation', 'Language translation services'],
        ['Proofreading', 'Editing and proofreading services']
    ],
    'Video & Animation' => [
        ['Video Editing', 'Professional video editing'],
        ['2D Animation', '2D animated videos'],
        ['3D Animation', '3D animated content'],
        ['Motion Graphics', 'Animated graphics and titles'],
        ['Video Production', 'Complete video production']
    ],
    'Music & Audio' => [
        ['Music Production', 'Original music composition'],
        ['Audio Editing', 'Audio editing and mixing'],
        ['Voice Over', 'Professional voice over services'],
        ['Podcast Production', 'Podcast editing and production'],
        ['Sound Effects', 'Custom sound effects creation']
    ],
    'Programming & Tech' => [
        ['Mobile App Development', 'iOS and Android app development'],
        ['Desktop Applications', 'Windows, Mac, Linux applications'],
        ['Database Design', 'Database architecture and optimization'],
        ['API Development', 'RESTful API development'],
        ['DevOps', 'Deployment and infrastructure management']
    ],
    'Business' => [
        ['Virtual Assistant', 'Administrative support services'],
        ['Data Entry', 'Data processing and entry'],
        ['Market Research', 'Business and market analysis'],
        ['Business Plans', 'Business plan writing'],
        ['Financial Analysis', 'Financial modeling and analysis']
    ]
];

$categoryIds = [];

// Add categories
foreach ($categories as $category) {
    $categoryId = $categoryObj->createCategory($category[0], $category[1]);
    if ($categoryId) {
        $categoryIds[$category[0]] = $categoryId;
        echo "Added category: {$category[0]}\n";
    } else {
        echo "Failed to add category: {$category[0]}\n";
    }
}

// Add subcategories
foreach ($subcategories as $categoryName => $subcats) {
    if (isset($categoryIds[$categoryName])) {
        $categoryId = $categoryIds[$categoryName];
        foreach ($subcats as $subcat) {
            $result = $subcategoryObj->createSubcategory($categoryId, $subcat[0], $subcat[1]);
            if ($result) {
                echo "Added subcategory: {$subcat[0]} under {$categoryName}\n";
            } else {
                echo "Failed to add subcategory: {$subcat[0]} under {$categoryName}\n";
            }
        }
    }
}

echo "\nSample data addition completed!\n";
echo "You can now test the categories dropdown in the navbar.\n";
?>

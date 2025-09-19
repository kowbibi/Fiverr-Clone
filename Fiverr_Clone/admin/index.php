<?php
require_once '../client/classloader.php';

// Check if user is logged in and is an administrator
if (!$userObj->isLoggedIn() || !$userObj->isAdministrator()) {
    header("Location: ../client/login.php");
    exit();
}

$categories = $categoryObj->getCategoriesWithSubcategories();
$groupedCategories = [];
foreach ($categories as $item) {
    $categoryId = $item['category_id'];
    if (!isset($groupedCategories[$categoryId])) {
        $groupedCategories[$categoryId] = [
            'category_id' => $item['category_id'],
            'category_name' => $item['category_name'],
            'category_description' => $item['category_description'],
            'subcategories' => []
        ];
    }
    if ($item['subcategory_id']) {
        $groupedCategories[$categoryId]['subcategories'][] = [
            'subcategory_id' => $item['subcategory_id'],
            'subcategory_name' => $item['subcategory_name'],
            'subcategory_description' => $item['subcategory_description']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiverr Administrator Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .admin-sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        .admin-sidebar .nav-link {
            color: white;
            padding: 12px 20px;
            margin: 5px 0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .admin-sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        .admin-sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .admin-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        .category-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }
        .category-card:hover {
            transform: translateY(-5px);
        }
        .subcategory-badge {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            margin: 3px;
            display: inline-block;
        }
        .btn-admin {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 admin-sidebar">
                <div class="text-center mb-4">
                    <h4 class="text-white"><i class="fas fa-crown"></i> Admin Panel</h4>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link active" href="index.php">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a class="nav-link" href="categories.php">
                        <i class="fas fa-tags"></i> Manage Categories
                    </a>
                    <a class="nav-link" href="subcategories.php">
                        <i class="fas fa-list"></i> Manage Subcategories
                    </a>
                    <a class="nav-link" href="../client/index.php">
                        <i class="fas fa-users"></i> Client Panel
                    </a>
                    <a class="nav-link" href="../freelancer/index.php">
                        <i class="fas fa-code"></i> Freelancer Panel
                    </a>
                    <a class="nav-link" href="../client/core/handleForms.php?logoutUserBtn=1">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <div class="admin-header">
                    <h2><i class="fas fa-tachometer-alt"></i> Administrator Dashboard</h2>
                    <p class="text-muted">Welcome back, <?php echo $_SESSION['username']; ?>!</p>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-tags"></i> Categories Overview</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php foreach ($groupedCategories as $category): ?>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="category-card card">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <i class="fas fa-folder"></i> <?php echo htmlspecialchars($category['category_name']); ?>
                                                </h6>
                                                <p class="card-text text-muted small">
                                                    <?php echo htmlspecialchars($category['category_description']); ?>
                                                </p>
                                                <div class="mb-2">
                                                    <strong>Subcategories:</strong>
                                                </div>
                                                <div>
                                                    <?php if (empty($category['subcategories'])): ?>
                                                        <span class="text-muted">No subcategories</span>
                                                    <?php else: ?>
                                                        <?php foreach ($category['subcategories'] as $subcategory): ?>
                                                            <span class="subcategory-badge">
                                                                <?php echo htmlspecialchars($subcategory['subcategory_name']); ?>
                                                            </span>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-plus-circle fa-3x text-primary mb-3"></i>
                                <h5>Add New Category</h5>
                                <p class="text-muted">Create a new service category</p>
                                <a href="categories.php" class="btn btn-admin">Manage Categories</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-list fa-3x text-success mb-3"></i>
                                <h5>Manage Subcategories</h5>
                                <p class="text-muted">Add or edit subcategories</p>
                                <a href="subcategories.php" class="btn btn-admin">Manage Subcategories</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

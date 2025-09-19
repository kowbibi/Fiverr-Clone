<?php
require_once '../client/classloader.php';

// Check if user is logged in and is an administrator
if (!$userObj->isLoggedIn() || !$userObj->isAdministrator()) {
    header("Location: ../client/login.php");
    exit();
}

$categories = $categoryObj->getCategories();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_category'])) {
        $category_name = htmlspecialchars(trim($_POST['category_name']));
        $category_description = htmlspecialchars(trim($_POST['category_description']));
        
        if ($categoryObj->createCategory($category_name, $category_description)) {
            $_SESSION['message'] = "Category added successfully!";
            $_SESSION['status'] = '200';
            header("Location: categories.php");
            exit();
        } else {
            $_SESSION['message'] = "Error adding category!";
            $_SESSION['status'] = '400';
        }
    }
    
    if (isset($_POST['update_category'])) {
        $category_id = (int)$_POST['category_id'];
        $category_name = htmlspecialchars(trim($_POST['category_name']));
        $category_description = htmlspecialchars(trim($_POST['category_description']));
        
        if ($categoryObj->updateCategory($category_id, $category_name, $category_description)) {
            $_SESSION['message'] = "Category updated successfully!";
            $_SESSION['status'] = '200';
            header("Location: categories.php");
            exit();
        } else {
            $_SESSION['message'] = "Error updating category!";
            $_SESSION['status'] = '400';
        }
    }
    
    if (isset($_POST['delete_category'])) {
        $category_id = (int)$_POST['category_id'];
        
        if ($categoryObj->deleteCategory($category_id)) {
            $_SESSION['message'] = "Category deleted successfully!";
            $_SESSION['status'] = '200';
            header("Location: categories.php");
            exit();
        } else {
            $_SESSION['message'] = "Error deleting category!";
            $_SESSION['status'] = '400';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - Admin Panel</title>
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
        .btn-danger-admin {
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            border: none;
            color: white;
        }
        .btn-danger-admin:hover {
            background: linear-gradient(45deg, #ff5252, #e53935);
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
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a class="nav-link active" href="categories.php">
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
                    <h2><i class="fas fa-tags"></i> Manage Categories</h2>
                    <p class="text-muted">Add, edit, or delete service categories</p>
                </div>

                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?php echo $_SESSION['status'] == '200' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['message']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['message'], $_SESSION['status']); ?>
                <?php endif; ?>

                <!-- Add Category Form -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-plus"></i> Add New Category</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_name" class="form-label">Category Name</label>
                                        <input type="text" class="form-control" id="category_name" name="category_name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_description" class="form-label">Description</label>
                                        <input type="text" class="form-control" id="category_description" name="category_description" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="add_category" class="btn btn-admin">
                                <i class="fas fa-plus"></i> Add Category
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Categories List -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-list"></i> Existing Categories</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($categories as $category): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="category-card card">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-folder"></i> <?php echo htmlspecialchars($category['category_name']); ?>
                                        </h6>
                                        <p class="card-text text-muted small">
                                            <?php echo htmlspecialchars($category['category_description']); ?>
                                        </p>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $category['category_id']; ?>">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger-admin" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $category['category_id']; ?>">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?php echo $category['category_id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="category_id" value="<?php echo $category['category_id']; ?>">
                                                <div class="mb-3">
                                                    <label for="edit_category_name_<?php echo $category['category_id']; ?>" class="form-label">Category Name</label>
                                                    <input type="text" class="form-control" id="edit_category_name_<?php echo $category['category_id']; ?>" name="category_name" value="<?php echo htmlspecialchars($category['category_name']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_category_description_<?php echo $category['category_id']; ?>" class="form-label">Description</label>
                                                    <input type="text" class="form-control" id="edit_category_description_<?php echo $category['category_id']; ?>" name="category_description" value="<?php echo htmlspecialchars($category['category_description']); ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" name="update_category" class="btn btn-admin">Update Category</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal<?php echo $category['category_id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the category "<?php echo htmlspecialchars($category['category_name']); ?>"?</p>
                                            <p class="text-danger"><strong>This action cannot be undone!</strong></p>
                                        </div>
                                        <form method="POST">
                                            <div class="modal-footer">
                                                <input type="hidden" name="category_id" value="<?php echo $category['category_id']; ?>">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" name="delete_category" class="btn btn-danger-admin">Delete Category</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

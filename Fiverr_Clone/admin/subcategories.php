<?php
require_once '../client/classloader.php';

// Check if user is logged in and is an administrator
if (!$userObj->isLoggedIn() || !$userObj->isAdministrator()) {
    header("Location: ../client/login.php");
    exit();
}

$subcategories = $subcategoryObj->getSubcategories();
$categories = $categoryObj->getCategories();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_subcategory'])) {
        $category_id = (int)$_POST['category_id'];
        $subcategory_name = htmlspecialchars(trim($_POST['subcategory_name']));
        $subcategory_description = htmlspecialchars(trim($_POST['subcategory_description']));
        
        if ($subcategoryObj->createSubcategory($category_id, $subcategory_name, $subcategory_description)) {
            $_SESSION['message'] = "Subcategory added successfully!";
            $_SESSION['status'] = '200';
            header("Location: subcategories.php");
            exit();
        } else {
            $_SESSION['message'] = "Error adding subcategory!";
            $_SESSION['status'] = '400';
        }
    }
    
    if (isset($_POST['update_subcategory'])) {
        $subcategory_id = (int)$_POST['subcategory_id'];
        $category_id = (int)$_POST['category_id'];
        $subcategory_name = htmlspecialchars(trim($_POST['subcategory_name']));
        $subcategory_description = htmlspecialchars(trim($_POST['subcategory_description']));
        
        if ($subcategoryObj->updateSubcategory($subcategory_id, $category_id, $subcategory_name, $subcategory_description)) {
            $_SESSION['message'] = "Subcategory updated successfully!";
            $_SESSION['status'] = '200';
            header("Location: subcategories.php");
            exit();
        } else {
            $_SESSION['message'] = "Error updating subcategory!";
            $_SESSION['status'] = '400';
        }
    }
    
    if (isset($_POST['delete_subcategory'])) {
        $subcategory_id = (int)$_POST['subcategory_id'];
        
        if ($subcategoryObj->deleteSubcategory($subcategory_id)) {
            $_SESSION['message'] = "Subcategory deleted successfully!";
            $_SESSION['status'] = '200';
            header("Location: subcategories.php");
            exit();
        } else {
            $_SESSION['message'] = "Error deleting subcategory!";
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
    <title>Manage Subcategories - Admin Panel</title>
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
        .subcategory-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }
        .subcategory-card:hover {
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
        .category-badge {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8em;
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
                    <a class="nav-link" href="categories.php">
                        <i class="fas fa-tags"></i> Manage Categories
                    </a>
                    <a class="nav-link active" href="subcategories.php">
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
                    <h2><i class="fas fa-list"></i> Manage Subcategories</h2>
                    <p class="text-muted">Add, edit, or delete subcategories for each category</p>
                </div>

                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?php echo $_SESSION['status'] == '200' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['message']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['message'], $_SESSION['status']); ?>
                <?php endif; ?>

                <!-- Add Subcategory Form -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-plus"></i> Add New Subcategory</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Category</label>
                                        <select class="form-select" id="category_id" name="category_id" required>
                                            <option value="">Select a category</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?php echo $category['category_id']; ?>">
                                                    <?php echo htmlspecialchars($category['category_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="subcategory_name" class="form-label">Subcategory Name</label>
                                        <input type="text" class="form-control" id="subcategory_name" name="subcategory_name" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="subcategory_description" class="form-label">Description</label>
                                        <input type="text" class="form-control" id="subcategory_description" name="subcategory_description" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="add_subcategory" class="btn btn-admin">
                                <i class="fas fa-plus"></i> Add Subcategory
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Subcategories List -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-list"></i> Existing Subcategories</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($subcategories as $subcategory): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="subcategory-card card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="card-title">
                                                <i class="fas fa-folder-open"></i> <?php echo htmlspecialchars($subcategory['subcategory_name']); ?>
                                            </h6>
                                            <span class="category-badge">
                                                <?php echo htmlspecialchars($subcategory['category_name']); ?>
                                            </span>
                                        </div>
                                        <p class="card-text text-muted small">
                                            <?php echo htmlspecialchars($subcategory['subcategory_description']); ?>
                                        </p>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $subcategory['subcategory_id']; ?>">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger-admin" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $subcategory['subcategory_id']; ?>">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?php echo $subcategory['subcategory_id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Subcategory</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="subcategory_id" value="<?php echo $subcategory['subcategory_id']; ?>">
                                                <div class="mb-3">
                                                    <label for="edit_category_id_<?php echo $subcategory['subcategory_id']; ?>" class="form-label">Category</label>
                                                    <select class="form-select" id="edit_category_id_<?php echo $subcategory['subcategory_id']; ?>" name="category_id" required>
                                                        <?php foreach ($categories as $category): ?>
                                                            <option value="<?php echo $category['category_id']; ?>" <?php echo $category['category_id'] == $subcategory['category_id'] ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($category['category_name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_subcategory_name_<?php echo $subcategory['subcategory_id']; ?>" class="form-label">Subcategory Name</label>
                                                    <input type="text" class="form-control" id="edit_subcategory_name_<?php echo $subcategory['subcategory_id']; ?>" name="subcategory_name" value="<?php echo htmlspecialchars($subcategory['subcategory_name']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_subcategory_description_<?php echo $subcategory['subcategory_id']; ?>" class="form-label">Description</label>
                                                    <input type="text" class="form-control" id="edit_subcategory_description_<?php echo $subcategory['subcategory_id']; ?>" name="subcategory_description" value="<?php echo htmlspecialchars($subcategory['subcategory_description']); ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" name="update_subcategory" class="btn btn-admin">Update Subcategory</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal<?php echo $subcategory['subcategory_id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete Subcategory</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the subcategory "<?php echo htmlspecialchars($subcategory['subcategory_name']); ?>"?</p>
                                            <p class="text-danger"><strong>This action cannot be undone!</strong></p>
                                        </div>
                                        <form method="POST">
                                            <div class="modal-footer">
                                                <input type="hidden" name="subcategory_id" value="<?php echo $subcategory['subcategory_id']; ?>">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" name="delete_subcategory" class="btn btn-danger-admin">Delete Subcategory</button>
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

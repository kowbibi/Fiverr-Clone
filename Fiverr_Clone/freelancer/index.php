<?php require_once 'classloader.php'; ?>
<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if ($userObj->isAdmin()) {
  header("Location: ../client/index.php");
} 

// Handle category filtering
$selectedCategory = isset($_GET['category']) ? (int)$_GET['category'] : null;
if ($selectedCategory) {
    $getProposals = $proposalObj->executeQuery("SELECT p.*, u.*, c.category_name, s.subcategory_name,
        p.date_added AS proposals_date_added
        FROM Proposals p 
        JOIN fiverr_clone_users u ON p.user_id = u.user_id
        LEFT JOIN categories c ON p.category_id = c.category_id
        LEFT JOIN subcategories s ON p.subcategory_id = s.subcategory_id
        WHERE p.subcategory_id = ?
        ORDER BY p.date_added DESC", [$selectedCategory]);
} else {
    $getProposals = $proposalObj->getProposals();
}

// Get categories for the form
$categories = $categoryObj->getCategories();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Freelancer Dashboard - Fiverr Clone</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .hero-section {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
        }
        .proposal-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 30px;
            overflow: hidden;
        }
        .proposal-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .proposal-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        .category-badge {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            display: inline-block;
            margin-bottom: 10px;
        }
        .price-tag {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: 600;
            display: inline-block;
        }
        .btn-modern {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
            color: white;
        }
        .alert-modern {
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 30px;
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="fas fa-code"></i> Welcome back, <?php echo $_SESSION['username']; ?>!
                </h1>
                <p class="lead">Create amazing proposals and showcase your skills to potential clients.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Alert Messages -->
        <?php if (isset($_SESSION['message']) && isset($_SESSION['status'])): ?>
            <div class="alert alert-<?php echo $_SESSION['status'] == '200' ? 'success' : 'danger'; ?> alert-modern alert-dismissible fade show" role="alert">
                <i class="fas fa-<?php echo $_SESSION['status'] == '200' ? 'check-circle' : 'exclamation-triangle'; ?>"></i>
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['status']); ?>
        <?php endif; ?>

        <div class="row">
            <!-- Add Proposal Form -->
            <div class="col-lg-5">
                <div class="form-card">
                    <h3 class="mb-4">
                        <i class="fas fa-plus-circle"></i> Create New Proposal
                    </h3>
                    
                    <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required placeholder="Describe your service..."></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="min_price" class="form-label">Minimum Price (₱)</label>
                                    <input type="number" class="form-control" id="min_price" name="min_price" required placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_price" class="form-label">Maximum Price (₱)</label>
                                    <input type="number" class="form-control" id="max_price" name="max_price" required placeholder="0">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id" onchange="loadSubcategories(this.value)">
                                <option value="">Select a category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['category_id']; ?>">
                                        <?php echo htmlspecialchars($category['category_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="subcategory_id" class="form-label">Subcategory</label>
                            <select class="form-select" id="subcategory_id" name="subcategory_id">
                                <option value="">Select a subcategory</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Service Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            <div class="form-text">Upload an image that represents your service</div>
                        </div>
                        
                        <button type="submit" class="btn btn-modern w-100" name="insertNewProposalBtn">
                            <i class="fas fa-rocket"></i> Create Proposal
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Proposals List -->
            <div class="col-lg-7">
                <h4 class="mb-4">
                    <i class="fas fa-briefcase"></i> All Proposals
                    <span class="badge bg-success ms-2"><?php echo count($getProposals); ?></span>
                </h4>
                
                <?php foreach ($getProposals as $proposal): ?>
                <div class="proposal-card card">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?php echo '../images/' . $proposal['image']; ?>" 
                                 class="proposal-image" 
                                 alt="Proposal Image"
                                 onerror="this.src='https://via.placeholder.com/400x200/28a745/ffffff?text=Proposal+Image'">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title">
                                        <a href="other_profile_view.php?user_id=<?php echo $proposal['user_id']; ?>" class="text-decoration-none">
                                            <i class="fas fa-user"></i> <?php echo htmlspecialchars($proposal['username']); ?>
                                        </a>
                                    </h5>
                                    <small class="text-muted">
                                        <i class="fas fa-eye"></i> <?php echo $proposal['view_count']; ?> views
                                    </small>
                                </div>
                                
                                <?php if ($proposal['category_name'] || $proposal['subcategory_name']): ?>
                                    <div class="mb-2">
                                        <?php if ($proposal['category_name']): ?>
                                            <span class="category-badge">
                                                <i class="fas fa-tag"></i> <?php echo htmlspecialchars($proposal['category_name']); ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($proposal['subcategory_name']): ?>
                                            <span class="category-badge ms-1">
                                                <i class="fas fa-list"></i> <?php echo htmlspecialchars($proposal['subcategory_name']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <p class="card-text text-muted">
                                    <?php echo htmlspecialchars($proposal['description']); ?>
                                </p>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price-tag">
                                        <i class="fas fa-peso-sign"></i> <?php echo number_format($proposal['min_price']) . " - " . number_format($proposal['max_price']); ?>
                                    </span>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> <?php echo date('M j, Y', strtotime($proposal['proposals_date_added'])); ?>
                                    </small>
                                </div>
                                
                                <div class="mt-3">
                                    <a href="#" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-eye"></i> View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    
    <script>
        function loadSubcategories(categoryId) {
            if (categoryId) {
                $.ajax({
                    url: 'get_subcategories.php',
                    method: 'GET',
                    data: { category_id: categoryId },
                    dataType: 'json',
                    success: function(data) {
                        var subcategorySelect = $('#subcategory_id');
                        subcategorySelect.empty();
                        subcategorySelect.append('<option value="">Select a subcategory</option>');
                        
                        $.each(data, function(index, subcategory) {
                            subcategorySelect.append('<option value="' + subcategory.subcategory_id + '">' + subcategory.subcategory_name + '</option>');
                        });
                    }
                });
            } else {
                $('#subcategory_id').empty().append('<option value="">Select a subcategory</option>');
            }
        }
    </script>
</body>
</html>
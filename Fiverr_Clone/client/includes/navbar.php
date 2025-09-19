<?php
// Get categories with subcategories for navbar with error handling
$groupedCategories = [];
try {
    $categories = $categoryObj->getCategoriesWithSubcategories();
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
} catch (Exception $e) {
    // If there's a database error, set empty array to prevent navbar from breaking
    $groupedCategories = [];
    error_log("Navbar categories error: " . $e->getMessage());
}
?>

<style>
  /* Mega menu styling */
  .mega-menu {
    width: 100%;
    max-width: 1000px;
    padding: 15px;
    border-radius: 8px;
  }
  .mega-menu .dropdown-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
    transition: all 0.2s ease;
  }
  .mega-menu .dropdown-header {
    border-left: 3px solid #1dbf73;
  }
  @media (max-width: 768px) {
    .mega-menu {
      max-width: 100%;
    }
  }
</style>


<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary" href="index.php">
      <i class="fas fa-rocket"></i> Fiverr Clone
    </a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Categories Dropdown -->
      <ul class="navbar-nav me-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-semibold" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-th-large"></i> Categories
          </a>
          <ul class="dropdown-menu mega-menu shadow-lg border-0" aria-labelledby="categoriesDropdown">
            <div class="container-fluid p-3">
              <div class="row">
                <?php if (empty($groupedCategories)): ?>
                  <div class="col-12 text-center py-4">
                    <p class="text-muted mb-0">
                      <i class="fas fa-info-circle"></i> No categories available yet.
                    </p>
                    <small class="text-muted">Contact administrator to add categories.</small>
                    <div class="mt-3">
                      <a href="../admin/categories.php" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus"></i> Add Categories
                      </a>
                    </div>
                  </div>
                <?php else: ?>
                  <!-- View All Option -->
                  <div class="col-12 mb-3">
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item fw-bold text-primary" href="index.php">
                      <i class="fas fa-th"></i> View All Proposals
                    </a>
                    <div class="dropdown-divider"></div>
                  </div>
                  
                  <?php foreach ($groupedCategories as $category): ?>
                  <div class="col-md-3 col-sm-6 mb-3">
                    <h6 class="dropdown-header bg-light rounded p-2 text-primary fw-bold">
                      <a href="index.php?category=<?php echo $category['category_id']; ?>" class="text-decoration-none text-primary d-block">
                        <i class="fas fa-folder me-2"></i> <?php echo htmlspecialchars($category['category_name']); ?>
                      </a>
                    </h6>
                    <div class="ps-3 mt-2">
                      <?php if (!empty($category['subcategories'])): ?>
                        <?php foreach ($category['subcategories'] as $subcategory): ?>
                          <a class="dropdown-item py-2 border-bottom border-light" href="index.php?subcategory=<?php echo $subcategory['subcategory_id']; ?>">
                            <i class="fas fa-chevron-right me-2 text-muted"></i> <?php echo htmlspecialchars($subcategory['subcategory_name']); ?>
                          </a>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <span class="dropdown-item-text text-muted py-2">
                          <i class="fas fa-exclamation-circle me-2"></i> No subcategories
                        </span>
                      <?php endif; ?>
                    </div>
                  </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </div>
          </ul>
        </li>
      </ul>

      <!-- Right side navigation -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="project_offers_submitted.php">
            <i class="fas fa-briefcase"></i> My Offers
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php">
            <i class="fas fa-user"></i> Profile
          </a>
        </li>
        <?php if (isset($_SESSION['is_administrator']) && $_SESSION['is_administrator']): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-crown"></i> Admin
          </a>
          <ul class="dropdown-menu" aria-labelledby="adminDropdown">
            <li><a class="dropdown-item" href="../admin/index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a class="dropdown-item" href="../admin/categories.php"><i class="fas fa-tags"></i> Categories</a></li>
            <li><a class="dropdown-item" href="../admin/subcategories.php"><i class="fas fa-list"></i> Subcategories</a></li>
          </ul>
        </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link text-danger" href="core/handleForms.php?logoutUserBtn=1">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<style>
.mega-menu {
  width: 100%;
  max-width: 900px;
  left: 50%;
  transform: translateX(-50%);
  border: none;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  border-radius: 10px;
  padding: 20px;
  z-index: 1050;
  position: absolute;
  top: 100%;
  max-height: 80vh;
  overflow-y: auto;
}

@media (max-width: 768px) {
  .mega-menu {
    max-width: 95%;
    padding: 15px;
    max-height: 70vh;
  }
}

.mega-menu .dropdown-item {
  padding: 8px 15px;
  border-radius: 5px;
  transition: all 0.3s ease;
}

.mega-menu .dropdown-item:hover {
  background-color: #f8f9fa;
  color: #007bff;
}

.navbar-brand {
  font-size: 1.5rem;
}

.nav-link {
  font-weight: 500;
  color: #333 !important;
  transition: color 0.3s ease;
}

.nav-link:hover {
  color: #007bff !important;
}

.navbar {
  position: relative;
  z-index: 1030;
}

.dropdown-menu {
  z-index: 1050;
}

.dropdown:hover .dropdown-menu {
  display: block;
}

.nav-item.dropdown {
  position: static;
}

.dropdown-header {
  border-bottom: 2px solid #007bff;
  margin-bottom: 10px;
  padding-bottom: 5px;
}

.mega-menu .dropdown-item:hover {
  background: linear-gradient(45deg, #f8f9fa, #e9ecef);
  color: #007bff;
  transform: translateX(5px);
}

.mega-menu .dropdown-item i {
  margin-right: 8px;
  width: 12px;
  text-align: center;
}

.dropdown-toggle::after {
  margin-left: 8px;
}

.nav-item.dropdown:hover .dropdown-menu {
  display: block;
  animation: fadeInDown 0.3s ease;
}

@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateX(-50%) translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
  }
}
</style>


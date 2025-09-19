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

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-success" href="index.php">
      <i class="fas fa-code"></i> Fiverr Clone
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
          <ul class="dropdown-menu mega-menu" aria-labelledby="categoriesDropdown">
            <div class="container-fluid">
              <div class="row">
                <?php foreach ($groupedCategories as $category): ?>
                <div class="col-md-3">
                  <h6 class="dropdown-header text-success fw-bold">
                    <i class="fas fa-folder"></i> <?php echo htmlspecialchars($category['category_name']); ?>
                  </h6>
                  <?php if (!empty($category['subcategories'])): ?>
                    <?php foreach ($category['subcategories'] as $subcategory): ?>
                      <a class="dropdown-item" href="index.php?category=<?php echo $subcategory['subcategory_id']; ?>">
                        <i class="fas fa-chevron-right"></i> <?php echo htmlspecialchars($subcategory['subcategory_name']); ?>
                      </a>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <span class="dropdown-item-text text-muted">No subcategories</span>
                  <?php endif; ?>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
          </ul>
        </li>
      </ul>

      <!-- Right side navigation -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">
            <i class="fas fa-home"></i> Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="your_proposals.php">
            <i class="fas fa-file-alt"></i> My Proposals
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="offers_from_clients.php">
            <i class="fas fa-handshake"></i> Client Offers
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
  max-width: 800px;
  left: 50%;
  transform: translateX(-50%);
  border: none;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  border-radius: 10px;
  padding: 20px;
  z-index: 1050;
  position: absolute;
  top: 100%;
}

.mega-menu .dropdown-item {
  padding: 8px 15px;
  border-radius: 5px;
  transition: all 0.3s ease;
}

.mega-menu .dropdown-item:hover {
  background-color: #f8f9fa;
  color: #28a745;
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
  color: #28a745 !important;
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
  border-bottom: 2px solid #28a745;
  margin-bottom: 10px;
  padding-bottom: 5px;
}
</style>
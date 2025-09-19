<?php require_once 'classloader.php'; ?>
<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if (!$userObj->isAdmin()) {
  header("Location: ../freelancer/index.php");
} 

// Handle category filtering
$selectedCategory = isset($_GET['category']) ? (int)$_GET['category'] : null;
$selectedSubcategory = isset($_GET['subcategory']) ? (int)$_GET['subcategory'] : null;

if ($selectedSubcategory) {
    // Filter by subcategory
    $getProposals = $proposalObj->getProposalsBySubcategory($selectedSubcategory);
} elseif ($selectedCategory) {
    // Filter by category
    $getProposals = $proposalObj->getProposalsByCategory($selectedCategory);
} else {
    // Show all proposals
    $getProposals = $proposalObj->getProposals();
}
?>
<!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Client Dashboard - Fiverr Clone</title>
    
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: linear-gradient(45deg, #667eea, #764ba2);
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
        .offers-section {
            background: #f8f9fa;
            border-radius: 10px;
            max-height: 500px;
            overflow-y: auto;
        }
        .offer-item {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid #007bff;
        }
        .btn-modern {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .alert-modern {
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
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
                    <i class="fas fa-rocket"></i> Welcome back, <?php echo $_SESSION['username']; ?>!
                </h1>
                <p class="lead">Discover amazing services and submit your offers. Double-click on offers to edit them.</p>
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

        <!-- Proposals Grid -->
        <div class="row">
            <?php foreach ($getProposals as $proposal): ?>
            <div class="col-lg-6">
                <div class="proposal-card card">
                    <div class="row g-0">
                        <div class="col-md-6">
                            <img src="<?php echo !empty($proposal['image']) ? '../images/'.$proposal['image'] : 'https://via.placeholder.com/400x200/007bff/ffffff?text=Proposal+Image'; ?>" 
                                 class="proposal-image" 
                                 alt="Proposal Image"
                                 loading="lazy">
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title">
                                        <a href="other_profile_view.php?user_id=<?php echo $proposal['user_id'] ?>" class="text-decoration-none">
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
                                
                                <p class="card-text text-muted small">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
      </div>

        <!-- Detailed Proposals with Offers -->
        <?php foreach ($getProposals as $proposal): ?>
        <div class="proposal-card card mb-4">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <img src="<?php echo '../images/'.$proposal['image']; ?>" 
                                 class="rounded me-3" 
                                 style="width: 80px; height: 80px; object-fit: cover;" 
                                 alt="Proposal Image"
                                 onerror="this.src='https://via.placeholder.com/80x80/007bff/ffffff?text=IMG'">
                            <div>
                                <h4 class="mb-1">
                                    <a href="other_profile_view.php?user_id=<?php echo $proposal['user_id'] ?>" class="text-decoration-none">
                                        <?php echo htmlspecialchars($proposal['username']); ?>
                                    </a>
                                </h4>
                                <p class="text-muted mb-0"><?php echo htmlspecialchars($proposal['description']); ?></p>
                                <span class="price-tag">
                                    <i class="fas fa-peso-sign"></i> <?php echo number_format($proposal['min_price']) . " - " . number_format($proposal['max_price']); ?>
                                </span>
                            </div>
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="offers-section p-3">
                            <h5 class="mb-3">
                                <i class="fas fa-comments"></i> All Offers
                                <span class="badge bg-primary ms-2"><?php echo count($offerObj->getOffersByProposalID($proposal['proposal_id'])); ?></span>
                            </h5>
                            
                            <div class="offers-list">
                      <?php $getOffersByProposalID = $offerObj->getOffersByProposalID($proposal['proposal_id']); ?>
                                <?php foreach ($getOffersByProposalID as $offer): ?>
                                <div class="offer-item offer">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="mb-0">
                                            <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($offer['username']); ?>
                                            <span class="text-primary">(<?php echo htmlspecialchars($offer['contact_number']); ?>)</span>
                                        </h6>
                                        <small class="text-muted">
                                            <i class="fas fa-clock"></i> <?php echo date('M j, Y g:i A', strtotime($offer['offer_date_added'])); ?>
                                        </small>
                            </div>
                                    <p class="mb-2"><?php echo htmlspecialchars($offer['description']); ?></p>

                                    <?php if ($offer['user_id'] == $_SESSION['user_id']): ?>
                                        <div class="d-flex gap-2">
                                            <form action="core/handleForms.php" method="POST" class="d-inline">
                                                <input type="hidden" name="offer_id" value="<?php echo $offer['offer_id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" name="deleteOfferBtn">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                          </form>

                                            <form action="core/handleForms.php" method="POST" class="updateOfferForm d-none d-inline">
                                                <input type="hidden" name="offer_id" value="<?php echo $offer['offer_id']; ?>">
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control" name="description" value="<?php echo htmlspecialchars($offer['description']); ?>">
                                                    <button type="submit" class="btn btn-sm btn-primary" name="updateOfferBtn">
                                                        <i class="fas fa-save"></i> Save
                                                    </button>
                            </div>
                          </form>
                                        </div>
                                    <?php endif; ?>
                      </div>
                                <?php endforeach; ?>
                    </div>
                            
                            <div class="mt-3">
                                <?php 
                                $hasUserSubmittedOffer = $offerObj->hasUserSubmittedOffer($_SESSION['user_id'], $proposal['proposal_id']);
                                ?>
                                <?php if ($hasUserSubmittedOffer): ?>
                                    <div class="alert alert-info d-flex align-items-center" role="alert">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <span>You have already submitted an offer for this proposal.</span>
                                    </div>
                                <?php else: ?>
                                    <form action="core/handleForms.php" method="POST">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="description" placeholder="Write your offer..." required>
                                            <input type="hidden" name="proposal_id" value="<?php echo $proposal['proposal_id']; ?>">
                                            <button type="submit" class="btn btn-modern" name="insertOfferBtn">
                                                <i class="fas fa-paper-plane"></i> Submit Offer
                                            </button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    
    <script>
       $('.offer').on('dblclick', function (event) {
          var updateOfferForm = $(this).find('.updateOfferForm');
          updateOfferForm.toggleClass('d-none');
        });
    </script>
  </body>
</html>
<?php require_once 'classloader.php'; ?>
<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if ($userObj->isAdmin()) {
  header("Location: ../client/index.php");
}  
?>
<!doctype html>
  <html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <style>
      body {
        font-family: 'Inter', sans-serif;
        background-color: #f8f9fa;
      }
      .offer-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 30px;
        overflow: hidden;
      }
      .offer-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
      }
      .proposal-image {
        border-radius: 10px;
        object-fit: cover;
        height: 200px;
        width: 100%;
      }
      .price-badge {
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 600;
        display: inline-block;
      }
      .offer-item {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
        border-left: 4px solid #28a745;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
      }
      .offer-item:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transform: translateX(5px);
      }
      .offer-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 15px;
      }
      .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(45deg, #28a745, #20c997);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        margin-right: 15px;
      }
      .section-title {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 30px;
        text-align: center;
      }
      .offers-container {
        max-height: 400px;
        overflow-y: auto;
        padding-right: 10px;
      }
      .offers-container::-webkit-scrollbar {
        width: 6px;
      }
      .offers-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
      }
      .offers-container::-webkit-scrollbar-thumb {
        background: #28a745;
        border-radius: 10px;
      }
      .offers-container::-webkit-scrollbar-thumb:hover {
        background: #20c997;
      }
    </style>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid py-4">
      <div class="section-title">
        <h1 class="display-5 fw-bold mb-0">
          <i class="fas fa-handshake me-3"></i>Client Offers Dashboard
        </h1>
        <p class="lead mb-0">Manage and respond to client offers for your proposals</p>
      </div>
      
      <div class="row justify-content-center">
        <div class="col-12">
          <?php $getProposalsByUserID = $proposalObj->getProposalsByUserID($_SESSION['user_id']); ?>
          <?php if (empty($getProposalsByUserID)): ?>
            <div class="text-center py-5">
              <div class="mb-4">
                <i class="fas fa-inbox fa-4x text-muted"></i>
              </div>
              <h3 class="text-muted">No Proposals Yet</h3>
              <p class="text-muted">Create your first proposal to start receiving offers from clients.</p>
              <a href="index.php" class="btn btn-success btn-lg">
                <i class="fas fa-plus me-2"></i>Create Proposal
              </a>
            </div>
          <?php else: ?>
            <?php foreach ($getProposalsByUserID as $proposal) { ?>
            <div class="offer-card card">
              <div class="card-body p-4">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center mb-3">
                      <div class="user-avatar">
                        <?php echo strtoupper(substr($proposal['username'], 0, 2)); ?>
                      </div>
                      <div>
                        <h3 class="mb-1">
                          <a href="#" class="text-decoration-none text-dark">
                            <?php echo htmlspecialchars($proposal['username']); ?>
                          </a>
                        </h3>
                        <small class="text-muted">
                          <i class="fas fa-clock me-1"></i>
                          Posted <?php echo date('M j, Y', strtotime($proposal['date_added'] ?? 'now')); ?>
                        </small>
                      </div>
                    </div>
                    
                    <img src="<?php echo '../images/'.$proposal['image']; ?>" 
                         class="proposal-image mb-4" 
                         alt="Proposal Image"
                         onerror="this.src='https://via.placeholder.com/400x200/28a745/ffffff?text=Proposal+Image'">
                    
                    <p class="text-muted mb-4"><?php echo htmlspecialchars($proposal['description']); ?></p>
                    
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="price-badge">
                        <i class="fas fa-tag me-2"></i>
                        ₱<?php echo number_format($proposal['min_price']); ?> - ₱<?php echo number_format($proposal['max_price']); ?>
                      </div>
                      <a href="#" class="btn btn-outline-success">
                        <i class="fas fa-external-link-alt me-2"></i>View Details
                      </a>
                    </div>
                  </div>
                  
                  <div class="col-lg-6">
                    <div class="card border-0 bg-light">
                      <div class="card-header bg-success text-white border-0">
                        <h4 class="mb-0">
                          <i class="fas fa-comments me-2"></i>Client Offers
                          <span class="badge bg-light text-success ms-2">
                            <?php echo count($offerObj->getOffersByProposalID($proposal['proposal_id'])); ?>
                          </span>
                        </h4>
                      </div>
                      <div class="card-body p-0">
                        <div class="offers-container p-3">
                          <?php $getOffersByProposalID = $offerObj->getOffersByProposalID($proposal['proposal_id']); ?>
                          <?php if (empty($getOffersByProposalID)): ?>
                            <div class="text-center py-4">
                              <i class="fas fa-inbox fa-2x text-muted mb-3"></i>
                              <p class="text-muted">No offers yet</p>
                            </div>
                          <?php else: ?>
                            <?php foreach ($getOffersByProposalID as $offer) { ?>
                            <div class="offer-item">
                              <div class="d-flex align-items-center mb-3">
                                <div class="user-avatar me-3">
                                  <?php echo strtoupper(substr($offer['username'], 0, 2)); ?>
                                </div>
                                <div class="flex-grow-1">
                                  <h6 class="mb-1 fw-bold">
                                    <?php echo htmlspecialchars($offer['username']); ?>
                                    <span class="text-success ms-2">
                                      <i class="fas fa-phone me-1"></i>
                                      <?php echo htmlspecialchars($offer['contact_number']); ?>
                                    </span>
                                  </h6>
                                  <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    <?php echo date('M j, Y g:i A', strtotime($offer['offer_date_added'])); ?>
                                  </small>
                                </div>
                              </div>
                              <p class="mb-0"><?php echo htmlspecialchars($offer['description']); ?></p>
                            </div>
                            <?php } ?>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
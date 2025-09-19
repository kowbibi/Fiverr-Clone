<?php require_once 'classloader.php'; ?>
<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if (!$userObj->isAdmin()) {
  header("Location: ../freelancer/index.php");
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
      .section-title {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        text-align: center;
      }
      .welcome-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        background: white;
        padding: 40px;
        text-align: center;
      }
      .feature-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(45deg, #007bff, #0056b3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: white;
        font-size: 2rem;
      }
    </style>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid py-4">
      <div class="section-title">
        <h1 class="display-5 fw-bold mb-0">
          <i class="fas fa-briefcase me-3"></i>Project Offers Dashboard
        </h1>
        <p class="lead mb-0">Manage and track all your submitted project offers</p>
      </div>
      
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="welcome-card">
            <div class="feature-icon">
              <i class="fas fa-chart-line"></i>
            </div>
            <h2 class="mb-3">Welcome to Your Offers Dashboard!</h2>
            <p class="lead text-muted mb-4">
              This is where you can view and manage all the project offers you've submitted to freelancers. 
              Track responses, manage communications, and stay organized with your freelance projects.
            </p>
            <div class="row text-center">
              <div class="col-md-4 mb-3">
                <div class="p-3">
                  <i class="fas fa-paper-plane fa-2x text-primary mb-2"></i>
                  <h5>Submit Offers</h5>
                  <p class="text-muted small">Send project offers to talented freelancers</p>
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <div class="p-3">
                  <i class="fas fa-comments fa-2x text-success mb-2"></i>
                  <h5>Track Responses</h5>
                  <p class="text-muted small">Monitor responses and communications</p>
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <div class="p-3">
                  <i class="fas fa-handshake fa-2x text-warning mb-2"></i>
                  <h5>Manage Projects</h5>
                  <p class="text-muted small">Organize and track project progress</p>
                </div>
              </div>
            </div>
            <div class="mt-4">
              <a href="index.php" class="btn btn-primary btn-lg me-3">
                <i class="fas fa-search me-2"></i>Browse Freelancers
              </a>
              <a href="profile.php" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-user me-2"></i>View Profile
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
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
      .profile-header {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 40px 0;
        margin-bottom: 30px;
      }
      .profile-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 30px;
        overflow: hidden;
      }
      .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
      }
      .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      }
      .profile-info {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
      }
      .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 10px;
        transition: all 0.3s ease;
      }
      .info-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
      }
      .info-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(45deg, #28a745, #20c997);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 15px;
      }
      .form-control {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 12px 15px;
        transition: all 0.3s ease;
      }
      .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
      }
      .btn-update {
        background: linear-gradient(45deg, #28a745, #20c997);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
      }
      .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        color: white;
      }
      .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        background: linear-gradient(45deg, #007bff, #0056b3);
        color: white;
        padding: 10px 20px;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
      }
      .file-input-wrapper:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
      }
      .file-input-wrapper input[type=file] {
        position: absolute;
        left: -9999px;
      }
      .alert {
        border-radius: 10px;
        border: none;
      }
    </style>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <?php $userInfo = $userObj->getUsers($_SESSION['user_id']); ?>
    <!-- Profile Header -->
    <div class="profile-header">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-3 text-center">
            <img src="<?php echo !empty($userInfo['display_picture']) ? '../images/'.$userInfo['display_picture'] : 'https://via.placeholder.com/150x150/28a745/ffffff?text='.strtoupper(substr($userInfo['username'], 0, 2)); ?>" 
                 class="profile-image" alt="Profile Picture">
          </div>
          <div class="col-md-9">
            <h1 class="display-4 fw-bold mb-2">
              <i class="fas fa-code me-3"></i>Welcome, <?php echo htmlspecialchars($userInfo['username']); ?>!
            </h1>
            <p class="lead mb-0">Manage your freelancer profile and showcase your skills</p>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <!-- Success/Error Messages -->
      <?php if (isset($_SESSION['message']) && isset($_SESSION['status'])): ?>
        <div class="alert alert-<?php echo $_SESSION['status'] == "200" ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
          <i class="fas fa-<?php echo $_SESSION['status'] == "200" ? 'check-circle' : 'exclamation-triangle'; ?> me-2"></i>
          <?php echo htmlspecialchars($_SESSION['message']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php 
        unset($_SESSION['message']);
        unset($_SESSION['status']);
        ?>
      <?php endif; ?>

      <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-4">
          <div class="profile-info">
            <h3 class="mb-4">
              <i class="fas fa-info-circle me-2"></i>Profile Information
            </h3>
            
            <div class="info-item">
              <div class="info-icon">
                <i class="fas fa-user"></i>
              </div>
              <div>
                <strong>Username</strong><br>
                <span class="text-muted"><?php echo htmlspecialchars($userInfo['username']); ?></span>
              </div>
            </div>
            
            <div class="info-item">
              <div class="info-icon">
                <i class="fas fa-envelope"></i>
              </div>
              <div>
                <strong>Email</strong><br>
                <span class="text-muted"><?php echo htmlspecialchars($userInfo['email']); ?></span>
              </div>
            </div>
            
            <div class="info-item">
              <div class="info-icon">
                <i class="fas fa-phone"></i>
              </div>
              <div>
                <strong>Phone Number</strong><br>
                <span class="text-muted"><?php echo htmlspecialchars($userInfo['contact_number']); ?></span>
              </div>
            </div>
            
            <?php if (!empty($userInfo['bio_description'])): ?>
            <div class="info-item">
              <div class="info-icon">
                <i class="fas fa-quote-left"></i>
              </div>
              <div>
                <strong>Bio</strong><br>
                <span class="text-muted"><?php echo htmlspecialchars($userInfo['bio_description']); ?></span>
              </div>
            </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Edit Profile Form -->
        <div class="col-lg-8">
          <div class="profile-card card">
            <div class="card-header bg-success text-white">
              <h3 class="mb-0">
                <i class="fas fa-edit me-2"></i>Edit Profile
              </h3>
            </div>
            <div class="card-body p-4">
              <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                      <i class="fas fa-user me-2"></i>Username
                    </label>
                    <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($userInfo['username']); ?>" disabled>
                    <small class="text-muted">Username cannot be changed</small>
                  </div>
                  
                  <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                      <i class="fas fa-envelope me-2"></i>Email
                    </label>
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($userInfo['email']); ?>" disabled>
                    <small class="text-muted">Email cannot be changed</small>
                  </div>
                </div>
                
                <div class="mb-3">
                  <label class="form-label fw-bold">
                    <i class="fas fa-phone me-2"></i>Contact Number
                  </label>
                  <input type="text" class="form-control" name="contact_number" value="<?php echo htmlspecialchars($userInfo['contact_number']); ?>" required>
                </div>
                
                <div class="mb-3">
                  <label class="form-label fw-bold">
                    <i class="fas fa-quote-left me-2"></i>Bio Description
                  </label>
                  <textarea name="bio_description" class="form-control" rows="4" placeholder="Tell clients about your skills and experience..."><?php echo htmlspecialchars($userInfo['bio_description']); ?></textarea>
                </div>
                
                <div class="mb-4">
                  <label class="form-label fw-bold">
                    <i class="fas fa-image me-2"></i>Display Picture
                  </label>
                  <div class="file-input-wrapper">
                    <i class="fas fa-upload me-2"></i>Choose New Picture
                    <input type="file" name="display_picture" accept="image/*">
                  </div>
                  <small class="text-muted d-block mt-2">Upload a new profile picture (JPG, PNG, GIF)</small>
                </div>
                
                <div class="text-end">
                  <button type="submit" class="btn-update" name="updateUserBtn">
                    <i class="fas fa-save me-2"></i>Update Profile
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
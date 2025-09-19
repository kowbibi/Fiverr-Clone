<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Fiverr Clone - Find Freelance Services & Work</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
        }
        .service-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 30px;
            overflow: hidden;
        }
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .btn-hero {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            color: white;
            padding: 15px 30px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
            color: white;
        }
        .btn-outline-hero {
            border: 2px solid white;
            color: white;
            padding: 15px 30px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-outline-hero:hover {
            background: white;
            color: #667eea;
        }
        .testimonial-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 30px;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }
        .testimonial-card:hover {
            transform: translateY(-5px);
        }
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #667eea, #764ba2);
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
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">
                <i class="fas fa-rocket"></i> Fiverr Clone
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">
                        Find the Perfect Freelance Services for Your Business
                    </h1>
                    <p class="lead mb-4">
                        Connect with talented freelancers who can help you bring your ideas to life. 
                        From web development to graphic design, find the right skills for your project.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="client/login.php" class="btn btn-hero">
                            <i class="fas fa-search"></i> Find Services
                        </a>
                        <a href="freelancer/login.php" class="btn btn-outline-hero">
                            <i class="fas fa-code"></i> Start Freelancing
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://via.placeholder.com/600x400/667eea/ffffff?text=Freelance+Services" 
                         class="img-fluid rounded-3 shadow" alt="Freelance Services">
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Choose Your Path</h2>
                <p class="lead text-muted">Whether you're looking for services or offering them, we've got you covered</p>
            </div>
            
            <div class="row">
                <div class="col-lg-6">
                    <div class="service-card card h-100">
                        <div class="card-body text-center p-5">
                            <div class="feature-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3 class="card-title mb-3">Looking for Talent?</h3>
                            <img src="https://via.placeholder.com/400x300/28a745/ffffff?text=Find+Talent" 
                                 class="img-fluid rounded mb-4" alt="Client Services">
                            <p class="card-text text-muted mb-4">
                                Discover talented freelancers who can help bring your projects to life. 
                                From web development to graphic design, find the perfect match for your needs.
                            </p>
                            <a href="client/login.php" class="btn btn-hero w-100">
                                <i class="fas fa-arrow-right"></i> Get Started as Client
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="service-card card h-100">
                        <div class="card-body text-center p-5">
                            <div class="feature-icon">
                                <i class="fas fa-code"></i>
                            </div>
                            <h3 class="card-title mb-3">Offering Services?</h3>
                            <img src="https://via.placeholder.com/400x300/20c997/ffffff?text=Offer+Services" 
                                 class="img-fluid rounded mb-4" alt="Freelancer Services">
                            <p class="card-text text-muted mb-4">
                                Showcase your skills and connect with clients who need your expertise. 
                                Build your portfolio and grow your freelance business.
                            </p>
                            <a href="freelancer/login.php" class="btn btn-hero w-100">
                                <i class="fas fa-arrow-right"></i> Start Freelancing
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Why Choose Fiverr Clone?</h2>
                <p class="lead text-muted">We make freelancing simple and effective</p>
            </div>
            
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>Secure Platform</h4>
                    <p class="text-muted">Your projects and payments are protected with our secure platform.</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h4>Quick Matching</h4>
                    <p class="text-muted">Find the right talent or project in minutes, not days.</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h4>Quality Assured</h4>
                    <p class="text-muted">All freelancers are vetted to ensure quality work delivery.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">What Our Users Say</h2>
                <p class="lead text-muted">Real stories from real people</p>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <img src="https://via.placeholder.com/60x60/007bff/ffffff?text=SM" 
                             class="rounded-circle mb-3" width="60" height="60" alt="User 1">
                        <h5>Sophia M.</h5>
                        <p class="text-muted">"This platform helped me discover amazing freelancers quickly. The quality of work exceeded my expectations!"</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <img src="https://via.placeholder.com/60x60/28a745/ffffff?text=LK" 
                             class="rounded-circle mb-3" width="60" height="60" alt="User 2">
                        <h5>Liam K.</h5>
                        <p class="text-muted">"As a freelancer, I found great projects that matched my skills perfectly. The platform is intuitive and effective."</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <img src="https://via.placeholder.com/60x60/6f42c1/ffffff?text=ET" 
                             class="rounded-circle mb-3" width="60" height="60" alt="User 3">
                        <h5>Emma T.</h5>
                        <p class="text-muted">"The communication tools and project management features made working with freelancers seamless and productive."</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="display-5 fw-bold mb-3">Ready to Get Started?</h2>
            <p class="lead mb-4">Join thousands of users who are already finding success on our platform</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="client/register.php" class="btn btn-light btn-lg">
                    <i class="fas fa-user-plus"></i> Sign Up as Client
                </a>
                <a href="freelancer/register.php" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-code"></i> Sign Up as Freelancer
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-rocket"></i> Fiverr Clone</h5>
                    <p class="text-muted">Connecting talent with opportunity, one project at a time.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">&copy; 2024 Fiverr Clone. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
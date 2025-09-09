<?php
// index.php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Video Downloader</title>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="fas fa-download me-2"></i>
                <span>SaveSocial</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Terms of Service</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Privacy Policy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">DMCA</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100 py-5">
                <div class="col-lg-8 col-md-10 text-center">
                    <div class="hero-content bg-dark bg-opacity-75 rounded-4 p-4 p-md-5 shadow-lg">
                        <h1 class="display-4 fw-bold mb-3 text-warning">Video Downloader</h1>
                        <p class="lead mb-4 text-light">Get your favorite videos now with this FREE, QUICK & Simple Video Downloader!</p>
                        
                        <form id="downloadForm" class="mb-4">
                            <div class="input-group mb-3">
                                <input type="url" id="videoUrl" name="url" class="form-control form-control-lg" 
                                       placeholder="Paste Video URL" required>
                                <button type="submit" id="downloadBtn" class="btn btn-warning btn-lg px-4">
                                    <i class="fas fa-download me-2"></i>Download
                                </button>
                            </div>
                            
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <select id="videoFormat" name="format" class="form-select form-select-lg">
                                        <option value="best">Best Quality</option>
                                        <option value="worst">Worst Quality</option>
                                        <option value="mp4">MP4 Format</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        
                        <div class="platforms-section mt-4">
                            <p class="text-muted mb-3">Supported Platforms</p>
                            <div class="d-flex justify-content-center flex-wrap gap-4">
                                <div class="platform-item text-warning">
                                    <i class="fab fa-facebook fa-2x mb-2"></i>
                                    <span>Facebook</span>
                                </div>
                                <div class="platform-item text-warning">
                                    <i class="fab fa-tiktok fa-2x mb-2"></i>
                                    <span>TikTok</span>
                                </div>
                                <div class="platform-item text-warning">
                                    <i class="fab fa-instagram fa-2x mb-2"></i>
                                    <span>Instagram</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="progress-container mt-4 p-4 bg-dark bg-opacity-75 rounded-4 shadow-lg" id="progressContainer" style="display: none;">
                        <div class="progress mb-3" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" 
                                 id="progressBar" role="progressbar" style="width: 0%" 
                                 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="text-light mb-0 text-center" id="progressText">Processing...</p>
                    </div>
                    
                    <!-- Result Container -->
                    <div class="result-container mt-4" id="resultContainer"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-auto">
        <div class="container">
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> Video Downloader. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap & Custom JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
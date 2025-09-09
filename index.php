<?php
// index.php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Video Downloader</title>
</head>
<body>
    <!-- Header -->
    <header class="site-header">
        <div class="container">
            <nav class="nav">
                <ul class="nav-links">
                    <li><a href="#" class="nav-link active">Home</a></li>
                    <li><a href="#" class="nav-link">About</a></li>
                    <li><a href="#" class="nav-link">Contact</a></li>
                    <li><a href="#" class="nav-link">Privacy Policy</a></li>
                    <li><a href="#" class="nav-link">DMCA</a></li>
                </ul>
                <button class="nav-toggle" aria-label="Open menu" aria-expanded="false">☰</button>
            </nav>
        </div>
    </header>
    <div class="container">
        
        <!-- Main Content -->
        <main class="main hero">
            <div class="background-overlay"></div>
            <div class="container">
                <div class="content-wrapper">
                    <div class="info-box hero-box">
                        <h1 class="title hero-title">Video Downloader</h1>
                        <p class="description hero-subtitle">Get Your favorite videos now with this FREE, QUICK & Simple Video Downloader!</p>
                        <form id="downloadForm">
                            <div class="input-section search-form">
                                <input type="url" id="videoUrl" name="url" class="url-input search-input" placeholder="Paste Video URL">
                                <button type="submit" id="downloadBtn" class="download-btn search-button">
                                    Download
                                </button>
                            </div>
                            <div class="input-group">
                                <label for="videoFormat">Format</label>
                                <select id="videoFormat" name="format">
                                    <option value="best">Best Quality</option>
                                    <option value="worst">Worst Quality</option>
                                    <option value="mp4">MP4 Format</option>
                                </select>
                            </div>
                        </form>
                        <div class="features">
                            <div class="feature-item">
                                <i class="fab fa-facebook"></i>
                                <span>Facebook</span>
                            </div>
                            <div class="feature-item">
                                <i class="fab fa-tiktok"></i>
                                <span>TikTok</span>
                            </div>
                            <div class="feature-item">
                                <i class="fab fa-instagram"></i>
                                <span>Instagram</span>
                            </div>
                        </div>
                    </div>
                    <div class="progress" id="progressContainer">
                        <div class="progress-bar">
                            <div class="progress-bar-inner" id="progressBar"></div>
                        </div>
                        <p id="progressText">Processing...</p>
                    </div>

                    <div class="result" id="resultContainer"></div>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="footer">
        
    </footer>

    <script src="script.js"></script>
</body>
</html>
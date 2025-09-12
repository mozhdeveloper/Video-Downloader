<?php
require_once 'config.php';
?>
    <?php include 'templates/header.php'; ?>
    <section class="hero-section">
        <div class="container">
            
            <div class="row justify-content-center align-items-center min-vh-100 py-5">
                <div class="col-lg-8 col-md-10 text-center">
                    <div class="hero-content bg-opacity-75 rounded-4 p-4 p-md-5 shadow-lg">

                        <h1 class="display-4 fw-bold mb-3 text-white">Video Downloader</h1>
                            <p class="lead mb-4 text-light">Get your favorite videos now with this FREE, FAST & Easy Video Downloader!</p>
                                <form id="downloadForm" class="mb-4">
                                    <div class="row justify-content-center g-2 align-items-center">
                                        <!-- Select dropdown -->
                                        <div class="col-md-3 col-12 d-none">
                                            <select id="videoFormat" name="format" class="form-select form-select-lg">
                                                <option value="best">Best Quality</option>
                                                <option value="worst">Low Quality</option>
                                            </select>
                                        </div>

                                        <!-- Input + Button grouped together -->
                                        <div class="col-md-9 col-12">
                                            <div class="input-group input-group-lg">

                                                <input type="url" id="videoUrl" name="url" 
                                                    class="form-control"
                                                    placeholder="Paste Video URL" required>
                                                <!-- Clipboard button -->
                                                <button type="button" id="pasteBtn" class="btn btn-light border rounded px-3 py-2">
                                                    <i class="fas fa-paste fs-4 text-dark"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>   
                                    
                                    <div class="btn-container text-center"> 
                                          <button type="submit" id="downloadBtn" 
                                                    class="btn search-button py-2 d-flex align-items-center justify-content-center gap-2">
                                            <img src="assets/img/savesocial-logo.png" alt="Logo" class="btn-logo">
                                            Download
                                            </button>
                                    </div>
                                </form>
                            

                                <!-- Progress Bar -->
                                <div class="progress-container mt-4 p-4 bg-white bg-opacity-75 rounded-4 shadow-lg" id="progressContainer" style="display: none;">
                                    <div class="progress mb-3" style="height: 20px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-purple" 
                                            id="progressBar" role="progressbar" style="width: 0%" 
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="text-dark mb-0 text-center" id="progressText">Processing...</p>
                                </div>
                                
                                <!-- Result Container -->
                                <div class="result-container mt-4" id="resultContainer"></div>

                                <div class="platforms-section mt-4">
                                    <p class="text-muted mb-3">Supported Platforms</p>
                                    <div class="d-flex justify-content-center flex-wrap gap-5">
                                        <div class="platform-item text-dark">
                                            <img src="assets/img/facebook.svg" alt="Facebook Logo" class="icon">
                                            <span>Facebook</span>
                                        </div>
                                        <div class="platform-item text-dark">
                                             <img src="assets/img/tiktok.svg" alt="Tiktok Logo" class="icon">
                                            <span>TikTok</span>
                                        </div>
                                        <div class="platform-item text-dark">
                                             <img src="assets/img/instagram.svg" alt="Instagram Logo" class="icon">
                                            <span>Instagram</span>
                                        </div>
                                        <div class="platform-item text-dark">
                                            <img src="assets/img/youtube.svg" alt="Youtube Logo" class="icon-yt">
                                            <span>Youtube</span>
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
        </div>
    </section>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
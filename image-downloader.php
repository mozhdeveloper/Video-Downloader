<?php include 'templates/header.php'; ?>
    <section class="hero-section">
        <div class="container">
            
            <div class="row justify-content-center align-items-center min-vh-100 py-5">
                <div class="col-lg-8 col-md-10 text-center">
                    <div class="hero-content bg-opacity-75 rounded-4 p-4 shadow-lg">

                        <h1 class="display-4 fw-bold mb-3 text-white">Image Downloader</h1>
                            <p class="lead mb-4 text-light">Get your favorite images now with this FREE, FAST & Easy Image Downloader!</p>
                                <form id="downloadImageForm" class="mb-4">
                                    <div class="row justify-content-center g-2 align-items-center">
                                        <!-- Select dropdown -->
                                        <div class="col-md-3 col-12">
                                            <select id="imageFormat" name="format" class="form-select form-select-lg">
                                                <option value="best">JPEG</option>
                                                <option value="worst">PNG</option>
                                            </select>
                                        </div>

                                        <!-- Input + Button grouped together -->
                                        <div class="col-md-9 col-12">
                                            <div class="input-group input-group-lg">

                                                <input type="url" id="imageUrl" name="url" 
                                                    class="form-control"
                                                    placeholder="Paste Image URL" required>
                                                <!-- Clipboard button -->
                                                <button type="button" id="pasteBtn" class="btn btn-light border rounded px-3 py-2">
                                                    <i class="fas fa-paste fs-4 text-dark"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="btn-container text-center"> 
                                          <button type="submit" id="downloadImageBtn" 
                                                    class="btn search-button py-2 d-flex align-items-center justify-content-center gap-2">
                                            <img src="assets/img/savesocial-logo.png" alt="Logo" class="btn-logo">
                                            Download
                                            </button>
                                    </div>
                                </form>
                            

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
                        <div class="progress-container mt-4 p-4 bg-dark bg-opacity-75 rounded-4 shadow-lg" id="progressImageContainer" style="display: none;">
                            <div class="progress mb-3" style="height: 20px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" 
                                    id="progressImageBar" role="progressbar" style="width: 0%" 
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="text-light mb-0 text-center" id="progressImageText">Processing...</p>
                        </div>
                        <!-- Result Container -->
                        <div class="result-container mt-4" id="resultImageContainer"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    document.getElementById('downloadImageForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const url = document.getElementById('imageUrl').value.trim();
        const resultContainer = document.getElementById('resultImageContainer');
        const progressContainer = document.getElementById('progressImageContainer');
        const progressBar = document.getElementById('progressImageBar');
        const progressText = document.getElementById('progressImageText');

        // Show progress bar
        progressContainer.style.display = 'block';
        progressBar.style.width = '50%';
        progressText.textContent = 'Scraping images...';

        // Send AJAX request to PHP
        fetch('image-scrapper.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'url=' + encodeURIComponent(url)
        })
        .then(response => response.json())
        .then(data => {
            progressBar.style.width = '100%';
            progressText.textContent = 'Done!';
            if (data.images && data.images.length > 0) {
                let html = '<h4>Found Images:</h4>';
                data.images.forEach(img => {
                    html += `
                        <div class="mb-3">
                            <img src="${img}" style="max-width:300px;" class="rounded mb-2">
                            <br>
                            <a href="${img}" download class="btn btn-success btn-sm">Download</a>
                        </div>
                    `;
                });
                resultContainer.innerHTML = html;
            } else {
                resultContainer.innerHTML = '<p class="text-danger">No images found or unable to fetch page.</p>';
            }
        })
        .catch(() => {
            progressBar.style.width = '0%';
            progressText.textContent = 'Error!';
            resultContainer.innerHTML = '<p class="text-danger">Failed to scrape images.</p>';
        });
    });
    </script>

<?php include 'templates/footer.php'; ?>
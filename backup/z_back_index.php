<?php
// index.php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Downloader</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .container {
            width: 100%;
            max-width: 600px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        .header {
            background: #4a5568;
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 14px;
            opacity: 0.8;
        }
        
        .form-container {
            padding: 30px;
        }
        
        .input-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #4a5568;
        }
        
        input[type="url"], select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #cbd5e0;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input[type="url"]:focus, select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }
        
        button {
            width: 100%;
            padding: 14px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        button:hover {
            background: #5a67d8;
        }
        
        button:disabled {
            background: #a0aec0;
            cursor: not-allowed;
        }
        
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            display: none;
        }
        
        .success {
            background: #f0fff4;
            color: #2f855a;
            border: 1px solid #9ae6b4;
        }
        
        .error {
            background: #fff5f5;
            color: #c53030;
            border: 1px solid #feb2b2;
        }
        
        .progress {
            margin-top: 20px;
            display: none;
        }
        
        .progress-bar {
            height: 10px;
            background: #edf2f7;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .progress-bar-inner {
            height: 100%;
            background: #667eea;
            width: 0%;
            transition: width 0.3s;
        }
        
        .download-link {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #48bb78;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: background 0.3s;
        }
        
        .download-link:hover {
            background: #38a169;
        }
        
        .instructions {
            margin-top: 30px;
            padding: 20px;
            background: #f7fafc;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .instructions h3 {
            margin-bottom: 10px;
            color: #4a5568;
        }
        
        .instructions ul {
            padding-left: 20px;
        }
        
        .instructions li {
            margin-bottom: 8px;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .container {
                border-radius: 8px;
            }
            
            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Video Downloader</h1>
            <p>Download videos from YouTube, Facebook, and Instagram</p>
        </div>
        
        <div class="form-container">
            <form id="downloadForm">
                <div class="input-group">
                    <label for="videoUrl">Video URL</label>
                    <input type="url" id="videoUrl" name="url" placeholder="https://www.youtube.com/watch?v=..." required>
                </div>
                
                <div class="input-group">
                    <label for="videoFormat">Format</label>
                    <select id="videoFormat" name="format">
                        <option value="best">Best Quality</option>
                        <option value="worst">Worst Quality</option>
                        <option value="mp4">MP4 Format</option>
                    </select>
                </div>
                
                <button type="submit" id="downloadBtn">Download Video</button>
            </form>
            
            <div class="progress" id="progressContainer">
                <div class="progress-bar">
                    <div class="progress-bar-inner" id="progressBar"></div>
                </div>
                <p id="progressText">Processing...</p>
            </div>
            
            <div class="result" id="resultContainer"></div>
            
            <div class="instructions">
                <h3>How to use:</h3>
                <ul>
                    <li>Paste the URL of a video from YouTube, Facebook, or Instagram</li>
                    <li>Select your preferred format (default is best quality)</li>
                    <li>Click Download Video and wait for processing to complete</li>
                    <li>Your download will start automatically</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Replace the existing JavaScript with this enhanced version
        // Enhanced JavaScript with better error handling
        document.getElementById('downloadForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const url = document.getElementById('videoUrl').value;
            const format = document.getElementById('videoFormat').value;
            const downloadBtn = document.getElementById('downloadBtn');
            const resultContainer = document.getElementById('resultContainer');
            const progressContainer = document.getElementById('progressContainer');
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');
            
            // Reset UI
            resultContainer.style.display = 'none';
            resultContainer.className = 'result';
            downloadBtn.disabled = true;
            progressContainer.style.display = 'block';
            progressBar.style.width = '10%';
            progressText.textContent = 'Validating URL...';
            
            try {
                // Create form data
                const formData = new FormData();
                formData.append('url', url);
                formData.append('format', format);
                
                // Show progress
                progressBar.style.width = '30%';
                progressText.textContent = 'Sending request...';
                
                // Send request with timeout
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 120000); // 2 minute timeout
                
                const response = await fetch('downloader.php', {
                    method: 'POST',
                    body: formData,
                    signal: controller.signal
                });
                
                clearTimeout(timeoutId);
                
                progressBar.style.width = '60%';
                progressText.textContent = 'Processing response...';
                
                // Check if response is OK
                if (!response.ok) {
                    throw new Error(`Server error: ${response.status} ${response.statusText}`);
                }
                
                // Parse JSON response
                const data = await response.json();
                
                progressBar.style.width = '80%';
                progressText.textContent = 'Finalizing...';
                
                if (data.success) {
                    progressBar.style.width = '100%';
                    progressText.textContent = 'Download ready!';
                    
                    // Show success message
                    resultContainer.innerHTML = `
                        <p>Video downloaded successfully!</p>
                        <a href="${data.download_url}" class="download-link" id="downloadLink">Download Now</a>
                    `;
                    resultContainer.className = 'result success';
                    resultContainer.style.display = 'block';
                    
                    // Automatically start download after a short delay
                    setTimeout(() => {
                        document.getElementById('downloadLink').click();
                        
                        // Reset form after successful download
                        setTimeout(() => {
                            progressContainer.style.display = 'none';
                            document.getElementById('videoUrl').value = '';
                        }, 2000);
                    }, 1000);
                    
                } else {
                    throw new Error(data.error || 'Unknown error occurred');
                }
                
            } catch (error) {
                progressContainer.style.display = 'none';
                
                let errorMessage = error.message;
                if (error.name === 'AbortError') {
                    errorMessage = 'Request timed out. The video might be too long or the server is busy.';
                } else if (error.message.includes('Network')) {
                    errorMessage = 'Network error. Please check your connection.';
                } else if (error.message.includes('JSON')) {
                    errorMessage = 'Invalid response from server. Please try again.';
                }
                
                resultContainer.innerHTML = `<p>Error: ${errorMessage}</p>`;
                resultContainer.className = 'result error';
                resultContainer.style.display = 'block';
                
                console.error('Download error:', error);
            } finally {
                downloadBtn.disabled = false;
            }
        });

        // Add real-time progress indicator
        function updateProgressBar() {
            const progressBar = document.getElementById('progressBar');
            let width = parseInt(progressBar.style.width) || 10;
            
            if (width < 90) {
                width += Math.random() * 5;
                progressBar.style.width = Math.min(width, 90) + '%';
                setTimeout(updateProgressBar, 1000);
            }
        }
    </script>
</body>
</html>
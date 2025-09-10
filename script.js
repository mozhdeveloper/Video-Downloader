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
                <p class="mt-3 text-success">Video downloaded successfully!</p>
                <a href="${data.download_url}" class="download-link text-warning" id="downloadLink">Didn't work? Click here to download manually.</a>
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

/** Frontend Logic **/
//const form = document.getElementById('search-form');
const input = document.getElementById('imageUrl');
const navToggle = document.querySelector('.nav-toggle');
const navLinks = document.querySelector('.nav-links');

navToggle?.addEventListener('click', () => {
  const isOpen = navLinks.classList.toggle('show');
  navToggle.setAttribute('aria-expanded', String(isOpen));
});

// Ensure the search button returns to normal on touch devices
document.addEventListener('touchend', (e) => {
  const target = e.target;
  if (target && target.classList && (target.classList.contains('search-button') || target.closest('.search-button'))) {
    setTimeout(() => {
      if (document.activeElement && (document.activeElement.classList?.contains('search-button'))) {
        document.activeElement.blur();
      }
    }, 0);
  }
}, { passive: true });

// Small shake animation on invalid
const style = document.createElement('style');
style.textContent = `
@keyframes shake { 10%, 90% { transform: translateX(-1px); }
  20%, 80% { transform: translateX(2px); }
  30%, 50%, 70% { transform: translateX(-4px); }
  40%, 60% { transform: translateX(4px); } }
.search input.shake { animation: shake .35s; }`;
document.head.appendChild(style);

const toggleBtn = document.getElementById("themeToggle");
  const body = document.body;
    // Load preference
    if (localStorage.getItem("theme") === "dark") {
        body.classList.add("dark-mode");
        toggleBtn.textContent = "☀️ Light Mode";
    }
    toggleBtn.addEventListener("click", () => {
        body.classList.toggle("dark-mode");
        if (body.classList.contains("dark-mode")) {
          toggleBtn.textContent = "☀️ Light Mode";
          localStorage.setItem("theme", "dark");
        } 
        else {
          toggleBtn.textContent = "🌙 Dark Mode";
          localStorage.setItem("theme", "light");
        }
      }
    );

// Clipboard paste into input
document.getElementById("pasteBtn").addEventListener("click", async () => {
  const input = document.getElementById("videoUrl");

  try {
    const text = await navigator.clipboard.readText(); // read from clipboard
    if (!text) {
      alert("Clipboard is empty!");
      return;
    }

    input.value = text; // paste into the input field
    input.focus();

    // Optional: highlight the pasted text
    input.setSelectionRange(0, input.value.length);

    // Optional: tooltip instead of alert
    console.log("Pasted from clipboard:", text);
  } catch (err) {
    console.error("Failed to read clipboard", err);
    alert("Clipboard access denied. Please allow clipboard permissions.");
  }
});

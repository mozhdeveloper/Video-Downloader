<?php
// downloader.php (updated headers)
require_once 'config.php';

// Set headers to allow cross-origin requests and prevent caching
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

class VideoDownloader {
    private $url;
    private $format;
    private $filename;
    private $tempFile;
    private $outputFile;
    
    public function __construct($url, $format = 'best') {
        $this->url = $url;
        $this->format = $format;
        $this->validateUrl();
    }
    
    private function validateUrl() {
        // Basic URL validation
        if (!filter_var($this->url, FILTER_VALIDATE_URL)) {
            error_log("Invalid URL format: " . $this->url);
            throw new Exception("Invalid URL provided");
        }
        
        // Check if domain is allowed
        $domain = parse_url($this->url, PHP_URL_HOST);
        
        if (!$domain) {
            error_log("Cannot parse domain from URL: " . $this->url);
            throw new Exception("Cannot parse domain from URL");
        }
        
        $allowed = false;
        foreach (ALLOWED_DOMAINS as $allowed_domain) {
            if (strpos($domain, $allowed_domain) !== false) {
                $allowed = true;
                
                // Special handling for TikTok
                if (strpos($domain, 'tiktok') !== false) {
                    $this->handleTikTokSpecifics();
                }
                break;
            }
        }
        
        if (!$allowed) {
            error_log("Domain not allowed: " . $domain);
            throw new Exception("Domain not allowed. Supported: " . implode(", ", ALLOWED_DOMAINS));
        }
        
        // Additional check: Test if yt-dlp can recognize the URL
        $test_command = '"' . YT_DLP_PATH . '" --simulate --no-warnings "' . $this->url . '" 2>&1';
        exec($test_command, $test_output, $test_return);
        
        if ($test_return !== 0) {
            error_log("yt-dlp cannot process URL: " . $this->url . " - Output: " . implode("; ", $test_output));
            throw new Exception("This URL cannot be processed. It might be private, age-restricted, or invalid.");
        }
    }

    private function handleTikTokSpecifics() {
        // TikTok-specific preparation
        $this->format = 'best'; // Force best format for TikTok
        $this->addTikTokHeaders();
    }

    private function addTikTokHeaders() {
        // TikTok might require specific headers
        $this->extraOptions = [
            '--referer', 'https://www.tiktok.com/',
            '--user-agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        ];
    }
    
    public function download() {
        // Generate unique filename
        $this->filename = uniqid() . '.mp4';
        $this->tempFile = TEMP_DIR . $this->filename;
        $this->outputFile = OUTPUT_DIR . $this->filename;
        
        // Build yt-dlp command with full path for Windows
        //$command = '"' . YT_DLP_PATH . '" -f "' . $this->format . '" -o "' . $this->tempFile . '" "' . $this->url . '" 2>&1';

        $command = YT_DLP_PATH . ' -f "' . $this->format . '" -o "' . $this->tempFile . '" ';
    
        // Add extra options for TikTok
        if (!empty($this->extraOptions)) {
            $command .= implode(' ', $this->extraOptions) . ' ';
        }
        
        $command .= '"' . $this->url . '" 2>&1';
        
        error_log("Executing command: " . $command);
        
        // Execute command
        exec($command, $output, $returnCode);
        
        error_log("Command output: " . implode("; ", $output));
        error_log("Return code: " . $returnCode);
        
        if ($returnCode !== 0) {
            $error_message = "Download failed";
            
            // Provide more specific error messages
            if (strpos(implode(" ", $output), "Private video") !== false) {
                $error_message = "This is a private video and cannot be downloaded";
            } elseif (strpos(implode(" ", $output), "Age restricted") !== false) {
                $error_message = "Age-restricted content cannot be downloaded";
            } elseif (strpos(implode(" ", $output), "Unsupported URL") !== false) {
                $error_message = "Unsupported URL or video not found";
            }
            
            throw new Exception($error_message . ": " . implode("\n", $output));
        }
        
        // Check if file was created
        if (!file_exists($this->tempFile)) {
            error_log("Downloaded file not found: " . $this->tempFile);
            throw new Exception("Downloaded file not found. The video might be unavailable.");
        }
        
        // Check file size
        $fileSize = filesize($this->tempFile);
        if ($fileSize > MAX_FILE_SIZE) {
            unlink($this->tempFile);
            error_log("File too large: " . $fileSize . " bytes");
            throw new Exception("File too large");
        }
        
        // Move to output directory
        if (!rename($this->tempFile, $this->outputFile)) {
            error_log("Cannot move file from " . $this->tempFile . " to " . $this->outputFile);
            throw new Exception("File processing error");
        }
        
        return $this->filename;
    }
    
    public function getFileInfo() {
        if (!file_exists($this->outputFile)) {
            return false;
        }
        
        return [
            'filename' => $this->filename,
            'path' => $this->outputFile,
            'size' => filesize($this->outputFile),
            'mime' => 'video/mp4'
        ];
    }
    
    public function cleanup() {
        if (file_exists($this->outputFile)) {
            unlink($this->outputFile);
        }
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get raw POST data to handle JSON requests
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        // Fall back to form data if JSON parsing fails
        if (json_last_error() !== JSON_ERROR_NONE) {
            $url = $_POST['url'] ?? '';
            $format = $_POST['format'] ?? 'best';
        } else {
            $url = $data['url'] ?? '';
            $format = $data['format'] ?? 'best';
        }
        
        if (empty($url)) {
            throw new Exception("URL is required");
        }
        
        error_log("Download request received for URL: " . $url);
        
        $downloader = new VideoDownloader($url, $format);
        $filename = $downloader->download();
        
        echo json_encode([
            'success' => true,
            'filename' => $filename
        ]);
        
    } catch (Exception $e) {
        error_log("Download error: " . $e->getMessage());
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
    
    exit;
}
?>
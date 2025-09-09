<?php
// debug.php
require_once 'config.php';

// Test URL validation directly
$test_urls = [
    'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
    'https://youtu.be/dQw4w9WgXcQ',
    'https://www.facebook.com/watch/?v=10152751036691729',
    'https://www.instagram.com/p/Cg1eP6DLX22/',
    'https://invalid-url-test.com'
];

echo "<h2>URL Validation Debug</h2>";

foreach ($test_urls as $url) {
    echo "<h3>Testing: " . htmlspecialchars($url) . "</h3>";
    
    try {
        // Basic URL validation
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception("Invalid URL format");
        }
        
        echo "✓ URL format is valid<br>";
        
        // Check if domain is allowed
        $domain = parse_url($url, PHP_URL_HOST);
        echo "Domain: " . ($domain ? $domain : "Cannot parse domain") . "<br>";
        
        $allowed = false;
        foreach (ALLOWED_DOMAINS as $allowed_domain) {
            if (strpos($domain, $allowed_domain) !== false) {
                $allowed = true;
                break;
            }
        }
        
        if (!$allowed) {
            throw new Exception("Domain not allowed. Supported: " . implode(", ", ALLOWED_DOMAINS));
        }
        
        echo "✓ Domain is allowed<br>";
        echo "<span style='color: green;'>✓ VALIDATION PASSED</span>";
        
    } catch (Exception $e) {
        echo "<span style='color: red;'>✗ VALIDATION FAILED: " . $e->getMessage() . "</span>";
    }
    
    echo "<hr>";
}

// Test if yt-dlp is accessible
echo "<h2>Testing yt-dlp Accessibility</h2>";
$yt_dlp_path = YT_DLP_PATH;
echo "YT-DLP Path: " . $yt_dlp_path . "<br>";

if (file_exists($yt_dlp_path)) {
    echo "✓ yt-dlp.exe file exists<br>";
    
    // Test command execution
    $test_command = '"' . $yt_dlp_path . '" --version 2>&1';
    echo "Testing command: " . htmlspecialchars($test_command) . "<br>";
    
    exec($test_command, $output, $returnCode);
    
    if ($returnCode === 0) {
        echo "✓ yt-dlp is working. Version: " . implode("<br>", $output) . "<br>";
    } else {
        echo "✗ yt-dlp failed. Error: " . implode("<br>", $output) . "<br>";
        echo "Return code: " . $returnCode . "<br>";
    }
} else {
    echo "✗ yt-dlp.exe not found at specified path<br>";
}

// Test PHP permissions
echo "<h2>Testing PHP Permissions</h2>";
echo "PHP can execute commands: " . (function_exists('exec') ? 'Yes' : 'No') . "<br>";

// Test folder permissions
echo "Temp folder writable: " . (is_writable(TEMP_DIR) ? 'Yes' : 'No') . "<br>";
echo "Downloads folder writable: " . (is_writable(OUTPUT_DIR) ? 'Yes' : 'No') . "<br>";

// Test FFmpeg
echo "<h2>Testing FFmpeg</h2>";
$ffmpeg_path = FFMPEG_PATH;
if (file_exists($ffmpeg_path)) {
    echo "✓ ffmpeg.exe exists<br>";
    exec('"' . $ffmpeg_path . '" -version 2>&1', $ffmpeg_output, $ffmpeg_return);
    if ($ffmpeg_return === 0) {
        echo "✓ FFmpeg is working<br>";
    } else {
        echo "✗ FFmpeg failed: " . implode("<br>", $ffmpeg_output) . "<br>";
    }
} else {
    echo "✗ ffmpeg.exe not found<br>";
}
?>
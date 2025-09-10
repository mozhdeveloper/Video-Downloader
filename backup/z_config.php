<?php
// config.php - aaPanel version
// Server configuration
define('MAX_FILE_SIZE', 500 * 1024 * 1024); // 500MB
define('MAX_DURATION', 1800); // 30 minutes
define('ALLOWED_DOMAINS', ['youtube.com', 'youtu.be', 'facebook.com', 'instagram.com', 'tiktok.com', 'vm.tiktok.com', 'vt.tiktok.com']);
define('TEMP_DIR', __DIR__ . '/temp/');
define('OUTPUT_DIR', __DIR__ . '/downloads/');
define('YT_DLP_PATH', '/usr/local/bin/yt-dlp');
define('FFMPEG_PATH', '/usr/bin/ffmpeg');

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Increase limits for downloads
set_time_limit(300);
ini_set('max_execution_time', 300);
ini_set('memory_limit', '512M');

// Create directories if they don't exist
if (!file_exists(TEMP_DIR)) mkdir(TEMP_DIR, 0755, true);
if (!file_exists(OUTPUT_DIR)) mkdir(OUTPUT_DIR, 0755, true);

// Security: prevent directory listing
if (!file_exists(TEMP_DIR . '.htaccess')) {
    file_put_contents(TEMP_DIR . '.htaccess', 'Options -Indexes' . PHP_EOL . 'Deny from all');
}
if (!file_exists(OUTPUT_DIR . '.htaccess')) {
    file_put_contents(OUTPUT_DIR . '.htaccess', 'Options -Indexes');
}
?>
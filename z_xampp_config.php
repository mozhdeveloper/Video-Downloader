<?php
// config.php
// Server configuration
define('MAX_FILE_SIZE', 500 * 1024 * 1024); // 500MB
define('MAX_DURATION', 1800); // 30 minutes
define('ALLOWED_DOMAINS', ['youtube.com', 'youtu.be', 'facebook.com', 'instagram.com']);
define('TEMP_DIR', __DIR__ . '/temp/');
define('OUTPUT_DIR', __DIR__ . '/downloads/');
define('YT_DLP_PATH', __DIR__ . '/bin/yt-dlp.exe');
define('FFMPEG_PATH', __DIR__ . '/bin/ffmpeg.exe');

// Create directories if they don't exist
if (!file_exists(TEMP_DIR)) mkdir(TEMP_DIR, 0755, true);
if (!file_exists(OUTPUT_DIR)) mkdir(OUTPUT_DIR, 0755, true);

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Add bin directory to PATH for command execution
$path = getenv('PATH');
$binPath = __DIR__ . '/bin';
if (strpos($path, $binPath) === false) {
    putenv('PATH=' . $path . ';' . $binPath);
}
?>
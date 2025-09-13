<?php
require_once 'config.php';

if (!isset($_GET['file'])) {
    http_response_code(400);
    die("File parameter is required");
}

$filename = basename($_GET['file']);
$filepath = OUTPUT_DIR . $filename;

if (!file_exists($filepath)) {
    http_response_code(404);
    die("File not found");
}

// Set headers for video preview (streaming)
header('Content-Type: video/mp4');
header('Content-Length: ' . filesize($filepath));
header('Accept-Ranges: bytes');

// Stream the file (do NOT delete after preview)
readfile($filepath);
exit;
?>
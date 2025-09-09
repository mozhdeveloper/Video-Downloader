<?php
// download.php
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

// Set headers for download
header('Content-Description: File Transfer');
header('Content-Type: video/mp4');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filepath));

// Clean output buffer and send file
flush();
readfile($filepath);

// Delete file after download
unlink($filepath);
exit;
?>
<?php
header('Content-Type: application/json');
$images = [];
if (isset($_POST['url'])) {
    $url = trim($_POST['url']);
    $html = @file_get_contents($url);
    if ($html) {
        preg_match_all('/<img[^>]+src="([^">]+)"/i', $html, $matches);
        $images = $matches[1];
        // Make relative URLs absolute
        foreach ($images as &$img) {
            if (strpos($img, 'http') !== 0 && strpos($img, '//') !== 0) {
                // Handle relative URLs
                $parsedUrl = parse_url($url);
                $base = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
                $img = $base . '/' . ltrim($img, '/');
            } elseif (strpos($img, '//') === 0) {
                // Handle protocol-relative URLs
                $img = 'https:' . $img;
            }
        }
    }
}
echo json_encode(['images' => $images]);
<?php
// check_config.php
require_once 'config.php';

echo "<h2>PHP Configuration Check</h2>";

// Check PHP settings
$settings = [
    'memory_limit' => ini_get('memory_limit'),
    'max_execution_time' => ini_get('max_execution_time'),
    'post_max_size' => ini_get('post_max_size'),
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'disable_functions' => ini_get('disable_functions')
];

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Setting</th><th>Value</th><th>Status</th></tr>";

foreach ($settings as $key => $value) {
    $status = '✅ OK';
    
    if ($key === 'disable_functions' && strpos($value, 'exec') !== false) {
        $status = '❌ PROBLEM: exec function is disabled';
    } elseif ($key === 'max_execution_time' && $value < 300) {
        $status = '⚠️ WARNING: Low execution time (' . $value . 's)';
    } elseif (($key === 'post_max_size' || $key === 'upload_max_filesize') && 
              intval($value) < 100) {
        $status = '⚠️ WARNING: Low ' . $key . ' (' . $value . ')';
    }
    
    echo "<tr><td>{$key}</td><td>{$value}</td><td>{$status}</td></tr>";
}

echo "</table>";

// Check if sessions are working
echo "<h3>Session Test</h3>";
session_start();
$_SESSION['test'] = 'success';
echo "Session test: " . ($_SESSION['test'] === 'success' ? '✅ Working' : '❌ Failed');

// Check file permissions
echo "<h3>File Permissions</h3>";
echo "Temp directory writable: " . (is_writable(TEMP_DIR) ? '✅ Yes' : '❌ No') . "<br>";
echo "Downloads directory writable: " . (is_writable(OUTPUT_DIR) ? '✅ Yes' : '❌ No') . "<br>";

// Test simple exec
echo "<h3>Exec Function Test</h3>";
exec('echo "test"', $output, $return);
echo "Exec function: " . ($return === 0 ? '✅ Working' : '❌ Failed');
echo "<br>Output: " . implode(', ', $output);
?>
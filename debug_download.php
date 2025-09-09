<?php
// debug_download.php
require_once 'config.php';

echo "<h2>Download Process Debug</h2>";

// Test a specific URL
$test_url = "https://www.youtube.com/watch?v=dQw4w9WgXcQ"; // Rick Astley - Never Gonna Give You Up
echo "<h3>Testing download for: " . htmlspecialchars($test_url) . "</h3>";

try {
    // Test the complete download process
    $filename = uniqid() . '.mp4';
    $tempFile = TEMP_DIR . $filename;
    $outputFile = OUTPUT_DIR . $filename;
    
    echo "Temp file: " . $tempFile . "<br>";
    echo "Output file: " . $outputFile . "<br>";
    
    // Build the exact same command that would be used
    $command = '"' . YT_DLP_PATH . '" -f "best" -o "' . $tempFile . '" "' . $test_url . '" 2>&1';
    echo "Command: " . htmlspecialchars($command) . "<br>";
    
    // Execute command with real-time output
    echo "<h4>Command Execution:</h4>";
    echo "<pre style='background: #f0f0f0; padding: 10px;'>";
    
    $descriptorspec = array(
        0 => array("pipe", "r"),   // stdin
        1 => array("pipe", "w"),   // stdout
        2 => array("pipe", "w")    // stderr
    );
    
    $process = proc_open($command, $descriptorspec, $pipes, null, null);
    
    if (is_resource($process)) {
        // Close stdin
        fclose($pipes[0]);
        
        // Read stdout
        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        
        // Read stderr
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        
        // Get return code
        $returnCode = proc_close($process);
        
        echo "STDOUT:\n" . htmlspecialchars($stdout) . "\n\n";
        echo "STDERR:\n" . htmlspecialchars($stderr) . "\n\n";
        echo "Return code: " . $returnCode . "\n";
    } else {
        echo "Failed to execute command\n";
    }
    
    echo "</pre>";
    
    // Check if file was created
    if (file_exists($tempFile)) {
        $fileSize = filesize($tempFile);
        echo "✓ File downloaded successfully: " . $fileSize . " bytes<br>";
        
        // Check if we can move it
        if (rename($tempFile, $outputFile)) {
            echo "✓ File moved to downloads folder successfully<br>";
            
            // Check if downloadable
            if (file_exists($outputFile)) {
                echo "✓ Final file exists and is ready for download<br>";
                echo "<a href='download.php?file=" . urlencode($filename) . "' target='_blank'>Test Download</a><br>";
                
                // Clean up
                unlink($outputFile);
            }
        } else {
            echo "✗ Failed to move file to downloads folder<br>";
        }
    } else {
        echo "✗ No file was created during download<br>";
    }
    
} catch (Exception $e) {
    echo "<span style='color: red;'>Error: " . $e->getMessage() . "</span><br>";
}

// Test JavaScript/AJAX communication
echo "<h3>Testing JavaScript Communication</h3>";
echo "<button onclick='testAjax()'>Test AJAX Request</button>";
echo "<div id='ajaxResult' style='margin-top: 10px; padding: 10px; border: 1px solid #ccc;'></div>";

?>
<script>
function testAjax() {
    var resultDiv = document.getElementById('ajaxResult');
    resultDiv.innerHTML = 'Sending test request...';
    
    var formData = new FormData();
    formData.append('url', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ');
    formData.append('format', 'best');
    
    fetch('downloader.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        resultDiv.innerHTML = 'Response: ' + JSON.stringify(data, null, 2);
        resultDiv.style.backgroundColor = data.success ? '#dff0d8' : '#f2dede';
    })
    .catch(error => {
        resultDiv.innerHTML = 'Error: ' + error;
        resultDiv.style.backgroundColor = '#f2dede';
    });
}
</script>
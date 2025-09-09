<?php
// simple_test.php
exec('C:\Users\Erick\xampp\htdocs\Video-Downloader\bin\yt-dlp.exe --version', $output, $return);
echo "Return code: $return<br>";
echo "Output: " . implode('<br>', $output);
?>
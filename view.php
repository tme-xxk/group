<?php
if(isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $path = "uploads/" . $file . ".html";

    if(file_exists($path)) {
        include($path);
    } else {
        echo "<h2>❌ File not found!</h2>";
    }
} else {
    echo "<h2>❌ Invalid link!</h2>";
}
?>
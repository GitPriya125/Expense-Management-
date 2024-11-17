<?php
// Prevent direct access
define('INCLUDED', true);

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Include necessary files
require_once 'includes/config.php';
// Include the file map
$fileMap = require 'includes/file_map_wig.php';

// Get the symbolic character from the URL parameter
$symbolicCharacter = isset($_GET['rodis']) ? $_GET['rodis'] : null;

// Set default page title
$pageTitle = "Available Pages";

// Update page title if a valid symbolic character is provided
if ($symbolicCharacter && isset($fileMap[$symbolicCharacter])) {
    $pageTitle = $fileMap[$symbolicCharacter]['title'];
}

// Include the header (which now uses the correct $pageTitle)
include 'includes/header.php';
?>

<div class="content-wrapper">
    <?php
    // Include the sidebar
    include 'includes/sidebar.php';
    ?>

    <!-- Main Content -->
    <main id="main-content">
        <?php
        if ($symbolicCharacter && isset($fileMap[$symbolicCharacter])) {
            // If a valid symbolic character is provided, include the corresponding file
            include $fileMap[$symbolicCharacter]['path'];
        } else {
            // If no valid symbolic character is provided, display the numbered list of available pages
            // echo "<h2>{$pageTitle}</h2>";
            echo "<ol>";
            foreach ($fileMap as $char => $fileInfo) {
                echo "<li><a href='?rodis={$char}'>{$fileInfo['title']}</a></li>";
            }
            echo "</ol>";
        }
        ?>
    </main>
</div>

<?php
// Include the footer
include 'includes/footer.php';
?>
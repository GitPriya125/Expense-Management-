<?php
// Prevent direct access
define('INCLUDED', true);

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/error_handler.php';

// Include the file map
$fileMap = require 'includes/file_map.php';

// Get the symbolic character from the URL parameter
$symbolicCharacter = isset($_GET['rodis']) ? $_GET['rodis'] : null;

// Check if the symbolic character exists in the file map
// if (!$symbolicCharacter || !isset($fileMap[$symbolicCharacter])) {
//     die("Invalid page"); // Handle wrong page access with a graceful error message
// }

// Set the page title dynamically based on the symbolic character
$pageTitle = $fileMap[$symbolicCharacter]['title'];

// Include the header (which may use $pageTitle)
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
        // Include the mapped file
        include $fileMap[$symbolicCharacter]['path'];
        ?>
    </main>
</div>

<?php
// Include the footer
include 'includes/footer.php';
?>

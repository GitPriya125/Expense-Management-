<?php
// header.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Ensure this file is not accessed directly
if (!defined('INCLUDED')) {
    die('Direct access not permitted');
}
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/error_handler.php';


// Start the session
if (session_status() == PHP_SESSION_NONE) {
session_start();
}

// Function to check if user is authenticated
function isAuthenticated() {
    //-------=========---------//
    // while in development comment it for test and production
    $_SESSION['email']= 'sujeet.sharma@rpatech.ai';
    $_SESSION['name'] = 'Sujeet Sharama';
    $_SESSION['profilePic'] = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents('logo.png'));
    return true;
    //------============-------//
    return isset($_SESSION['email']);
}

// Function to redirect to login page
function redirectToLogin() {
// Start the session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Capture the originally requested URL
    $currentPage = $_SERVER['REQUEST_URI'];

    // Store it in the session
    $_SESSION['redirect_after_login'] = $currentPage;

    // Redirect to the authentication page
    header("Location: /auth.php");
    exit();
}

// Check authentication
if (!isAuthenticated()) {
    redirectToLogin();
}




// Fetch user information (assuming these functions exist)
$userEmail = $_SESSION['email'];
$userName = $_SESSION['name'];
$userProfilePic = $_SESSION['profilePic']; // This will be a base64-encoded image string


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - RPATech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@latest/font/bootstrap-icons.css">
    <link href="/assets/css/styles.css" rel="stylesheet">
        <!-- Light mode favicon -->
    <link rel="icon" type="image/svg+xml" href="favicon.svg" media="(prefers-color-scheme: light)">
    
    <!-- Dark mode favicon -->
    <link rel="icon" type="image/svg+xml" href="favicon-dark.svg" media="(prefers-color-scheme: dark)">

</head>
<body>
   
   
 
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <button id="sidebar-collapse"  class="btn btn-outline-secondary">
                <i class="bi bi-list"></i>
            </button>
            <a class="navbar-brand" href="#">
                <!-- Using the provided SVG as the logo -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="40">
                    <path d="M256 48C141.1 48 48 141.1 48 256l0 40c0 13.3-10.7 24-24 24s-24-10.7-24-24l0-40C0 114.6 114.6 0 256 0S512 114.6 512 256l0 144.1c0 48.6-39.4 88-88.1 88L313.6 488c-8.3 14.3-23.8 24-41.6 24l-32 0c-26.5 0-48-21.5-48-48s21.5-48 48-48l32 0c17.8 0 33.3 9.7 41.6 24l110.4 .1c22.1 0 40-17.9 40-40L464 256c0-114.9-93.1-208-208-208zM144 208l16 0c17.7 0 32 14.3 32 32l0 112c0 17.7-14.3 32-32 32l-16 0c-35.3 0-64-28.7-64-64l0-48c0-35.3 28.7-64 64-64zm224 0c35.3 0 64 28.7 64 64l0 48c0 35.3-28.7 64-64 64l-16 0c-17.7 0-32-14.3-32-32l0-112c0-17.7 14.3-32 32-32l16 0z"/>
                </svg>
                <span class="ml-2">N/NAI Desk</span>
            </a>
            
            <span class="navbar-text"><?php echo htmlspecialchars($pageTitle); ?></span>
            <ul class="navbar-nav ms-auto">
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     <?php
                    // Extract the first letter of the display name
                    $initial = strtoupper($userName[0]);
                    ?>
                    
                    <!-- Always display both elements, control visibility using CSS -->
                    <img src="<?php echo htmlspecialchars($userProfilePic); ?>" alt="Profile Picture" class="rounded-circle" width="30" height="30">
                    
                    <div id="profileDiv" style="width: 30px; height: 30px; background-color: #007bff; color: white; border-radius: 50%; display: none; align-items: center; justify-content: center; font-weight: bold;">
                        <?php echo htmlspecialchars($initial); ?>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="/settings.php"><i class="fas fa-cog"></i>Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
                </ul>
            </li>
        </ul>
           
        </div>
    </nav>
    <div id="toast-container" class="position-fixed"></div>

    </script>
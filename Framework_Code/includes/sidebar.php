<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/error_handler.php';
//require_once 'api/getmenu1.php'; 

// try {
//     $userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : null;

//     if (!$userEmail) {
//         throw new Exception("User email not found in session");
//     }

//     $result = getMenuItems($userEmail);
//     $modules = $result['modules'];
//     $debug_info = $result['debug_info'];

// } catch (Exception $e) {
//     $debug_info[] = "Error: " . $e->getMessage();
// }

// // Display debug info if debug mode is enabled
// if (isset($_GET['debug']) && $_GET['debug'] == 1) {
//     echo "<div class='debug-info'>";
//     echo "<h3>Debug Information:</h3>";
//     echo "<pre>" . print_r($debug_info, true) . "</pre>";
//     echo "</div>";
// }
try {
    // Assume user's email is stored in session after SSO login
    $userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : null;

    if (!$userEmail) {
        throw new Exception("User email not found in session");
    }

    // Call API to get menu items
    $modules = callAPI('menu_get.php', 'GET', ['email' => $userEmail]);

    if (!$modules) {
       // throw new Exception("Failed to fetch menu items");
    }
} catch (Exception $e) {
    echo $e;
    // Error is already handled by the custom exception handler
    $modules = [];
}
?>

<nav id="sidebar" class="bg-gradient">
    <div class="position-sticky">
        <ul class="nav flex-column">
            <?php foreach ($modules as $module): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo htmlspecialchars($module->url); ?>" data-bs-toggle="tooltip" title="<?php echo htmlspecialchars($module->tooltip); ?>">
                        <i class="<?php echo htmlspecialchars($module->icon); ?>"></i>
                        <span><?php echo htmlspecialchars($module->module_name); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <!--<div class="sidebar-footer">-->
    <!--    <button id="sidebar-collapse" class="btn btn-link" data-bs-toggle="tooltip" title="Collapse Sidebar">-->
    <!--        <i class="fas fa-chevron-left"></i>-->
    <!--    </button>-->
    <!--</div>-->
</nav>


<script>
document.addEventListener('DOMContentLoaded', function() {
    var sidebarCollapse = document.getElementById('sidebar-collapse');
    var sidebar = document.getElementById('sidebar');
    var mainContent = document.getElementById('main-content');

    sidebarCollapse.addEventListener('click', function() {
        if (window.innerWidth < 768) {
            // On small screens, toggle visibility
            sidebar.classList.toggle('active');
            sidebar.classList.toggle('hidden');
        } else {
            // On larger screens, toggle between collapsed and expanded
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});

</script>
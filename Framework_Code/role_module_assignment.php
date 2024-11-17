<?php
define('INCLUDED', true);
$pageTitle = "Role Module Assignment";
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/error_handler.php';
include 'includes/header.php';
?>

<div class="content-wrapper">
    <?php include 'includes/sidebar.php'; ?>

    <main id="main-content" class="container-fluid">
       

        <!-- Role Selection Dropdown -->
        <div class="row mb-4">
            <div class="col-md-6">
                <label for="roleSelect" class="form-label">Select Role:</label>
                <select class="form-select" id="roleSelect">
                    <option value="">Select a role</option>
                    <!-- Roles will be populated dynamically -->
                </select>
            </div>
        </div>

        <!-- Module Assignment List -->
        <div id="moduleAssignmentList" class="mb-4"></div>
    </main>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/assets/js/role_module_assignment.js"></script>
<?php include 'includes/footer.php'; ?>


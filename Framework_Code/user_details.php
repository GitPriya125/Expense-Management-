<?php
define('INCLUDED', true);
$pageTitle = isset($_GET['id']) ? "User Details" : " <i class='bi bi-person-add'></i> New User";
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/error_handler.php';
include 'includes/header.php';

$userId = isset($_GET['id']) ? $_GET['id'] : null;
?>

<div class="content-wrapper">
    <?php include 'includes/sidebar.php'; ?>

    <main id="main-content" class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><?php echo $pageTitle; ?> </span>
                <div id="actionButtons">
                    <?php if ($userId): ?>
                        <button id="editBtn" class="btn btn-primary"><i class="bi bi-pencil"></i> Edit</button>
                        <button id="deactivateBtn" class="btn btn-warning"><i class="bi bi-pause-circle"></i> Deactivate</button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <form id="userForm">
                    <input type="hidden" id="userId" value="<?php echo $userId; ?>">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" required <?php echo $userId ? 'readonly' : ''; ?>>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="roleId" class="form-label">Role</label>
                        <select class="form-select" id="roleId" required>
                            <!-- Roles will be populated dynamically -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="isActive" class="form-label">Status</label>
                        <input type="text" class="form-control" id="isActive" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="lastLogin" class="form-label">Last Login</label>
                        <input type="text" class="form-control" id="lastLogin" readonly>
                    </div>
                    <div id="formButtons" class="d-none">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" id="cancelBtn" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
<script defer src="/assets/js/user_details.js"></script>
<?php include 'includes/footer.php'; ?>


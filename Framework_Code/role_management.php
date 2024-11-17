<?php
define('INCLUDED', true);
$pageTitle = "Role Management";
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/error_handler.php';
include 'includes/header.php';
?>

<div class="content-wrapper">
    <?php include 'includes/sidebar.php'; ?>

    <main id="main-content" class="container-fluid">


        <!-- Add Role Card -->
        <div class="card mb-4">
            <div class="card-header">Add New Role</div>
            <div class="card-body">
                <form id="addRoleForm">
                    <div class="row">
                        <div class="col-lg-10 col-md-8 col-sm-12">
                            <input type="text" class="form-control" id="newRoleName" name="role_name" placeholder="Enter role name" required>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-12">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-plus-lg"></i> Add Role
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Role List Card -->
        <div class="card">
            <div class="card-header">Existing Roles</div>
            <div class="card-body">
                <div id="roleList">
                    <!-- Roles will be dynamically added here -->
                </div>
            </div>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>

<script src="/assets/js/role_management.js"></script>
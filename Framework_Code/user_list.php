<?php
define('INCLUDED', true);
$pageTitle = "User List";
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/error_handler.php';
include 'includes/header.php';
?>

<div class="content-wrapper">
    <?php include 'includes/sidebar.php'; ?>

    <main id="main-content" class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>User List</span>
                
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="activeUsersOnly" checked>
                    <label class="form-check-label" for="activeUsersOnly">Active Users Only</label>
                </div>
                <div class="col-md-3 text-end">
                        <a href="user_details.php" class="btn btn-light"><i class="bi bi-person-add"></i> New User</a>
                    </div>
            </div>
            <div class="card-body">
                <table id="userTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Login</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
<script src="/assets/js/user_list.js"></script>
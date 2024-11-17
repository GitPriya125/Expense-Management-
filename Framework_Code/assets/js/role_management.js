$(document).ready(function() {
    const roleList = $('#roleList');
    const addRoleForm = $('#addRoleForm');

    // Load roles
    function loadRoles() {
        $.ajax({
            url: 'api/roles_get.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    renderRoles(response.data);
                } else {
                    showError('Failed to load roles: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                showError('Failed to load roles: ' + error);
            }
        });
    }

    // Render roles
    function renderRoles(roles) {
        roleList.empty();
        roles.forEach(role => {
            roleList.append(createRoleCard(role));
        });
        initTooltips();
    }

    // Create role card
    function createRoleCard(role) {
        return `
            <div class="card mb-2">
                <div class="card-body p-2">
                    <div class="row align-items-center" data-role-id="${role.role_id}">
                        <div class="col-lg-10 col-md-8 col-sm-12">
                            <span class="fw-bold">Role ID: ${role.role_id}</span>
                            <span class="role-name">${role.role_name}</span>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-12 text-end">
                            <button class="btn btn-sm btn-primary edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                            <button class="btn btn-sm btn-success save-btn d-none" data-bs-toggle="tooltip" data-bs-placement="top" title="Save">
                                <i class="bi bi-check-lg"></i>
                            </button>
                            <button class="btn btn-sm btn-secondary cancel-btn d-none" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Add new role
    addRoleForm.on('submit', function(e) {
        e.preventDefault();
        const roleName = $('#newRoleName').val();
        $.ajax({
            url: 'api/roles_add.php',
            method: 'POST',
            data: { role_name: roleName },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showSuccess('Role added successfully');
                    $('#newRoleName').val('');
                    loadRoles();
                } else {
                    showError('Failed to add role: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                showError('Failed to add role: ' + error);
            }
        });
    });

    // Edit role
    roleList.on('click', '.edit-btn', function() {
        const card = $(this).closest('.card');
        const roleId = card.find('.row').data('role-id');
        const roleName = card.find('.role-name');
        
        roleName.html(`<input type="text" class="form-control form-control-sm" value="${roleName.text()}">`);
        
        card.find('.edit-btn, .delete-btn').addClass('d-none');
        card.find('.save-btn, .cancel-btn').removeClass('d-none');
        
        $('.edit-btn').not(this).prop('disabled', true);
    });

    // Save edited role
    roleList.on('click', '.save-btn', function() {
        const card = $(this).closest('.card');
        const roleId = card.find('.row').data('role-id');
        const newRoleName = card.find('.role-name input').val();

        $.ajax({
            url: 'api/roles_update.php',
            method: 'POST',
            data: { role_id: roleId, role_name: newRoleName },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showSuccess('Role updated successfully');
                    loadRoles();
                } else {
                    showError('Failed to update role: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                showError('Failed to update role: ' + error);
            }
        });
    });

    // Cancel editing
    roleList.on('click', '.cancel-btn', function() {
        loadRoles();
    });

    // Delete role
    roleList.on('click', '.delete-btn', function() {
        if (confirm('Are you sure you want to delete this role?')) {
            const card = $(this).closest('.card');
            const roleId = card.find('.row').data('role-id');

            $.ajax({
                url: 'api/roles_delete.php',
                method: 'POST',
                data: { role_id: roleId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showSuccess('Role deleted successfully');
                        loadRoles();
                    } else {
                        showError('Failed to delete role: ' + response.error);
                    }
                },
                error: function(xhr, status, error) {
                    showError('Failed to delete role: ' + error);
                }
            });
        }
    });

    // Initialize tooltips
    function initTooltips() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Helper functions for success and error messages
    function showSuccess(message) {
        // Implement success notification (e.g., toast)
        console.log('Success:', message);
    }

    function showError(message) {
        // Implement error notification (e.g., toast)
        console.error('Error:', message);
    }

    // Initial load
    loadRoles();
});